<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title> Registration </title>
        <link rel="stylesheet" type="text/css" href="../style.css"/>
        <script type="text/javascript" src="../validate.js"></script>
        <script type="text/javascript" src="register.js"></script>
    </head>
    <body onkeypress="handleEnter(event)">
        <div class="muffin-container">
            <div class="logo">
                <img src="../img/muffin.png" height="100">
                <span class="brand"> Muffin </span>
            </div>
            <div class="muffin-form-wrap register-form-wrap">
                <div class="form-img">
                    <img src="../img/form-background.png" alt="IMG">
                </div>
                <form id="registration-form" name="registration-form" class="register-form">
                    <header class="form-heading"><h1 class="form__title">Регистрация</h1></header>
                    <input id="email" class="form-item" placeholder="Имейл" name="email">
                    <div id="email-error" class="form-item-invalid"> * Задължително поле. Невалиден имейл </div>
                    <input id="password" class="form-item" placeholder="Парола" name="password" type="password">
                    <div id="password-error" class="form-item-invalid"> * Задължително поле. Паролата трябва да е поне 6 символа. Максимална дължина 64 символа. </div>
                    <input id="repeat_password" class="form-item" placeholder="Повтори паролата" name="repeat_password" type="password">
                    <div id="repeat_password-error" class="form-item-invalid"> * Паролите трябва да съвпадат. </div>
                    <input id="first_name" class="form-item" placeholder="Име" name="first_name">
                    <div id="first_name-error" class="form-item-invalid"> * Задължително поле. Името може да съдържа само букви. Максимална дължина 255 символа. </div>
                    <input id="last_name" class="form-item" placeholder="Фамилия" name="last_name">
                    <div id="last_name-error" class="form-item-invalid"> * Задължително поле. Фамилията може да съдържа само букви. Максимална дължина 255 символа. </div>
                    <input id="fn" class="form-item" placeholder="Факултетен номер" name="fn">
                    <div id="fn-error" class="form-item-invalid"> * Задължително поле. Факултетният номер се състои от 5 цифри. </div>
                    <div id="unsuccessful-registration" class="form-item-invalid"> Неуспешна регистрация. Имейлът или факултетният номер са заети. </div>
                    <button class="form-item form-button" type="button" onclick="register()"> Регистрация </button>
                    <button class="form-item form-button" type="button" onclick="backToLogin()"> Назад към влизане </button>
                </form>
            </div>
        </div>
    </body>
</html>