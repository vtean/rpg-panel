<?php
/**
 * @brief Handle csrf tokens.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

$length = 32;
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
}
$randomToken = openssl_random_pseudo_bytes(32);

if (!isset($_SESSION['csrfToken'])) {
    $_SESSION['csrfToken'] = hash_hmac('sha256', $randomString, $randomToken);
    $_SESSION['csrfExpire'] = time() + 900;
}

if (time() > $_SESSION['csrfExpire']) {
    $_SESSION['csrfToken'] = hash_hmac('sha256', $randomString, $randomToken);
    $_SESSION['csrfExpire'] = time() + 900;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['csrfToken'] != $_POST['csrfToken']) {
        die('Your session token has expired. Go back and try again. *If you are trying to fool someone, then sorry not sorry.');
    }
}