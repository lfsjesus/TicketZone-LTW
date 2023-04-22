const currentUrl  = "/.." + window.location.pathname;
let currentPageLink = document.querySelector(`#menu a[href="${currentUrl}"]`);

if (currentPageLink) {
    let currentPageLinkParent = currentPageLink.parentElement;
    currentPageLinkParent.classList.add('active');
}
console.log('currentUrl:', currentUrl);
console.log('currentPageLink:', currentPageLink);
