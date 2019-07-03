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
    xhr.open('GET', '../../backend/api/mailbox.php', true);
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

function changePlaceholder(radio) {
    const input = document.getElementById("reciever");
    if (radio.value == 1) {
        input.placeholder = "Имейл адрес";
    } else {
        input.placeholder = "Номер на тема на реферат";
    }
}

function sendMail() {
    const token = window.localStorage.getItem("token");
    const email = window.localStorage.getItem("email");
    const type = document.getElementById("mail-type").value;
    const reciever = document.getElementById("message-reciever").value;
    const subjct = document.getElementById("subject").value;
    const message = document.getElementById("message").value;

    data = {"type": type, "reciever": reciever, "subject": subjct, "message": message}
    console.log(data);
    const xhr = new XMLHttpRequest();
    xhr.responseType = 'json';
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log("Message Send");
            // window.location.href = '../mainpage/mainpage.php';
        } else {
            console.error("Error! Failed to send message!");
        }
    };
    xhr.open('POST', '../../backend/api/mail.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('Authorization', "JWT " + token);
    xhr.setRequestHeader('Email', email);
    xhr.send(JSON.stringify(data));
}

function exit() {
    window.localStorage.removeItem("token");
    window.localStorage.removeItem("email");
    backToLogin();
}

function backToLogin() {
    window.location.href = '../login/login.php';
}