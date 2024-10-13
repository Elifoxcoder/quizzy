<?php
include ('../php/variables.php');
session_start();

$name = $_SESSION['userRow']['name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php
require ('../php/head.php');
?>
    <style>


        @font-face {
            font-family: "Poppins";
            src: url("../assets/Poppins/poppins.otf");
        }

        * {
            font-weight: 500;
            margin: 0;
            padding: 0;
            font-family: "Poppins", Arial, Helvetica, sans-serif;
            box-sizing: border-box;
        }

        body {
            display: flex;
            background-color: var(--white);
        }

        .nav {
            display: flex;
            flex-direction: column;
            background-color: #222;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            height: 100vh;
            color: #fff;
        }

        .nav-header {
            padding: 20px;
        }

        .nav-list {
            list-style: none;
            padding: 20px;
            display: flex;
            flex-direction: column;
            padding-top: 0px;
        }

        .nav-list a {
            padding: 10px;
            transition: 200ms;
            border-radius: 10px;
        }

        .nav a:hover {
            background: var(--dark_grey);
        }


        .list-item-link {
            text-decoration: none;
            color: #fff;
        }


        .add-btn {
            position: fixed;
            bottom: 50px;
            right: 50px;
            background: var(--blue);
            border-radius: 50%;
            padding: 20px;
            border: 0;
            color: var(--white);
            width: 75px;
            height: 75px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .add-btn i {
            font-size: 32px;
        }

        main {
            flex: 1;
            height: 100vh;
            padding: 50px;
        }

        .quizzes {
            padding: 1px;
            height: calc(100vh - 100px - 48px - 36.8px - 20px);
            width: 70%;
            overflow-y: scroll;
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
        }

        .quiz {
            background-color: var(--box_bg_color);
            color: var(--main_theme);
            background-color: ;
            width: 100%;
            -webkit-box-shadow: 0px 0px 1px 1px var(--rgba);
            box-shadow: 0px 0px 1px 1px var(--rgba);
            border-radius: 20px;
            padding: 20px;
        }

        .b-font{
            color: var(--main_theme);
        }
    </style>
</head>

<body id="navigation">
    <?php require "../php/nav.php" ?>
    <main>
        <h1 class="b-font" id="navigation">Hallo,
            <?= $name ?>
        </h1>
        <h2 class="b-font" id="navigation">Öffentliche Quizze:</h2>
        <div class="quizzes">
            
        </div>

    </main>
    <button class="add-btn" onclick="location.href = '../quizes/make-quiz.php';">
        <i class="fa-solid fa-plus"></i>
    </button>
    <script>
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            document.querySelector(".quizzes").innerHTML = xhttp.response;
        }
        xhttp.open("GET", "../php/get-quizes.php", true);
        xhttp.send();
    </script>
</body>

</html>

<!--
<div class="quiz-main-container">
            <div class="quiz-container">
                <h3>Wie wurden schwarze Sklaven früher auch genannt?</h3>
                <div class="input-group">
                    <input type="checkbox" name="" id="" >
                    <label for="checkbox"></label>
                </div>
            </div>
        </div>
-->