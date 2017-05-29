<?php
require_once '../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $configs = include('config.php');

    $accountName = "admin";
    $accountPassword = "admin";

    $inputName = $_POST["inputUsername"];
    $inputPassword = $_POST["inputPassword"];
    $inputCode = $_POST["inputCode"];

    $ga = new PHPGangsta_GoogleAuthenticator();
    $secret = $configs->secret;
    $checkResult = $ga->verifyCode($secret, $inputCode, 2);

    if ($inputName != $accountName || $inputPassword != $accountPassword) {
        echo '<h2>Onjuiste combinatie gebruikersnaam en wachtwoord</h2>';
    } else if (!$checkResult) {
        echo '<h2>Onjuiste beveiligingscode</h2>';
    } else {
        echo '<h2>Succesvol ingelogd!</h2>';
    }
}