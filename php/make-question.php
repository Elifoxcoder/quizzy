<?php
include ('variables.php');
session_start();

if (empty($_SESSION['userRow'])) {
    die('Du bist nicht eingeloggt');
} else {
    $id = $_SESSION['userRow']['id'];
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'];
    $ans1 = $_POST['ans1'];
    $ans2 = $_POST['ans2'];
    $ans3 = $_POST['ans3'];
    $ans4 = $_POST['ans4'];
    $rightAnswer = $_POST['right-answer'];
    $quiz_id = $_POST['quiz_id'];

    if (empty($question)) {
        $error = 'Bitte Frage stellen';
    } else if (empty($ans1)) {
        $error = 'Bitte Antwort 1 festlegen';
    } else if (empty($ans2)) {
        $error = 'Bitte Antwort 2 festlegen';
    } else if (empty($ans3)) {
        $error = 'Bitte Antwort 3 festlegen';
    } else if (empty($ans4)) {
        $error = 'Bitte Antwort 4 festlegen';
    } else if (empty($rightAnswer)) {
        $error = 'Bitte richtige Antwort auswählen';
    } else if (!in_array($rightAnswer, ['ans1', 'ans2', 'ans3', 'ans4'])) {
        $error = 'Ungültige richtige Antwort';
    }

    switch ($rightAnswer) {
        case "ans1":
            $rightAnswer = $ans1;
            break;
        case "ans2":
            $rightAnswer = $ans2;
            break;
        case "ans3":
            $rightAnswer = $ans3;
            break;
        case "ans4":
            $rightAnswer = $ans4;
            break;
    }
    
    if (!empty($error)) {
        $response = [
            'success' => false,
            'error' => $error
        ];
        die(json_encode($response));
    }

    $stmt = $conn->prepare('INSERT INTO `questions`(`question`, `correct_answer`, `answer_1`, `answer_2`, `answer_3`, `answer_4`, `quiz_id`) VALUES (:question, :correct_answer, :answer_1, :answer_2, :answer_3, :answer_4, :quiz_id)');

    $stmt->bindParam(':question', $question);
    $stmt->bindParam(':correct_answer', $rightAnswer);
    $stmt->bindParam(':answer_1', $ans1);
    $stmt->bindParam(':answer_2', $ans2);
    $stmt->bindParam(':answer_3', $ans3);
    $stmt->bindParam(':answer_4', $ans4);
    $stmt->bindParam(':quiz_id', $quiz_id);
    $stmt->execute();

    $response = [
        'success' => true
    ];

    echo json_encode($response);
}
