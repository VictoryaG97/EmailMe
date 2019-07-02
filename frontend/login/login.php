<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title> Login </title>
        <link rel="stylesheet" type="text/css" href="../style.css"/>
        <script type="text/javascript" src="login.js"></script>
    </head>
    <body onkeypress="handleEnter(event)">
        <div class="muffin-container">
            <div class="logo">
                <img src="../img/muffin.png" height="100">
                <span class="brand"> Muffin </span>
            </div>
            <div class="muffin-form-wrap">
                <!-- FIX SUCCESS/ERROR MESSAGES -->
                <div id="success-message" class="info-message-success"></div>
                <div id="error-message" class="info-message-error"></div>
                <div class="form-img">
                    <img src="../img/form-background.png" alt="IMG">
                </div>
                <form id="login-form" name="login-form" class="login-form">
                    <header class="form-heading"><h1 class="form__title">Влизане</h1></header>
                    <input id="email" class="form-item" placeholder="Имейл" name="email">
                    <input id="password" class="form-item" placeholder="Парола" name="password" type="password">
                    <div id="wrong-credentials" class="form-item-invalid"> Грешно потребителско име или парола! </div>
                    <div class="form-btn-container">
                        <button class="form-item form-button" type="button" onclick="login()"> Вход </button>
                        <button class="form-item form-button" type="button" onclick="register()"> Регистрация </button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>