<?php
/**
 * Created by PhpStorm.
 * User: Rik
 * Date: 23-5-2017
 * Time: 11:15
 */

require_once '../../vendor/autoload.php';
session_start();

$ga = new PHPGangsta_GoogleAuthenticator();
$secret = "RQVKNRCZ6N7PCEYV";

$qrCodeUrl = $ga->getQRCodeGoogleUrl('Seminar authenticatie', $secret);

$oneCode = $ga->getCode($secret);

$checkResult = false;

$_SESSION['ga'] = $ga;
$_SESSION['secret'] = $secret;
?>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h2>Two factor authenticatie</h2>
        <hr/>
                <form method="post" action="authenticator.php">
                    <div class="form-group">
                        <label for="exampleInputUsername">Gebruikersnaam</label>
                        <input type="username" class="form-control" name="inputUsername" placeholder="Voer gebruikersnaam in">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword">Wachtwoord</label>
                        <input type="password" class="form-control" name="inputPassword" placeholder="Voer wachtwoord in">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputCode">QR code</label><br/>
                        <img src=<?php echo $qrCodeUrl ?> />
                        <span id="helpBlock" class="help-block">Scan de qr code met Google Authenticator om een beveiligingscode te ontvangen.</span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputCode">Beveiligingscode</label>
                        <input type="text" class="form-control" name="inputCode" placeholder="Voer beveiligingscode in">
                    </div>
                    <input type="submit" class="btn btn-default" />
                </form>
    </div>
</body>
</html>
