<?php
require_once '../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    $accountName = "admin";
    $accountPassword = "admin";

    $inputName = $_POST["inputUsername"];
    $inputPassword = $_POST["inputPassword"];
    $inputCode = $_POST["inputCode"];

    $ga = $_SESSION['ga'];
    $secret = $_SESSION['secret'];
    $checkResult = $ga->verifyCode($secret, $inputCode, 2);

    if($inputName != $accountName || $inputPassword != $accountPassword) {
        echo 'Onjuiste combinatie gebruikersnaam en wachtwoord';
    } else if(!$checkResult) {
        echo 'Onjuiste beveiligingscode';
    } else {
        echo 'Succesvol ingelogd!';
    }
}