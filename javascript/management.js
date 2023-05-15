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
        console.log(field);
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

/******************************************/
// manage tab redirect
const urlParams = new URLSearchParams(window.location.search);
const tab = urlParams.get('tab');
if (tab) {
    tabs[tab].click();
}



