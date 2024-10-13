<?php
include ('variables.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['pwd'];
    $name = $_POST['name'];

    if (empty($email)) {
        die('Bitte E-Mail ausfüllen.');
    }
    if (empty($password)) {
        die('Bitte Passwort festlegen.');
    }
    if (empty($name)) {
        die('Bitte Name ausfüllen.');
    }

    $stmt = $conn->prepare('SELECT * FROM `users` WHERE `email` = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if ($stmt->fetch()) {
        die('Diese E-Mail-Adresse ist bereits vergeben.');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare('INSERT INTO `users` (email, password, name) VALUES (:email, :password, :name)');
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':name', $name);
    $stmt->execute();

    echo 'success';
}
