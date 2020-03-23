<?php
/**
 * @brief Security controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/Validations/ValidateLogin.php';

class SecurityController extends Controller
{
    use ValidateLogin;
    private $authModel;
    private $privileges;

    public function __construct()
    {
        // load the model
        $this->authModel = $this->loadModel('Auth');

        // store user privileges
        $this->privileges = $this->checkPrivileges();
    }

    public function security()
    {
        global $lang;

        $pageTitle = $_SESSION['user_lang'] == 'ro' ? 'Two Factor Authentication' : 'Autentificare în 2 pași';

        if (isLoggedIn()) {
            flashMessage('info', $lang['already_logged_txt']);
            redirect('/');
        } elseif (!isset($_SESSION["sec_id"]) && !isLoggedIn()) {
            flashMessage('info', $lang['need_login_txt']);
            redirect('/login');
        } elseif (isset($_SESSION["sec_id"]) && !isLoggedIn()) {
            $user = $this->authModel->getUser($_SESSION['sec_id']);
            $type = $_SESSION['sec_type'];
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST['secret'] = filter_var($_POST['secret'], FILTER_VALIDATE_INT);
                $userCode = $_POST['secret'];
                $data = [
                    'pageTitle' => $pageTitle,
                    'lang' => $lang,
                    'user' => $user,
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader']
                ];
                if ($type == '2fa') {
                    $secret = $user['GoogleCode'];
                    $verify = $this->authModel->checkCode($secret, $userCode);
                    $errors = ValidateLogin::validateSecret($userCode, $verify);
                } else {
                    $sendCode = random_int(100000, 999999);
                    $verify = $sendCode == $userCode ? 1 : 0;
                    $errors = ValidateLogin::validateSecretEmail($userCode, $verify);
                }
                if (count(array_filter($errors)) == 0) {
                    $loggedInUser = $this->authModel->loginUser($user['NickName'], $_SESSION['sec_pass']);
                    if ($verify) {
                        flashMessage('success', $lang['success_login_txt']);
                        $this->authModel->startSession($loggedInUser);
                        $this->authModel->destroySecuritySession($loggedInUser);
                    } else {
                        die('Oops, something went wrong');
                    }
                } else {
                    $this->loadView('security', $data, $errors);
                }
            }
            $data = [
                'pageTitle' => $pageTitle,
                'lang' => $lang,
                'user' => $user,
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader']
            ];
            $this->loadView('security', $data);
        } else {
            flashMessage('info', $lang['need_login_txt']);
            redirect('/login');
        }
    }
}