<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title> Welcome </title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
            rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../style.css"/>
        <script type="text/javascript" src="mainpage.js"></script>
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
                        <button onclick="writeMessage()">
                            <i class="material-icons">create</i>
                            Напиши
                        </button>
                    </div>
                    <button class="accordion" onclick="showHideMailBoxes()">
                        <i class="material-icons">all_inbox</i>
                        Кутии
                    </button>
                    <div id="mail-boxes" class="mail-boxes">
                        <ul id="user-boxes">
                        </ul>
                        <button onclick="addMailBox()">
                            <i class="material-icons">add_box</i>
                            Добави
                        </button>
                    </div>
                    <div class="muffin-exit">
                        <button onclick="exit()">
                        <i class="material-icons">exit_to_app</i>
                        Изход
                    </button>
                    </div>
                </div>
                <div id="main-frame" class="main-frame">
                    <div id="mails" class="mails">
                    </div>
                    <div id="send-mail" class="send-mail">
                        <div id="send-error-message" class="info-send-message-error">Колегат ви все още не е създал своята кутия. Опитайте по-късно. : )</div>
                        <form id="send-mail-form" name="send-mail-form" class="send-mail-form">
                            <div class="mail-type">
                                <div class="mail-type-choice">
                                    <div class="input-holder">
                                        <label>Личен</label>
                                        <input type="radio" id="mail-type1" class="form-item" name="mail-type" value="1" onclick="changePlaceholder(this)" checked="checked">
                                    </div>
                                    <div class="input-holder">
                                        <label>Оценка</label>
                                        <input type="radio" id="mail-type2" class="form-item" name="mail-type" value="2" onclick="changePlaceholder(this)">
                                    </div>
                                </div>
                                <div class="mail-input">
                                    <label for="reciever">До: </label>
                                    <input id="message-reciever" type="text" class="form-item" placeholder="Имейл адрес" name="reciever">
                                </div>
                                <div id="message-reciever-error" class="form-item-invalid"> * Задължително поле. </div>
                            </div>
                            <div class="mail-input">
                                <label for="subject">Тема:</label>
                                <input id="message-subject" class="form-item" name="subject">
                            </div>
                            <textarea id="message" rows=10 placeholder="Съобщение..."></textarea>
                            <button class="muffin-send-button" type="button" onclick="sendMail()">
                                <i class="material-icons">send</i>
                                Изпрати
                            </button>
                        </form>
                    </div>
                    <div id="create-box" class="create-box">
                        <form id="create-box-form" name="create-box-form" class="create-box-form" enctype="multipart/form-data">
                            <div class="mail-input">
                                <label for="box_name">Име: </label>
                                <input id="box-name" type="text" class="form-item" placeholder="Име на кутията" name="box_name" required>
                            </div>
                            <div id="box-name-error" class="form-item-invalid"> * Задължително поле. </div>
                            <div class="mail-input">
                                <label for="box-type">Тип: </label>
                                <select id="box-type" name="box-type" onchange="showHideRefNumber(this)">
                                    <option value="1">Лична</option>
                                    <option value="2">Моят реферат</option>
                                    <option value="3">Реферат за оценяване</option>
                                </select>
                            </div>
                            <div class="box-ref-number" id="box-ref-number">
                                <div class="mail-input">
                                    <label for="ref_number">Номер на реферат: </label>
                                    <input id="ref-number" type="number" class="form-item" placeholder="Номер на реферат" name="ref_number" value="0">
                                </div>
                            </div>
                            <button class="muffin-send-button" type="button" onclick="createBox()">
                                <i class="material-icons">add</i>
                                Създай
                            </button>
                        </form>
                    </div>
                    <div id="read-mail" class="read-mail">
                        <div id="letter-subject" class="letter-subject"></div>
                        <table id="letter-header" class="letter-header">
                            <tr>
                                <th>От:</th>
                                <td id="letter-sender"></td>
                            </tr>
                            <tr>
                                <th>До:</th>
                                <td id="letter-reciever"></td>
                            </tr>
                            <tr>
                                <th>Дата:</th>
                                <td id="letter-send-date"></td>
                            </tr>
                        </table>
                        <hr>
                        <div id="message-panel" class="message-panel">
                        </div>
                        <div class="message-opts">
                            <button class="muffin-send-button" type="button" onclick="writeMessage(true)">
                                <i class="material-icons">reply</i>
                                Отговори
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>