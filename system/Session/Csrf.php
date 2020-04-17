<?php
/**
 * @brief Handle csrf tokens.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

$randomToken = time() + rand(1, 10000);
$userToken = hash('sha1', $randomToken);

if (!isset($_SESSION['csrfToken'])) {
    $_SESSION['csrfToken'] = hash('sha256', $userToken);
    $_SESSION['csrfExpire'] = time() + 900;
}

if (time() > $_SESSION['csrfExpire']) {
    $_SESSION['csrfToken'] = hash('sha256', $userToken);
    $_SESSION['csrfExpire'] = time() + 900;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['csrfToken'] != $_POST['csrfToken']) {
        die('Your session token has expired. Go back and try again. *If you are trying to fool someone, then sorry not sorry.');
    }
}