/* TABLE CONTENT GENERATION AND FILTERING */
const submitBtn = document.querySelector('.ticket-list button[type="submit"]');
submitBtn.addEventListener('click', function(e) {
    e.preventDefault();
    updateTableData();
  });

window.addEventListener('load', function() {
submitBtn.click();
});

const option = document.querySelectorAll('.ticket-list select');
option.forEach(option => {
    option.addEventListener('change', function() {
        submitBtn.click();
    });
}
);

const search = document.querySelector('.search-form input');
if (search) {
    search.addEventListener('input', async function() {
        updateTableData();
    });
}

function updateTableData(page = 1) {
    let tbody = document.querySelector('.ticket-list tbody');
    let form = document.querySelector('.ticket-list form');
    let formData = new FormData(form);
    formData.append('search', search.value);
    formData.append('page', page);
    // send data to server using ajax        
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '../api/api.php?' + new URLSearchParams(formData));
    xhr.onload = function() {
        if (this.status == 200) {
            let response = JSON.parse(this.responseText);
            console.log(response);
            if (response.tickets.length > 0) {
                // update table of contents
                let tickets = response.tickets;
                tbody.innerHTML = '';
                tickets.forEach(ticket => {
                    let tr = document.createElement('tr');
                    const date = new Date(ticket.dateCreated.date);
                    const formattedDate = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
                    tr.innerHTML = `
                        <td><input type="checkbox" value="${ticket.id}" name="ticket[]"></td>
                        <td class="table-title">${ticket.ticketCreator.firstName + ' ' + ticket.ticketCreator.lastName}</td>
                        <td class="table-title"><a href="ticket.php?id=${ticket.id}">${ticket.title}</a></td>
                        <td rowspan="2" class="table-title">${ticket.ticketAssignee != null ? ticket.ticketAssignee.firstName + ' ' + ticket.ticketAssignee.lastName : ''}</td>
                        <td rowspan="2" class="table-title">${ticket.status}</td>
                        <td rowspan="2" class="table-title"><div class="${ticket.priority != null ? 'priority-' + ticket.priority.toLowerCase() : ''}">${ticket.priority ?? ''}</td>
                        <td rowspan="2" class="table-title">${ticket.department != null ? ticket.department.name : ''}</td>
                        <td rowspan="2" class="table-title">${formattedDate}</td>
                    `
                    ;
                    let tr2 = document.createElement('tr');
                    tr2.innerHTML = `
                        <td></td>
                        <td>${ticket.ticketCreator.email}</td>
                        <td>${ticket.description.substring(0, 15) + '...'}</td>
                    `;
                    tbody.appendChild(tr);
                    tbody.appendChild(tr2);
                });
                let pagination = document.querySelector('.pagination');
                pagination.innerHTML = '';
                let pages = (response.count + 6) / 7;
                for (let i = 1; i <= pages; i++) {
                    let li = document.createElement('li');
                    li.innerHTML = `<a href="#" page="${i}">${i}</a>`;
                    if (i == page) {
                        li.classList.add('active');
                    }
                    pagination.appendChild(li);
                }

            }
            else {
                tbody.innerHTML = '<tr><td colspan="7">No tickets found</td></tr>';
            }
        }

    }
    xhr.send();
}

/* PAGINATION MANAGEMENT OF TABEL TICKETS */
let pagination = document.querySelector('.pagination');
pagination.addEventListener('click', function(e) {
  if (e.target.tagName == 'A') {
    e.preventDefault();
    let page = e.target.getAttribute('page');
    updateTableData(page);
  }
});

/* TICKET SELECTION AND ACTIONS DISPLAY */
let theadCheckbox = document.querySelector('.ticket-list thead input[type="checkbox"]');
theadCheckbox.addEventListener('click', function() {
    let checkboxes = document.querySelectorAll('.ticket-list tbody input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
}
);

let ticketOptions = document.querySelector('.ticket-options');
document.addEventListener('click', function() {
    let checkboxes = document.querySelectorAll('.ticket-list tbody input[type="checkbox"]');
    let checked = false;
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            checked = true;
        }
    });
    if (checked) {
        ticketOptions.style.display = 'flex';
    }
    else {
        ticketOptions.style.display = 'none';
    }
}
);

function getCheckedCheckboxes() {
    let checkboxes = document.querySelectorAll('.ticket-list tbody input[type="checkbox"]');
    let checked = [];
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            checked.push(checkbox.value);
        }
    });
    return checked;
}

/* TICKET ACTIONS */
let deleteBtn = document.querySelector('.ticket-options .delete-ticket');
console.log(deleteBtn);
deleteBtn.addEventListener('click', function() {
    let checked = getCheckedCheckboxes();
    console.log(checked);
    if (checked.length > 0) {
        checked.forEach(id => {
            let xhr = new XMLHttpRequest();
            xhr.open('GET', '../actions/action_delete_ticket.php?id=' + id);
            xhr.onload = function() {
                if (this.status == 200) {
                    console.log("Ticket deleted");
                }
            }
            xhr.send();
        });
    }
}
);

let form = document.querySelector('form.ticket-options');
form.addEventListener('change', function(e) {
    let checked = getCheckedCheckboxes();
    if (checked.length > 0) {
        let formData = new FormData(form);
        checked.forEach(id => {
        formData.append('id', id);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_edit_ticket.php');
        xhr.onload = function() {
            if (this.status == 200) {
                console.log("Ticket edited");
                location.reload();
            }
        }
        xhr.send(formData);
        });
    }
}
);
