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


        if (isLoggedIn()) {
            flashMessage('info', $lang['already_logged_txt']);
            redirect('/');
        } elseif (!isset($_SESSION["sec_id"]) && !isLoggedIn()) {
            flashMessage('info', $lang['need_login_txt']);
            redirect('/login');
        } elseif (isset($_SESSION["sec_id"]) && !isLoggedIn()) {
            $user = $this->authModel->getUser($_SESSION['sec_id']);
            $type = $_SESSION['sec_type'];
            $mail = $user['Mail'];
            if ($type == 'email') {
                $pageTitle = $_SESSION['user_lang'] == 'en' ? 'Email Confirmation' : 'Confirmare Email';
                $sendCode = $_SESSION['sec_code'];
                $message = "A fost depistata o autentificare pe contul tau de pe un nou IP. <br>
                            Daca ai fost tu, introdu pe server codul de mai jos. In cazul in care nu tu te-ai conectat, iti recomandam sa iti schimbi parola. <br><br>    
                            Codul de securitate pentru contul tau este: " . $sendCode . ".";
                    if (!isset($_POST['authCheck'])) {
                        sendMail($mail, 'do-not-reply@dreamvibe.ro', 'DreamVibe RPG', 'Confirmare Login', $message);
                    }
                }
            } else {
                $pageTitle = $_SESSION['user_lang'] == 'en' ? 'Two Factor Authentication' : 'Autentificare în 2 pași';
            }
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
                } else if ($type == 'email') {
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