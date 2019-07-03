<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title> Welcome </title>
        <link rel="stylesheet" type="text/css" href="../style.css"/>
        <script type="text/javascript" src="write_message.js"></script>
        <script type="text/javascript" src="../validate.js"></script>
    </head>
    <body>
        <div class="muffin-container">
            <div class="logo">
                <img src="../img/muffin.png" height="100">
                <span class="brand"> Muffin </span>
            </div>
            <div class="main-container">
                <div class="muffin-navigation">
                    <div class=new-mail>
                        <button>Напиши</button>
                    </div>
                    <button class="accordion" onclick="showHideMailBoxes()">Кутии</button>
                    <div id="mail-boxes" class="mail-boxes">
                        <ul id="user-boxes">
                        </ul>
                        <button>Добави</button>
                    </div>
                    <div class="muffin-exit">
                        <button onclick="exit()">Изход</button>
                    </div>
                </div>
                <div id="main-frame" class="main-frame">
                    <form id="send-mail-form" name="send-mail-form" class=send-mail-form>
                        <div class="mail-type">
                            <label>До: <input id="message-reciever" type="text" class="form-item" placeholder="Имейл адрес" name="reciever"></label>
                            <input type="radio" id="mail-type" class="form-item" name="mail-type" value="1" onclick="changePlaceholder(this)" checked="checked"> Личен
                            <input type="radio" id="mail-type" class="form-item" name="mail-type" value="2" onclick="changePlaceholder(this)"> Оценка
                        </div>
                        <label>Тема: <input id="subject" class="form-item" name="subject"></label>
                        <textarea id="message" rows=20 placeholder="Съобщение..."></textarea>
                        <button type="button" onclick="sendMail()">Изпрати</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>