<?php
/**
 * @brief Language configuration for cookies.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

// language configuration
$cookieName = "user_lang";
$cookieValue = "ro";

if (!isset($_COOKIE[$cookieName])) {
    setcookie($cookieName, $cookieValue, time() + (86400 * 30), "/");
    redirect('/');
}

if (isset($_COOKIE[$cookieName])) {
    switch ($_COOKIE[$cookieName]) {
        case "en":
            require_once ROOT_PATH . '/public/languages/en.php';
            break;
        case "ro":
            require_once ROOT_PATH . '/public/languages/ro.php';
            break;
        default:
            require_once ROOT_PATH . '/public/languages/ro.php';
    }
}