<?php
/**
 * @brief The best useful functions go here.
 * @authors Lust & Indigo
 * @param $data
 * @version 0.1
 * @copyright (c) DreamVibe Community
 */

/* Get menu */
function getMenu($data)
{
    require_once ROOT_PATH . '/public/views/layouts/menu.php';
}

/* Get page header */
function getHeader($data)
{
    require_once ROOT_PATH . '/public/views/layouts/header.php';
}

/* Get page footer */
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
        echo '<div class="dv-message ' . $_SESSION['message_type'] . '"><i class="fas fa-info-circle"></i><span>' . $_SESSION['message'] . '</span></div>';
        // unset session message
        unset($_SESSION['message_type'], $_SESSION['message']);
    }
}

function convertMinutes($time, $format = '%02dh %02dm')
{
    if ($time < 1) {
        return 0;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

function sendMail($to, $from, $name, $subject, $message)
{
    $url = "http://support.dreamvibe.ro/dvmailer.php";
    $dataPost = array (
        "t" => $to,
        "f" => $from,
        "n" => $name,
        "s" => $subject,
        "m" => $message
    );

    $fields_string = http_build_query($dataPost);
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    $result = curl_exec($ch);

    curl_close($ch);
}

function getUserIp(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function strLimit($s, $length, $end='...')
{
    return substr($s, 0, $length) . $end;
}

function sexyDisplay($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

/* Get page error */
function getError($code, $msg)
{
    require_once ROOT_PATH . '/public/views/exception.php';
}