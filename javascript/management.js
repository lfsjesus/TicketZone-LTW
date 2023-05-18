/******************************************/
// mark as active the tab clicked, being the first one the default

let tabs = document.querySelectorAll(".tabs a");
tabs.forEach(function (tab) {
  tab.addEventListener("click", function () {
    tabs.forEach(function (tab) {
      tab.classList.remove("active");
    });
    this.classList.add("active");
  });
});

// according to the tab clicked, show the corresponding content by adding the class active #management-page > section
let tabsContent = document.querySelectorAll("#management-page > section");
for (let i = 0; i < tabs.length; i++) {
  tabs[i].addEventListener("click", function () {
    tabsContent.forEach(function (tab) {
      tab.classList.remove("active");
    });
    tabsContent[i].classList.add("active");
  });
}

/******************************************/
// MANAGE USER UPGRADE
document.addEventListener("DOMContentLoaded", () => {
  const tbody = document.querySelector(".people table tbody");

  tbody.addEventListener("change", (event) => {
    const target = event.target;

    if (target.tagName === "SELECT") {
      const xhr = new XMLHttpRequest();
      const formData = new FormData();
      const user_id = target
        .closest("tr")
        .querySelector('input[type="hidden"]').value;
      const field = target.name;
      console.log(field);
      formData.append("user_id", user_id);
      formData.append(field, target.value);
      xhr.open("POST", "../actions/action_upgrade_user.php");
      xhr.onload = function () {
        if (this.status == 200) {
          console.log("success");
        }
      };
      xhr.send(formData);
    }
  });
});

/******************************************/
// manage tab redirect
const urlParams = new URLSearchParams(window.location.search);
const tab = urlParams.get("tab");
if (tab) {
  tabs[tab].click();
}

/* people search */

const searchInput = document.querySelector(".search-form input");

function updateTablePeople(page = 1) {
  let tbody = document.querySelector(".people table tbody");
  let form = document.querySelector(".people table form");
  let formData = new FormData(form);
  formData.append("search", searchInput.value);
  formData.append("page", page);
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "../api/people_api.php?" + new URLSearchParams(formData));
  xhr.onload = function () {
    if (this.status == 200) {
      let response = JSON.parse(this.responseText);
      tbody.innerHTML = "";
      if (response.users.length > 0) {
        response.users.forEach((person) => {
          let tr = document.createElement("tr");
          tr.innerHTML = `
                    <input type="hidden" name="id" value="${person.id}">
                    <td>${person.firstName + " " + person.lastName}</td>
                    <td>${person.email}</td>
                    <td>
                        <select name="department_id">
                            <option value="" disabled selected hidden></option>
                            ${response.departments
                              .map((department) => {
                                return `<option value="${department.id}" ${
                                  person.department &&
                                  department.id == person.department.id
                                    ? "selected"
                                    : ""
                                }>${department.name}</option>`;
                              })
                              .join("")}
                    </td>
                    <td>
                        <select name="type">
                        <option value="client" ${
                          person.type == "client" ? "selected" : ""
                        }>Client</option>
                        <option value="agent" ${
                          person.type == "agent" ? "selected" : ""
                        }>Agent</option>
                        <option value="admin" ${
                          person.type == "admin" ? "selected" : ""
                        }>Admin</option>
                        </select>
                    </td>
                    <td>
                        <form action="../actions/action_delete_user.php" method="post">
                            <button class="delete" name="id" value="${
                              person.id
                            }" type="submit"><span class="material-symbols-outlined">delete</span></button>
                        </form>
                    </td>
                    `;
          tbody.appendChild(tr);
        });
      } else {
        let tr = document.createElement("tr");
        tr.innerHTML = `
                <td colspan="5">No results found</td>
                `;
        tbody.appendChild(tr);
      }
      let pagination = document.querySelector(".pagination");
      pagination.innerHTML = "";
      let pages = (response.count + 6) / 7;
      for (let i = 1; i <= pages; i++) {
        let li = document.createElement("li");
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

// add event listener in selects of table header
let selectsThead = document.querySelectorAll(".people table thead select");
selectsThead.forEach(function (select) {
  select.addEventListener("change", function () {
    updateTablePeople();
  });
});

// add event listener in search input
if (searchInput) {
  searchInput.parentElement.addEventListener("submit", function (e) {
    e.preventDefault();
  });
  searchInput.addEventListener("input", async function () {
    updateTablePeople();
  });
}

window.addEventListener("load", function () {
  updateTablePeople();
});

/* PAGINATION MANAGEMENT OF TABEL TICKETS */
let pagination = document.querySelector(".pagination");
pagination.addEventListener("click", function (e) {
  if (e.target.tagName == "A") {
    e.preventDefault();
    let page = e.target.getAttribute("page");
    updateTablePeople(page);
  }
});
