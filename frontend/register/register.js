function register() {
    clearErrors();
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const repeat_password = document.getElementById("repeat_password");
    const first_name =  document.getElementById("first_name");
    const last_name =  document.getElementById("last_name");
    const fn =  document.getElementById("fn");

    data = {
        'email': email.value, 
        'password': password.value, 
        'repeat_password': repeat_password.value, 
        'first_name': first_name.value,
        'last_name': last_name.value,
        'fn': fn.value
    };
    if (!validate(data)) {
        return;
    }
    const xhr = new XMLHttpRequest();
    xhr.onload = function() {
        if (xhr.status === 200) {
            sessionStorage.setItem('loginScreenSuccessMessage', 'Успешна регистрация! Вече можете да влезете в системата!');
            backToLogin();
        } else {
            displayUnsuccessfulRegistration();
        }   
    };
    xhr.open('POST', '../../backend/api/register.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify(data));
}

function validate(form) {
    let result = true;
    if (!validateLength(form.email, 1, 64) || !validateEmail(form.email)) {
        result = false;
        document.getElementById('email-error').style.display = 'block';
    }
    if (!validateLength(form.password, 6, 64)) {
        result = false;
        document.getElementById('password-error').style.display = 'block';
    }
    if (form.password !== form.repeat_password) {
        result = false;
        document.getElementById('repeat_password-error').style.display = 'block';
    }
    if (!validateLength(form.first_name, 1, 255) || !validateIsWord(form.first_name)) {
        result = false;
        document.getElementById('first_name-error').style.display = 'block';
    }
    if (!validateLength(form.last_name, 1, 255) || !validateIsWord(form.last_name)) {
        result = false;
        document.getElementById('last_name-error').style.display = 'block';
    }
    if (!validateLength(form.fn, 5, 5) || !validateIsNumber(form.fn)) {
        result = false;
        document.getElementById('fn-error').style.display = 'block';
    }
    return result;
}

function displayUnsuccessfulRegistration() {
    const unsuccessfulRegistrationElem = document.getElementById('unsuccessful-registration');
    unsuccessfulRegistrationElem.style.display = 'block';
}

function clearErrors() {
    const errors = document.getElementsByClassName('form-item-invalid');
    for (let i = 0; i < errors.length; i++) {
        const error = errors[i];
        error.style.display = 'none';
    }
}

function handleEnter(e){
    const keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
        register();
    }
}

function backToLogin() {
    window.location.href = '../login/login.php';
}
