window.onload = checkAuthorization;

function checkAuthorization() {
    if (window.localStorage.getItem("token")) {
        getMailBoxes();
        getMails();
    } else {
        sessionStorage.setItem('notLoggedMessage', 'Моля влезте в профила си!');
        backToLogin();
    }
}

function getMailBoxes() {
    const token = window.localStorage.getItem("token");
    const email = window.localStorage.getItem("email");

    const xhr = new XMLHttpRequest();
    xhr.responseType = 'json';
    xhr.onload = function() {
        if (xhr.status === 200) {
            fillBoxes(xhr.response);
        } else {
            console.error("Error! Failed to fetch mailboxes!");
        }
    };
    xhr.open('GET', '../../backend/api/get_user_mailboxes.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('Authorization', "JWT " + token);
    xhr.setRequestHeader('Email', email);
    xhr.send();
}

function fillBoxes(data) {
    var list = document.getElementById("user-boxes")
    for (var i = 0; i < data.length; i++) {
        var item = document.createElement('li');
        item.appendChild(document.createTextNode(data[i].box_name));
        list.appendChild(item);
    }
}

function showHideMailBoxes() {
    var element = document.getElementById("mail-boxes");
    if (element.style.display === "block") {
        element.style.display = "none";
    } else {
        element.style.display = "block";
    }
}

function getMails() {
    const token = window.localStorage.getItem("token");
    const email = window.localStorage.getItem("email");
    // const box_name = "General";

    data = {'box_name': "General"};
    const xhr = new XMLHttpRequest();
    xhr.responseType = 'json';
    xhr.onload = function() {
        if (xhr.status === 200) {
            fillMails(xhr.response);
        } else {
            console.log(xhr.response);
            console.error("Error! Failed to fetch mailboxes!");
        }
    };
    xhr.open('POST', '../../backend/api/get_mails.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('Authorization', "JWT " + token);
    xhr.setRequestHeader('Email', email);
    xhr.send(JSON.stringify(data));
}

function fillMails(data) {
    for (var i = 0; i < data.length; i++) {
        var list = document.createElement("ul");
        for (const key in data[i]) {
            var item = document.createElement('li');
            item.appendChild(document.createTextNode(data[i][key]));
            list.appendChild(item);
        }
        document.getElementById("main-frame").appendChild(list);
    }
}

function exit() {
    window.localStorage.removeItem("token");
    window.localStorage.removeItem("email");

    window.location.href = '../login/login.php';
}

function backToLogin() {
    window.location.href = '../login/login.php';
}