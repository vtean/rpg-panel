<?php
/**
 * @brief The best useful functions go here.
 * @authors Lust & Indigo
 * @param $pageTitle
 * @version 0.1
 * @copyright (c) DreamVibe Community
 */

function getHeader($pageTitle)
{
    require_once ROOT_PATH . '/public/views/layouts/header.php';
}

function getFooter()
{
    require_once ROOT_PATH . '/public/views/layouts/footer.php';
}

// redirect page
function redirect($page)
{
    header('location: ' . BASE_URL . $page);
    exit;
}

// check if user is logged in
function isLoggedIn()
{
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
        return true;
    } else {
        return false;
    }
}

// create a flash message
function flashMessage($type = '', $message = '')
{
    // create a new session message
    if (!empty($type) && !empty($message)) {
        // set session message and its type
        $_SESSION['message_type'] = $type;
        $_SESSION['message'] = $message;
    } else if (isset($_SESSION['message_type']) && isset($_SESSION['message'])) {
        // display the message
        echo '<div class="tnMessage ' . $_SESSION['message_type'] . '"><i class="fas fa-info-circle"></i><span>' . $_SESSION['message'] . '</span></div>';
        // unset session message
        unset($_SESSION['message_type'], $_SESSION['message']);
    }
}
