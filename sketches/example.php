<!DOCTYPE html>
<html>
<head>
    <style>
        .html{
            height: 100vh;
        }
        body{
            height: 100vh;
            background-color: #000000;
            text-align: center;
        }
        #topics{
            height: 100vh;
            background-color: #AAAAAA;
            width: 20vh;
            float: left;
        }
        #messages{
            height: 100vh;
            background-color: #CCCCCC;
            width: 60vh;
            float: left;
        }
        #users{
            height: 100vh;
            background-color: #BBBBBB;
            width: 20vh;
            float: left;
        }
        blockquote{
            padding: 2vh 2vh 2vh 2vh;
            background-color: #DDDDDD;
        }
    </style>
</head>
<body>
    <div id="topics">
        <ul>
            <li>topic 1</li>
            <li>topic 2</li>
            <li>topic 3</li>
        </ul>
    </div>
    <div id="messages">
        <blockquote>message 0x00</blockquote>
        <blockquote>message 0x01</blockquote>
        <blockquote>message 0x02</blockquote>
    </div>
    <div id="users">
        <ul>
            <li>user A</li>
            <li>user B</li>
            <li>user C</li>
        </ul>
    </div>
</body>
</html>

<?php
