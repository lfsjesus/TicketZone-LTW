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


// hashtags

let hashtags = document.querySelector('.ticket-body form .ticket-hashtags');
let input = document.querySelector('.ticket-body form input[name="hashtags"]');
let datalist = document.querySelector('.ticket-body form datalist');
let suggestions = document.querySelectorAll('.ticket-body form datalist option');
console.log(suggestions);

input.addEventListener('keyup', function(e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        let hashtag = input.value;
        let ticket_id = document.querySelector('.ticket-body form input[name="id"]').value;
        let xhr = new XMLHttpRequest();
        xhr.open('GET', `../actions/action_add_hashtag.php?hashtag_name=${hashtag}&ticket_id=${ticket_id}`);
        xhr.onload = function() {
            if (this.status == 200) {
                console.log("Hashtag added");
                let returned_id = this.responseText;
                let li = document.createElement('li');
                let a = document.createElement('a');
                let span = document.createElement('span');
                span.classList.add('material-symbols-outlined');
                span.innerHTML = 'close';
                a.setAttribute('href', '');
                a.setAttribute('id', returned_id);
                a.innerHTML = `${hashtag}`;
                a.appendChild(span);
                li.appendChild(a);
                hashtags.appendChild(li);
                a.addEventListener('click', handleHashtagRemoval);
                input.value = '';
                

            }
        }
        xhr.send();
    }
}
);

let hashtagLinks = document.querySelectorAll('.ticket-body form .ticket-hashtags li a');
hashtagLinks.forEach(hashtagLink => {
    hashtagLink.addEventListener('click', handleHashtagRemoval);
}
);

function handleHashtagRemoval(e) {
    e.preventDefault();
    let hashtag_id = e.target.getAttribute('id');
    let ticket_id = document.querySelector('.ticket-body form input[name="id"]').value;
    let xhr = new XMLHttpRequest();
    xhr.open('GET', `../actions/action_remove_hashtag.php?hashtag_id=${hashtag_id}&ticket_id=${ticket_id}`);
    xhr.onload = function() {
        if (this.status == 200) {
            console.log("Hashtag removed");
            e.target.parentElement.remove();
        }
    }
    xhr.send();
}
