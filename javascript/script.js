/* MANAGE ACTIVE MENU LINK */
const currentUrl = "/.." + window.location.pathname;
let currentPageLink = document.querySelector(
  `#menu li a[href="${currentUrl}"]`
);

if (currentPageLink) {
  let currentPageLinkParent = currentPageLink.parentElement;
  currentPageLinkParent.classList.add("active");
}
console.log("currentUrl:", currentUrl);
console.log("currentPageLink:", currentPageLink);

/******************************************/
// MANAGE ATTACHMENT ICON IN COMMENT FORM
document.addEventListener("DOMContentLoaded", function () {
  let fileUpload = document.querySelector(".comment-form #file-upload");
  fileUpload.addEventListener("click", function () {
    let fileInput = document.querySelector('.comment-form input[type="file"]');
    fileInput.click();
  });

  let fileInput = document.querySelector('.comment-form input[type="file"]');
  fileInput.addEventListener("change", function () {
    let fileName = document.querySelector(".comment-form #file-name");
    fileName.textContent =
      this.files.length > 1 ? this.files.length + " files" : this.files[0].name;
  });

  let answerFaq = document.getElementById("faq-select");
  let faqIcon = document.getElementById("faq-answer");
  console.log(faqIcon);
  if (faqIcon) {
    faqIcon.addEventListener("click", function () {
      if (answerFaq.style.display == "flex") {
        answerFaq.style.display = "none";
      } else {
        answerFaq.style.display = "flex";
      }
    });
  }

  // if an option is selected, put the answer in the textarea
  let faqOptions = document.querySelectorAll("#faq-select select");
  let commentTextarea = document.querySelector(".comment-form textarea");

  faqOptions.forEach(function (option) {
    option.addEventListener("change", function () {
      commentTextarea.value = option.value;
    });
  });
});

/******************************************/
// FAQ click event
let faqItems = document.querySelectorAll(".faq li h2");
faqItems.forEach(function (item) {
  item.addEventListener("click", function () {
    let answer = this.parentElement.nextSibling;
    answer.classList.toggle("active");
  });
});

/******************************************/
// FAQ DELETE click event, send AJAX request for action_delete_faq.php
let faqDelete = document.querySelectorAll(".faq header button");
faqDelete.forEach(function (item) {
  item.addEventListener("click", function () {
    let xhr = new XMLHttpRequest();
    let formData = new FormData();
    let li = this.parentElement.parentElement;
    formData.append("id", li.id);
    xhr.open("POST", "../actions/action_delete_faq.php");
    xhr.onload = function () {
      if (this.status == 200) {
        li.remove();
      }
    };
    xhr.send(formData);
  });
});
