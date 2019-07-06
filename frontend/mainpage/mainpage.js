window.onload = checkAuthorization;

function checkAuthorization() {
    if (window.localStorage.getItem("token")) {
        getMailBoxes();
        getMails("Главна");
    } else {
        sessionStorage.setItem('notLoggedMessage', 'Моля влезте в профила си!');
        backToLogin();
    }
}

// Mail boxes
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
    if (data) {
        var list = document.getElementById("user-boxes")
        for (var i = 0; i < data.length; i++) {
            var item = document.createElement('li');
            item.id = data[i].box_name;
            item.appendChild(document.createTextNode(data[i].box_name));
            item.onclick = function(){
                document.getElementById("send-mail").style.display = "none";
                document.getElementById("create-box").style.display = "none";
                document.getElementById("read-mail").style.display = "none";
                document.getElementById("mails").style.display = "block";
                getMails(this.id);
            };
            list.appendChild(item);
        }
    }
}

function boxOnClick(item) {
    document.getElementById("send-mail").style.display = "none";
    document.getElementById("create-box").style.display = "none";
    document.getElementById("read-mail").style.display = "none";
    document.getElementById("mails").style.display = "block";
    getMails(item.id);
}

function showHideMailBoxes() {
    var element = document.getElementById("mail-boxes");
    if (element.style.display === "block") {
        element.style.display = "none";
    } else {
        element.style.display = "block";
    }
}

// Add new mail box
function addMailBox() {
    document.getElementById("mails").style.display = "none";
    document.getElementById("send-mail").style.display = "none";
    document.getElementById("read-mail").style.display = "none";
    document.getElementById("create-box").style.display = "block";
}

function showHideRefNumber(select) {
    if (select.value == 1) {
        document.getElementById("box-ref-number").style.display = "none";
    } else {
        document.getElementById("box-ref-number").style.display = "block";
    }
}

function createBox() {
    const token = window.localStorage.getItem("token");
    const email = window.localStorage.getItem("email");
    const box_name = document.getElementById("box-name").value;
    const box_type = document.getElementById("box-type").value;
    const ref_number = document.getElementById("ref-number").value;
    if (ref_number=="") {
        ref_number = 0;
    }

    data = {"name": box_name, "type": box_type, "ref_number": ref_number};
    if (checkIfEmpty(data) === false) {
        const xhr = new XMLHttpRequest();
        xhr.responseType = 'json';
        xhr.onload = function() {
            if (xhr.status === 200) {
                window.location.href = '../mainpage/mainpage.php';
            } else {
                console.error("Error! Failed to send message!");
            }
        };
        xhr.open('POST', '../../backend/api/mailbox.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Authorization', "JWT " + token);
        xhr.setRequestHeader('Email', email);
        xhr.send(JSON.stringify(data));
    } else {
        document.getElementById('box-name-error').style.display = 'block';
    }
}

// Mails
function getMails(box_name) {
    const token = window.localStorage.getItem("token");
    const email = window.localStorage.getItem("email");

    const xhr = new XMLHttpRequest();
    xhr.responseType = 'json';
    xhr.onload = function() {
        if (xhr.status === 200) {
            window.localStorage.setItem("box_name", box_name);
            fillMails(xhr.response.body);
        } else {
            console.error("Error! Failed to fetch mailboxes!");
        }
    };
    xhr.open('GET', '../../backend/api/mail.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    xhr.setRequestHeader('Authorization', "JWT " + token);
    xhr.setRequestHeader('Email', email);
    xhr.setRequestHeader('Boxname', encodeURI(box_name));
    xhr.send();
}

function fillMails(data) {
    var mails = document.getElementById("mails");
    removeChildren(mails);

    for (var i = 0; i < data.length; i++) {
        var list = document.createElement("ul");
        list.id = data[i].mail_id;
        for (const key in data[i]) {
            if (key !== "mail_id"){
                var item = document.createElement('li');
                item.id = key;
                item.appendChild(document.createTextNode(data[i][key]));
                list.appendChild(item);
            }
        }
        list.onclick = function(){
            document.getElementById("send-mail").style.display = "none";
            document.getElementById("create-box").style.display = "none";
            document.getElementById("mails").style.display = "none";
            document.getElementById("read-mail").style.display = "block";
            getMail(this.id);    
        };
        document.getElementById("mails").appendChild(list);
    }
}


// Send email
function writeMessage(answer) {
    document.getElementById("mails").style.display = "none";
    document.getElementById("create-box").style.display = "none";
    document.getElementById("read-mail").style.display = "none";

    window.localStorage.setItem("is_answer", false);
    if (answer === true) {
        window.localStorage.setItem("is_answer", true);
        if (window.localStorage.getItem("mail_type") == 2) {
            document.getElementById("mail-type2").checked = "checked";
        }
        document.getElementById("message-reciever").value = window.localStorage.getItem("mail_sender");
        document.getElementById("message-subject").value = window.localStorage.getItem("mail_subject");
    }
    document.getElementById("send-mail").style.display = "block";
}

function changePlaceholder(radio) {
    const input = document.getElementById("message-reciever");
    if (radio.value == 1) {
        input.placeholder = "Имейл адрес";
    } else {
        input.placeholder = "Номер на тема на реферат";
    }
}

function sendMail() {
    const token = window.localStorage.getItem("token");
    const email = window.localStorage.getItem("email");
    var type = 1;
    if (document.getElementById("mail-type2").checked) {
        is_answer = window.localStorage.getItem("is_answer");
        if (is_answer) {
            type = 3;
            window.localStorage.setItem("is_answer", false);
        } else {
            type = 2;
        }
    }
    const reciever = document.getElementById("message-reciever").value;
    const subject = document.getElementById("message-subject").value;
    const message = document.getElementById("message").value;

    data = {"type": type, "reciever": reciever, "subject": subject, "message": message};
    if (checkIfEmpty(data) === false) {
        const xhr = new XMLHttpRequest();
        xhr.responseType = 'json';
        xhr.onload = function() {
            if (xhr.status === 200) {
                window.location.href = '../mainpage/mainpage.php';
            } else if (xhr.status === 404) {
                const wrongCredentialsElem = document.getElementById('send-error-message');
                wrongCredentialsElem.style.display = 'block';
            } else {
                console.error(xhr.response);
            }
        };
        xhr.open('POST', '../../backend/api/mail.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Authorization', "JWT " + token);
        xhr.setRequestHeader('Email', email);
        xhr.send(JSON.stringify(data));
    } else {
        document.getElementById('message-reciever-error').style.display = 'block';
    }
}

function getMail(id) {
    const token = window.localStorage.getItem("token");
    const email = window.localStorage.getItem("email");

    const xhr = new XMLHttpRequest();
    xhr.responseType = 'json';
    xhr.onload = function() {
        if (xhr.status === 200) {
            composeMail(xhr.response.body);
        } else {
            console.error("Error! Failed to fetch mailboxes!");
        }
    };
    xhr.open('GET', '../../backend/api/mail.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('Authorization', "JWT " + token);
    xhr.setRequestHeader('Email', email);
    xhr.setRequestHeader('Boxname', encodeURI(window.localStorage.getItem("box_name")));
    xhr.setRequestHeader('Mailid', id);
    xhr.send();
}

function composeMail(data) {
    subject = document.getElementById("letter-subject");
    removeChildren(subject);
    subject.appendChild(document.createTextNode(data["subject"]));
    window.localStorage.setItem("mail_subject", data["subject"]);

    sender = document.getElementById("letter-sender");
    removeChildren(sender)
    sender.appendChild(document.createTextNode(data["sender"]));
    window.localStorage.setItem("mail_type", 1);

    if (data["sender"] == "Анонимен") {
        window.localStorage.setItem("mail_type", 2);
        window.localStorage.setItem("mail_sender", data["ref_number"]);
    } else {
        window.localStorage.setItem("mail_sender", data["sender"]);
    }

    reciever = document.getElementById("letter-reciever");
    removeChildren(reciever);
    reciever.appendChild(document.createTextNode(window.localStorage.getItem("email")));

    date = document.getElementById("letter-send-date");
    removeChildren(data);
    date.appendChild(document.createTextNode(data["send_date"]));

    message = document.getElementById("message-panel");
    removeChildren(message);
    message.appendChild(document.createTextNode(data["message"]));
}

function removeChildren(element) {
    while (element.firstChild) {
        element.removeChild(element.firstChild);
    }
}

function exit() {
    window.localStorage.removeItem("token");
    window.localStorage.removeItem("email");
    backToLogin();
}

function backToLogin() {
    window.location.href = '../login/login.php';
}