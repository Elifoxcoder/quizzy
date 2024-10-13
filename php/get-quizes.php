<?php
include ('variables.php');
session_start();

if (empty($_SESSION)) {
    die('Du bist nicht eingeloggt');
}

$userData = $_SESSION['userRow'];

$stmt = $conn->prepare('SELECT * FROM `quizes` ORDER BY created_at');
$stmt->execute();
$quizes = $stmt->fetchAll();

foreach ($quizes as $quiz) {
    $id = $quiz['id'];
    $onclickEvent = "location.href = '../quizes/quiz.php?id=$id';";
    echo '
        <div onclick="' . $onclickEvent . '" class="quiz">
            <h2>' . $quiz['title'] . '</h2>
            <span>Thema: ' . $quiz['theme'] . '</span>
        </div>
    ';
}
