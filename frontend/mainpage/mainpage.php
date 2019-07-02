<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title> Welcome </title>
        <link rel="stylesheet" type="text/css" href="../style.css"/>
        <script type="text/javascript" src="mainpage.js"></script>
        <script type="text/javascript" src="../validate.js"></script>
    </head>
    <body onkeypress="handleEnter(event)">
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
                </div>
            </div>
        </div>
    </body>
</html>