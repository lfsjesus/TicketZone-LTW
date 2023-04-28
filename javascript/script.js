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
console.log(submitBtn);

// add event listener to submit button prevent default
submitBtn.addEventListener('click', function(e) {
    e.preventDefault();
    let form = document.querySelector('.ticket-list form');
    // get data from form
    let formData = new FormData(form);
    let tbody = document.querySelector('.ticket-list tbody');
    tbody.innerHTML = '';

    // send data to server using ajax
    let xhr = new XMLHttpRequest();
    console.log(formData);
    xhr.open('GET', '../api/api.php?' + new URLSearchParams(formData));
    console.log('../api/api.php?' + new URLSearchParams(formData));

    xhr.onload = function() {
        if (this.status == 200) {
            let response = JSON.parse(this.responseText);
            if (response.length > 0) {
                // update table of contents
                let tickets = response;
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
                        <td rowspan="2" class="table-title">${formattedDate}</td>
                    `
                    ;
                    console.log(ticket.dateCreated)
                    let tr2 = document.createElement('tr');
                    tr2.innerHTML = `
                        <td></td>
                        <td>${ticket.ticketCreator.email}</td>
                        <td>${ticket.description.substring(0, 15) + '...'}</td>
                    `;
                    console.log(tr);
                    tbody.appendChild(tr);
                    tbody.appendChild(tr2);
                });

            }
        }

    };

    xhr.send();
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