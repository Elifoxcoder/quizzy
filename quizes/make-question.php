<?php
include ('../php/variables.php');
session_start();

$name = $_SESSION['userRow']['name'];

if ($_GET['id']) {
    $stmt = $conn->prepare('SELECT * FROM `quizes` WHERE `id` = :id');
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
    $result = $stmt->fetch();

    if (!$result) {
        die('Quiz nicht gefunden!');
    }
}

if($result['owner_id'] == $_SESSION['userRow']['id']){
    $isOwner = true;
} else {
    $isOwner = false;
    header("Location: ../home");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        $title = 'Frage erstellen';
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


        .quiz {
            display: flex;
            flex-direction: column;
        }

        .quiz input,
        .quiz select {
            color: var(--main_theme);
            padding: 10px;
            border-radius: 10px;
            background: transparent;
            border: 1px solid var(--shadow_grey);
            outline: 0;
        }

        .quiz .answer-group {
            display: flex;
            flex-direction: column;
            width: 500px;
            gap: 1px;
            margin-top: 10px;
        }

        .quiz .question {
            display: flex;
            flex-direction: column;
            width: 500px;
            gap: 10px;
            margin-bottom: 50px;
        }

        .quiz input[type="submit"] {
            width: 500px;
            margin-top: 10px;
            background: var(--main_theme);
            color: var(--white);
        }

        .b-font{
            color: var(--main_theme);
        }
    </style>
</head>

<body id="navigation">
    <?php require '../php/nav.php' ?>
    <main>
        <h1 class="b-font" id="navigation">Frage erstellen</h1>
        <form class="quiz">
            <div class="question">
                <label class="b-font" id="navigation" for="question">Frage</label>
                <input type="text" name="question" id="question">
            </div>
            <div class="answers">
                <div class="answer-group">
                    <label class="b-font" id="navigation" for="#">Antwort 1</label>
                    <input type="text" name="ans1">
                </div>
                <div class="answer-group">
                    <label class="b-font" id="navigation" for="#">Antwort 2</label>
                    <input type="text" name="ans2">
                </div>
                <div class="answer-group">
                    <label class="b-font" id="navigation" for="#">Antwort 3</label>
                    <input type="text" name="ans3">
                </div>
                <div class="answer-group">
                    <label class="b-font" id="navigation" for="#">Antwort 4</label>
                    <input type="text" name="ans4">
                </div>
                <input type="hidden" name="quiz_id" value="<?= $_GET['id']; ?>">
                <div class="answer-group">
                    <label class="b-font" id="navigation" for="#">Richtige Antwort</label>
                    <select name="right-answer" id="right-answer">
                        <option class="b-font" id="navigation" value="ans1" name="ans1-cor">Antwort 1</option>
                        <option class="b-font" id="navigation" value="ans2" name="ans2-cor">Antwort 2</option>
                        <option class="b-font" id="navigation" value="ans3" name="ans3-cor">Antwort 3</option>
                        <option class="b-font" id="navigation" value="ans4" name="ans4-cor">Antwort 4</option>
                    </select>
                </div>
                <input type="submit" value="Hinzufügen">
            </div>
        </form>

    </main>
    <button class="add-btn">
        <i class="fa-solid fa-plus"></i>
    </button>
    <script>

        //TODO: Gegen Hackereingriffe schützen (owner_id prüfen)
        let form = document.querySelector("form");

        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function () {
                let response = JSON.parse(xhttp.response);
                if (response.success) {
                    location.href = "quiz.php?id=" + <?= $_GET['id']; ?>;
                } else {
                    alert(response.error);
                }
            }
            xhttp.open("POST", "../php/make-question.php", true);
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