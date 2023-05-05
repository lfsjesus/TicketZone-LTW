const currentUrl  = "/.." + window.location.pathname;
let currentPageLink = document.querySelector(`#menu li a[href="${currentUrl}"]`);

if (currentPageLink) {
    let currentPageLinkParent = currentPageLink.parentElement;
    currentPageLinkParent.classList.add('active');
}
console.log('currentUrl:', currentUrl);
console.log('currentPageLink:', currentPageLink);


/******************************************/
// MANAGE ATTACHMENT ICON IN COMMENT FORM


document.addEventListener('DOMContentLoaded', function() {
    let fileUpload = document.querySelector('.comment-form #file-upload');
    fileUpload.addEventListener('click', function() {
      let fileInput = document.querySelector('.comment-form input[type="file"]');
      fileInput.click();
    });

    let fileInput = document.querySelector('.comment-form input[type="file"]');
    fileInput.addEventListener('change', function() {
        let fileName = document.querySelector('.comment-form #file-name');
        fileName.textContent = this.files.length > 1 ? this.files.length + " files" : this.files[0].name;
    })
    
  });


/******************************************/
// AJAX TO UPDATE TABLE OF CONTENTS
const submitBtn = document.querySelector('.ticket-list button[type="submit"]');



// add event listener to submit button prevent default
submitBtn.addEventListener('click', function(e) {
    e.preventDefault();
    updateTableData();
  });

window.addEventListener('load', function() {
submitBtn.click();
});

// select all the possible options
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
                        <td><input type="checkbox" name="ticket[]"></td>
                        <td class="table-title">${ticket.ticketCreator.firstName + ' ' + ticket.ticketCreator.lastName}</td>
                        <td class="table-title"><a href="ticket.php?id=${ticket.id}">${ticket.title}</a></td>
                        <td rowspan="2" class="table-title">${ticket.ticketAssignee.firstName + ' ' + ticket.ticketAssignee.lastName}</td>
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

// add event listener to pagination after it is created, add class active to the one clicked
let pagination = document.querySelector('.pagination');

pagination.addEventListener('click', function(e) {
  if (e.target.tagName == 'A') {
    e.preventDefault();
    let page = e.target.getAttribute('page');
    updateTableData(page);
  }
});
