function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validatePassword(password) {
    if (password.value.trim().length === 0) {
        document.getElementById("password_error").innerHTML = "Please enter your password *";
        response = false;
    } else if (password.value.length < 6) {
        document.getElementById("password_error").innerHTML = "Password should be at least 6 characters!";
        response = false;
    } else if (password.value.search(/[0-9]/) < 0 ||  password.value.search(/[a-z]/) < 0 || password.value.search(/[A-Z]/) < 0){
        document.getElementById("password_error").innerHTML = "Password should contain at least one uppercase, one lowercase letter and one number!";
        response = false;
    } else {
        document.getElementById("password_error").innerHTML = "";
    }
}

function validateLength(text, minLength, maxLength = null) {
    if (!text || typeof text !== 'string') {
        return false;
    }
    if (text.length >= minLength && (maxLength === null || text.length <= maxLength)) {
        return true;
    }
    return false;
}

function validateIsWord(text) {
    return testRegex(text, /^[a-zA-Z\u0410-\u044F]+$/);
}

function testRegex(text, regex) {
    if (!text || typeof text !== 'string') {
        return false;
    }
    return regex.test(text);
}

function validateIsNumber(text) {
    return testRegex(text, /^\d+$/);
}

function checkIfEmpty(data) {
    Object.keys(data).forEach(function(key) {
        if (data[key]==null || data[key]===false || data[key]==="") {
            console.log(data[key]);
            return true;
        }
    });
    return false;
}
