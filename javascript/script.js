/* MANAGE ACTIVE MENU LINK */
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
// FAQ click event
let faqItems = document.querySelectorAll('.faq li h2');
faqItems.forEach(function(item) {
    item.addEventListener('click', function() {
        let answer = this.parentElement.nextSibling;
        answer.classList.toggle('active');
    })
}
);

/******************************************/
// FAQ DELETE click event, send AJAX request for action_delete_faq.php
let faqDelete = document.querySelectorAll('.faq header button');
faqDelete.forEach(function(item) {
    item.addEventListener('click', function() {
        let xhr = new XMLHttpRequest();
        let formData = new FormData();
        let li = this.parentElement.parentElement;
        formData.append('id', li.id);
        xhr.open('POST', '../actions/action_delete_faq.php');
        xhr.onload = function() {
            if (this.status == 200) {
                li.remove();
            }
        }
        xhr.send(formData);
    })
}
);

/******************************************/
// mark as active the tab clicked, being the first one the default

let tabs = document.querySelectorAll('.tabs a');
tabs.forEach(function(tab) {
    tab.addEventListener('click', function() {
        tabs.forEach(function(tab) {
            tab.classList.remove('active');
        })
        this.classList.add('active');
    })
}
);

// according to the tab clicked, show the corresponding content by adding the class active #management-page > section
let tabsContent = document.querySelectorAll('#management-page > section');
for (let i = 0; i < tabs.length; i++) {
    tabs[i].addEventListener('click', function() {
        tabsContent.forEach(function(tab) {
            tab.classList.remove('active');
        })
        tabsContent[i].classList.add('active');
    })
}

/******************************************/
// MANAGE USER UPGRADE

let selects = document.querySelectorAll('.people table select');
selects.forEach(function(select) {
    select.addEventListener('change', function() {
        let xhr = new XMLHttpRequest();
        let formData = new FormData();
        let user_id = this.parentElement.parentElement.querySelector('input[type="hidden"]').value;
        let field = this.name;
        formData.append('user_id', user_id);
        formData.append(field, this.value);  
        xhr.open('POST', '../actions/action_upgrade_user.php');
        xhr.onload = function() {
            if (this.status == 200) {
                console.log('success');
            }
        }
        xhr.send(formData);
    })
}
);
