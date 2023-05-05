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

