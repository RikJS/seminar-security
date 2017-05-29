<?php
require_once '../../vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfig('../../client_secret.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/third-party/index.php');
$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
$client->addScope('email');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);
    // store in the session also
    $_SESSION['id_token_token'] = $token;
    // redirect back to the example
    header('Location: ' . filter_var($client->getRedirectUri(), FILTER_SANITIZE_URL));
}

if (
    !empty($_SESSION['id_token_token'])
    && isset($_SESSION['id_token_token']['id_token'])
) {
    $client->setAccessToken($_SESSION['id_token_token']);
} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
}

if ($client->getAccessToken()) {
    $token_data = $client->verifyIdToken();

    $drive = new Google_Service_Drive($client);
    $files = $drive->files->listFiles(array())->getFiles();

    ?>
    <h3>Welkom <?php echo $token_data['email'] ?></h3>
    <hr/>
    <b>Jouw Google Drive bestanden:</b>
    <ul>
        <?php
        foreach ($files as $file) {
            echo "<li>" . $file->name . "</li>";
        }
        ?>
    </ul>
    <?php
}