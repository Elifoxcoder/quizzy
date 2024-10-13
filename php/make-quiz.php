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
    $title = $_POST['title'];
    $theme = $_POST['theme'];
    $visibility = $_POST['visibility'];

    if (empty($title)) {
        $error = 'Bitte Titel festlegen';
    } else if (empty($theme)) {
        $error = 'Bitte Thema festlegen.';
    } else if (empty($visibility)) {
        $error = 'Bitte Sichtbarkeit festlegen.';
    }

    if (!empty($error)) {
        $response = [
            'success' => false,
            'error' => $error
        ];
        die(json_encode($response));
    }

    $stmt = $conn->prepare('INSERT INTO `quizes` (title, theme, visibility, owner_id) VALUES (:title, :theme, :visibility, :owner_id)');
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':theme', $theme);
    $stmt->bindParam(':visibility', $visibility);
    $stmt->bindParam(':owner_id', $id);
    $stmt->execute();

    $response = [
        'success' => true,
        'quiz_id' => $conn->lastInsertId()
    ];

    echo json_encode($response);
}
