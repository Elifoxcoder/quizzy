<?php
include ('../php/variables.php');
session_start();

$name = $_SESSION['userRow']['name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        $title = 'Quiz erstellen';
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
            border-right: 1px solid #333;
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

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-top: 10px;
            width: 500px;
        }

        .input-group input,
        .input-group select {
            padding: 10px;
            border-radius: 10px;
            background: transparent;
            background-color: ;
            color: var(--main_theme);
            border: 1px solid var(--shadow_grey);
            outline: 0;
        }

        .input-group button {
            background: var(--second_theme);
            border-radius: 10px;
            padding: 10px;
            border: 0;
            color: var(--white);
            cursor: pointer;
        }

        .b-font{
            color: var(--main_theme);
        }
    </style>
</head>

<body id="navigation">
    <?php require "../php/nav.php" ?>
    <main>
        <h1 class="b-font" id="navigation">Quiz erstellen</h1>
        <form class="quiz" method="POST">
            <div class="input-group">
                <label class="b-font" id="navigation" for="title">Titel</label>
                <input type="text" name="title" id="title" placeholder="Dein Quiz benennen...">
            </div>
            <div class="input-group">
                <label class="b-font" id="navigation" for="theme">Thema</label>
                <input type="text" name="theme" id="theme">
            </div>
            <div class="input-group">
                <label class="b-font" id="navigation" for="title">Sichtbarkeit</label>
                <select name="visibility" id="visibility">
                    <option class="b-font" id="navigation" value="private">Privat</option>
                    <option class="b-font" id="navigation" value="public">Öffentlich</option>
                </select>
            </div>
            <div class="input-group">
                <button class="b-font" id="navigation" type="submit">
                    Erstellen
                </button>
            </div>
        </form>

    </main>
    <button class="add-btn">
        <i class="fa-solid fa-plus"></i>
    </button>
    <script>
        let form = document.querySelector("form");

        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function () {
                let response = JSON.parse(xhttp.response);
                if (response.success) {
                    location.href = "make-question.php?id=" + response.quiz_id;
                } else {
                    alert(response.error);
                }
            }
            xhttp.open("POST", "../php/make-quiz.php", true);
            xhttp.send(new FormData(form));
        });
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