let editBtn = document.querySelector('.ticket-body form .ticket-header > span');
let title = document.querySelector('.ticket-body form .ticket-header > h1');
let description = document.querySelector('.ticket-body form .ticket-description');

editBtn.addEventListener('click', function() {
    console.log(editBtn.classList);
    if (editBtn.classList.contains('save')) {
        let form = document.querySelector('.ticket-body form');
        // only send title and description
        let formData = new FormData(form);
        formData.delete('status');
        formData.delete('priority');
        formData.delete('department');
        formData.delete('assignee');
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_edit_ticket.php');
        xhr.onload = function() {
            if (this.status == 200) {
                console.log("Ticket edited");
                location.reload();
            }
        }
        xhr.send(formData);
    }
    else {
        title.outerHTML = `<input type="text" name="title" value="${title.textContent}">`;
        description.outerHTML = `<textarea name="description" class="ticket-description" cols="30" rows="10">${description.textContent}</textarea>`;
        editBtn.innerHTML = 'save';
        editBtn.classList.add('save');
    }
});

// if any change on form input (except title and description) send form data to action_edit_ticket.php
let form = document.querySelector('.ticket-body form');
let selects = document.querySelectorAll('.ticket-body form select');

form.addEventListener('submit', function(e) {
    e.preventDefault();
});

selects.forEach(select => {
    select.addEventListener('change', function() {
        let formData = new FormData(form);
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
);