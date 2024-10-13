<?php

include ('variables.php');
session_start();

$email = $_POST['email'];
$pwd = $_POST['pwd'];


if(empty($email)) {
    die("Bitte E-mail ausfüllen");
}
if(empty($pwd)) {
    die("Bitte Passwort ausfüllen");
}


$stmt = $conn->prepare("SELECT * FROM `users` WHERE `email` = :email");
$stmt->bindParam(":email",$email);
$stmt->execute();
$result = $stmt->fetch();

if(!$result){
    die("Benutzer nicht gefunden!");
}

if (password_verify($pwd, $result['password'])) {
    $_SESSION['userRow'] = $result;
    echo "success";
} else {
    die('Falsches Passwort!');
}
