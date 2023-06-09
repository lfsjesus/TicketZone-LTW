/* TABLE CONTENT GENERATION AND FILTERING */
window.addEventListener("load", function () {
  updateTableData();
});

const option = document.querySelectorAll(".ticket-list select");
option.forEach((option) => {
  option.addEventListener("change", function () {
    updateTableData();
  });
});

const search = document.querySelector(".search-form input");
if (search) {
  search.parentElement.addEventListener("submit", function (e) {
    e.preventDefault();
  });
  search.addEventListener("input", async function () {
    updateTableData();
  });
}

function updateTableData(page = 1) {
  const tbody = document.querySelector(".ticket-list tbody");
  const form = document.querySelectorAll(".ticket-list thead select");
  let formData = new FormData();
  form.forEach((input) => {
    formData.append(input.name, input.value);
  });
  formData.append("search", search.value);
  formData.append("page", page);
  // send data to server using ajax
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "../api/api.php?" + new URLSearchParams(formData));
  xhr.onload = function () {
    if (this.status == 200) {
      let response = JSON.parse(this.responseText);
      console.log(response);
      if (response.tickets.length > 0) {
        // update table of contents
        const tickets = response.tickets;
        tbody.innerHTML = "";
        tickets.forEach((ticket) => {
          const tr = document.createElement("tr");
          const date = new Date(ticket.dateCreated.date);
          const formattedDate =
            date.getDate().toString().padStart(2, "0") +
            "/" +
            (date.getMonth() + 1).toString().padStart(2, "0") +
            "/" +
            date.getFullYear() +
            " " +
            date.getHours().toString().padStart(2, "0") +
            ":" +
            date.getMinutes().toString().padStart(2, "0");

          tr.innerHTML = `
                        <td><input type="checkbox" value="${
                          ticket.id
                        }" name="ticket[]"></td>
                        <td class="table-title"><a href="${
                          ticket.ticketCreator != null
                            ? "user_profile_page.php?id=" + ticket.ticketCreator.id
                            : ""
                        }">${
            ticket.ticketCreator != null
              ? ticket.ticketCreator.firstName +
                " " +
                ticket.ticketCreator.lastName
              : ""
          }</td>
                        <td class="table-title"><a href="ticket_page.php?id=${
                          ticket.id
                        }">${ticket.title}</a></td>
                        <td rowspan="2" class="table-title"><a href="${
                          ticket.ticketAssignee != null
                            ? "user_profile_page.php?id=" + ticket.ticketAssignee.id
                            : ""
                        }">${
            ticket.ticketAssignee != null
              ? ticket.ticketAssignee.firstName +
                " " +
                ticket.ticketAssignee.lastName
              : ""
          }</td>
                        <td rowspan="2" class="table-title">${
                          ticket.status
                        }</td>
                        <td rowspan="2" class="table-title"><div class="${
                          ticket.priority != null
                            ? "priority-" + ticket.priority.toLowerCase()
                            : ""
                        }">${ticket.priority ?? ""}</td>
                        <td rowspan="2" class="table-title">${
                          ticket.department != null
                            ? ticket.department.name
                            : ""
                        }</td>
                        <td rowspan="2" class="table-title">${formattedDate}</td>
                    `;
          const tr2 = document.createElement("tr");
          tr2.innerHTML = `
                        <td></td>
                        <td>${
                          ticket.ticketCreator != null
                            ? ticket.ticketCreator.email
                            : ""
                        }</td>
                        <td>${ticket.description.substring(0, 15) + "..."}</td>
                    `;
          tbody.appendChild(tr);
          tbody.appendChild(tr2);
        });
      } else {
        tbody.innerHTML = '<tr><td colspan="7">No tickets found</td></tr>';
      }
      const pagination = document.querySelector(".pagination");
      pagination.innerHTML = "";
      const pages = (response.count + 6) / 7;
      for (let i = 1; i <= pages; i++) {
        const li = document.createElement("li");
        li.innerHTML = `<a href="#" page="${i}">${i}</a>`;
        if (i == page) {
          li.classList.add("active");
        }
        pagination.appendChild(li);
      }
    }
  };
  xhr.send();
}

/* PAGINATION MANAGEMENT OF TABEL TICKETS */
const pagination = document.querySelector(".pagination");
pagination.addEventListener("click", function (e) {
  if (e.target.tagName == "A") {
    e.preventDefault();
    let page = e.target.getAttribute("page");
    updateTableData(page);
  }
});

/* TICKET SELECTION AND ACTIONS DISPLAY */
const theadCheckbox = document.querySelector(
  '.ticket-list thead input[type="checkbox"]'
);
theadCheckbox.addEventListener("click", function () {
  const checkboxes = document.querySelectorAll(
    '.ticket-list tbody input[type="checkbox"]'
  );
  checkboxes.forEach((checkbox) => {
    checkbox.checked = this.checked;
  });
});

const ticketOptions = document.querySelector(".ticket-options");
document.addEventListener("click", function () {
  const checkboxes = document.querySelectorAll(
    '.ticket-list tbody input[type="checkbox"]'
  );
  let checked = false;
  checkboxes.forEach((checkbox) => {
    if (checkbox.checked) {
      checked = true;
    }
  });
  if (checked) {
    ticketOptions.style.display = "flex";
  } else {
    ticketOptions.style.display = "none";
  }
});

function getCheckedCheckboxes() {
  const checkboxes = document.querySelectorAll(
    '.ticket-list tbody input[type="checkbox"]'
  );
  let checked = [];
  checkboxes.forEach((checkbox) => {
    if (checkbox.checked) {
      checked.push(checkbox.value);
    }
  });
  return checked;
}

/* TICKET ACTIONS */
const deleteBtn = document.querySelector(".ticket-options .delete");
deleteBtn.addEventListener("click", function (e) {
  e.preventDefault();
  const checked = getCheckedCheckboxes();
  if (checked.length > 0) {
    checked.forEach((id) => {
      let xhr = new XMLHttpRequest();
      let formData = new FormData();
      formData.append("id", id);
      xhr.open("POST", "../actions/delete/action_delete_ticket.php");
      xhr.onload = function () {
        if (this.status == 200) {
          console.log("Ticket deleted");
        }
      };
      xhr.send(formData);
    });
  }
  location.reload();
});

const form = document.querySelector("form.ticket-options");
form.addEventListener("change", function (e) {
  const checked = getCheckedCheckboxes();
  if (checked.length > 0) {
    let formData = new FormData(form);
    checked.forEach((id) => {
      formData.append("id", id);
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "../actions/edit/action_edit_ticket.php");
      xhr.onload = function () {
        if (this.status == 200) {
          console.log("Ticket edited");
          location.reload();
        }
      };
      xhr.send(formData);
    });
  }
});
