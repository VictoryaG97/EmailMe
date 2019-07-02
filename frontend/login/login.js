window.onload = displayInfoMessage;

function displayInfoMessage() {
    if (!!sessionStorage.getItem('loginScreenSuccessMessage')) {
        const successMessageElement = document.getElementById('success-message');
        const successMessageTextNode = document.createTextNode(sessionStorage.getItem('loginScreenSuccessMessage'));
        successMessageElement.appendChild(successMessageTextNode);
        successMessageElement.style.display = 'flex';
        sessionStorage.removeItem('loginScreenSuccessMessage');
    }

    if (!!sessionStorage.getItem('notLoggedMessage')) {
        const errorMessageElement = document.getElementById('error-message');
        const errorMessageTextNode = document.createTextNode(sessionStorage.getItem('notLoggedMessage'));
        errorMessageElement.appendChild(errorMessageTextNode);
        errorMessageElement.style.display = 'flex';
        sessionStorage.removeItem('notLoggedMessage');
    }
}

function login() {
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    
    data = {'email': email.value, 'password': password.value};
    const xhr = new XMLHttpRequest();
    xhr.responseType = 'json';
    xhr.onload = function() {
        if (xhr.status === 200) {
            window.localStorage.setItem("token", xhr.response.jwt);
            window.localStorage.setItem("email", xhr.response.email);
            window.location.href = '../mainpage/mainpage.php';
        } else {
            displayUnsuccessfulLogin();
        }   
    };
    xhr.open('POST', '../../backend/api/login.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify(data));
}

function displayUnsuccessfulLogin() {
    const wrongCredentialsElem = document.getElementById('wrong-credentials');
    wrongCredentialsElem.style.display = 'block';
}
  
function register() {
    window.location.href = '../register/register.php';
}

function handleEnter(e){
    const keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
        login();
    }
}