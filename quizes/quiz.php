<?php
include ('../php/variables.php');
session_start();

$name = $_SESSION['userRow']['name'];

if ($_GET['id']) {
    $stmt = $conn->prepare('SELECT * FROM `quizes` WHERE `id` = :id');
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result) {
        $quiz_title = htmlentities($result['title']);
    } else {
        die('Quiz nicht gefunden');
    }

    if (empty($_GET['currentQuestion'])) {
        $stmt = $conn->prepare('SELECT * FROM `questions` WHERE quiz_id = :quiz_id ORDER BY `id` ASC LIMIT 1');
    } else if(!empty($_GET['nextQuestion'])) {
        $stmt = $conn->prepare('SELECT * FROM `questions` WHERE quiz_id = :quiz_id AND id > :id ORDER BY `id` ASC LIMIT 1');
        $stmt->bindParam(':id', $_GET['currentQuestion']);
    } else {
        $stmt = $conn->prepare('SELECT * FROM `questions` WHERE quiz_id = :quiz_id AND id = :id ORDER BY `id` ASC LIMIT 1');
        $stmt->bindParam(':id', $_GET['currentQuestion']);
    }

    $stmt->bindParam(':quiz_id', $_GET['id']);
    $res = $stmt->execute();
    $question = $stmt->fetch();

    if (empty($_GET['currentQuestion']) && $question) {
        header('Location: quiz.php?id=' . $_GET['id'] . '&currentQuestion=' . $question['id']);
    }
    if ($result['owner_id'] == $_SESSION['userRow']['id']) {
        $isOwner = true;
    } else {
        $isOwner = false;
    }

    // TODO: SELECT * FROM `questions` WHERE quiz_id = 16
    // ORDER BY `id` ASC LIMIT 1                             : First Question

    // SELECT * FROM `questions` WHERE quiz_id = 16 AND id > QURRENT_QUESTION_ID
    // ORDER BY `id` ASC LIMIT 1                                                  : Next Question

    if (isset($_POST['verify-btn']) && isset($_POST['ans'])) {
        if ($question['correct_answer'] == $_POST['ans']) {
            $user_id = $_SESSION['userRow']['id'];
            $question_id = $question['id'];
            $selectedAnswer = $_POST['ans'];

            $stmt = $stmt = $conn->prepare('INSERT INTO `finished_questions`(`user_id`, `question_id`, `is_correct`, `selected_answer`) VALUES (:user_id,:question_id,true,:selectedAnswer)');
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':question_id', $question_id);
            $stmt->bindParam(':selectedAnswer', $selectedAnswer);

            if($stmt->execute()){
                header('Location: quiz.php?id=' . $_GET['id'] . '&currentQuestion=' . $question['id'] . "&nextQuestion=1");
            }


        } else {
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        $title = 'Quiz erstellen';
        require ('../php/head.php');
    ?>
    <style>
        :root {
            --blue: #1259ff;
            --red: #ff0000;
            --black: #222;
            --dark_grey: #333;
            --shadow_grey: #ccc;
            --white: #fff;
            --rgba: rgba(197, 197, 197, 0.88);
        }

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
            background: var(--white);
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

        .quizzes {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
        }

        .quiz {
            width: 70%;
            -webkit-box-shadow: 0px 0px 1px 1px var(--rgba);
            box-shadow: 0px 0px 1px 1px var(--rgba);
            border-radius: 20px;
            padding: 20px;
        }

        .multiple-choice{
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
        }

        .question{
            background: var(--third_theme);
            color: var(--main_theme);
            padding: 15px;
            border-radius: 15px;
            border-left: 3px solid dodgerblue;
            margin-top: 10px;
        }

        .verify-btn{
            background: #222;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 10px;
            color: #fff;
            border: 0;
            width: max-content;
        }

    </style>
</head>

<body id="navigation">
    <?php require '../php/nav.php' ?>
    <main>
        <h1 style="color: var(--main_theme);">
            <?= $quiz_title ?>
        </h1>
        <div class="questions">
            <?php
                if (!$question) {
                    echo 'Keine Fragen vorhanden';
                } else {
            ?>
            <div class="question">
                <span><?= htmlentities($question['question']); ?></span>
                <form action="#" class="multiple-choice" method="POST">
                    <div class="form-group">
                        <input type="radio" name="ans" id="ans1" value="<?= htmlentities($question['answer_1']); ?>">
                        <label for="ans1"><?= htmlentities($question['answer_1']); ?></label>
                    </div>
                    <div class="form-group">
                        <input type="radio" name="ans" id="ans2" value="<?= $question['answer_2']; ?>">
                        <label for="ans2"><?= htmlentities($question['answer_2']); ?></label>
                    </div>
                    <div class="form-group">
                        <input type="radio" name="ans" id="ans3" value="<?= $question['answer_3']; ?>">
                        <label for="ans3"><?= htmlentities($question['answer_3']); ?></label>
                    </div>
                    <div class="form-group">
                        <input type="radio" name="ans" id="ans4" value="<?= $question['answer_4']; ?>">
                        <label for="ans4"><?= htmlentities($question['answer_4']); ?></label>
                    </div>
                    <button class="button verify-btn" type="sumbit" name="verify-btn">
                        <span class="b-font" id="navigation">Auswerten</span>
                    <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </form>
            </div><?php
                }
                ?>

        </div>
    </main>
    <?php
        if (!$isOwner) {
            echo '<!--';
        }
    ?>
    <button class="add-btn" onclick="location.href = 'make-question.php?id=<?= $_GET['id']; ?>';">
        <i class="fa-solid fa-plus"></i>
    </button>
    <?php
        if (!$isOwner) {
            echo '-->';
        }
    ?>
    <script>

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