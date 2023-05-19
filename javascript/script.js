/* MANAGE ACTIVE MENU LINK */
const currentUrl = "/.." + window.location.pathname;
const currentPageLink = document.querySelector(
  `#menu li a[href="${currentUrl}"]`
);

if (currentPageLink) {
  const currentPageLinkParent = currentPageLink.parentElement;
  currentPageLinkParent.classList.add("active");
}

/******************************************/
// MANAGE ATTACHMENT ICON IN COMMENT FORM
document.addEventListener("DOMContentLoaded", function () {
  const fileUpload = document.querySelector(".comment-form #file-upload");
  if (fileUpload) {
    fileUpload.addEventListener("click", function () {
      const fileInput = document.querySelector('.comment-form input[type="file"]');
      fileInput.click();
    });

    const fileInput = document.querySelector('.comment-form input[type="file"]');
    fileInput.addEventListener("change", function () {
      const fileName = document.querySelector(".comment-form #file-name");
      fileName.textContent =
        this.files.length > 1 ? this.files.length + " files" : this.files[0].name;
    });
}


/******************************************/
// FAQ

const answerFaq = document.getElementById("faq-select");
const faqIcon = document.getElementById("faq-answer");
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
const faqOptions = document.querySelectorAll("#faq-select select");
const commentTextarea = document.querySelector(".comment-form textarea");

faqOptions.forEach(function (option) {
  option.addEventListener("change", function () {
    commentTextarea.value = option.value;
  });
});
});

/******************************************/
// FAQ click event
const faqItems = document.querySelectorAll(".faq li h2");
if (faqItems) {
  faqItems.forEach(function (item) {
    item.addEventListener("click", function () {
      const answer = this.parentElement.nextSibling;
      answer.classList.toggle("active");
    });
  });
}
/******************************************/
// FAQ DELETE click event, send AJAX request for action_delete_faq.php
const faqDelete = document.querySelectorAll(".faq header button");

if (faqDelete) {
  faqDelete.forEach(function (item) {
    item.addEventListener("click", function () {
      let xhr = new XMLHttpRequest();
      let formData = new FormData();
      const li = this.parentElement.parentElement;
      formData.append("id", li.id);
      xhr.open("POST", "../actions/delete/action_delete_faq.php");
      xhr.onload = function () {
        if (this.status == 200) {
          li.remove();
        }
      };
      xhr.send(formData);
    });
  });
}