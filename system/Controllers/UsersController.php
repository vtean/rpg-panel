<?php
/**
 * @brief UsersController controller
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/Validations/ValidateSettings.php';
require_once ROOT_PATH . '/system/Validations/ValidateProfileActions.php';

class UsersController extends Controller
{
    private $userModel;
    private $authModel;
    private $logModel;
    use ValidateSettings;
    use ValidateProfileActions;

    public function __construct()
    {
        parent::__construct();

        // load models
        $this->userModel = $this->loadModel('User');
        $this->authModel = $this->loadModel('Auth');
        $this->logModel = $this->loadModel('Log');
    }

    public function profile($nickname = '')
    {
        if (empty($nickname)) {
            $this->error('404', 'Page Not Found!');
        } else {
            if ($this->userModel->searchExistingUser($nickname) != false) {
                $userInfo = $this->userModel->searchExistingUser($nickname);
                $job = $this->userModel->getJob($userInfo['Job']);
                $family = $this->userModel->getFamily($userInfo['pFamily']);
                $faction = $this->userModel->getFaction($userInfo['Member']);
                $factionRank = $this->userModel->getFactionRank($userInfo['Member'], $userInfo['Rank']);
                $getVehicle = $this->userModel->getVehicle($userInfo['NickName']);
                $getModelName = $this->userModel->getModelName($userInfo['NickName']);
                $getBusiness = $this->userModel->getBusiness($userInfo['NickName']);
                $getHouse = $this->userModel->getHouse($userInfo['NickName']);
                $userFH = $this->userModel->getUserFH($userInfo['ID']);

                $userGroups = implode($this->userModel->getUserGroups($nickname));
                $userGroupsArr = unserialize($userGroups);

                $finalGroups = array();
                if ($userGroupsArr) {
                    foreach ($userGroupsArr as $key => $value) {
                        $gInfo = $this->userModel->getUserGroupName($value);
                        array_push($finalGroups, $gInfo);
                    }
                }

                $data = [
                    'pageTitle' => $userInfo['NickName'] . "'s Profile",
                    'user' => $userInfo,
                    'userGroups' => $finalGroups,
                    'job' => $job,
                    'family' => $family,
                    'faction' => $faction,
                    'factionRank' => $factionRank,
                    'getVehicle' => $getVehicle,
                    'getModelName' => $getModelName,
                    'getBusiness' => $getBusiness,
                    'getHouse' => $getHouse,
                    'userFH' => $userFH
                ];

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if ($this->privileges['isAdmin'] > 6) {
                        if (isset($_POST['suspend_user'])) {
                            // sanitize post data
                            $_POST['suspend_time'] = filter_var($_POST['suspend_time'], FILTER_SANITIZE_NUMBER_INT);
                            $_POST['suspend_reason'] = filter_var($_POST['suspend_reason'], FILTER_SANITIZE_STRING);

                            // handle errors
                            $errors = ValidateProfileActions::validateSuspend($_POST);

                            if (!empty($errors['days_error'])) {
                                flashMessage('danger', $errors['days_error']);
                                redirect('/users/profile/' . $nickname);
                            } else if (!empty($errors['reason_error'])) {
                                flashMessage('danger', $errors['reason_error']);
                                redirect('/users/profile/' . $nickname);
                            } else {
                                if ($_POST['suspend_time'] == 999) {
                                    $suspendedUntil = 0;
                                } else {
                                    $suspendedUntil = time() + 86400 * $_POST['suspend_time'];
                                }

                                $postData = [
                                    'user_id' => $userInfo['ID'],
                                    'suspended_until' => $suspendedUntil,
                                    'reason' => $_POST['suspend_reason'],
                                    'suspended_by' => $_SESSION['user_id']
                                ];

                                // suspend user
                                if ($this->userModel->suspendUser($postData)) {
                                    // log action
                                    $logAction = $_SESSION['user_name'] . ' suspended user ' . $userInfo['NickName'] . ' (ID: ' . $userInfo['ID'] . ') for ' . $_POST['suspend_time'] . ' days. Reason: ' . $_POST['suspend_reason'] . '.';
                                    $logData = [
                                        'type' => 'Suspend',
                                        'action' => $logAction
                                    ];
                                    $this->logModel->adminLog($logData);

                                    flashMessage('success', 'User has been successfully suspended.');
                                    redirect('/users/profile/' . $nickname);
                                } else {
                                    die('Something went wrong.');
                                }
                            }
                        }
                    }
                } else {
                    // load the profile view
                    $this->loadView('profile', $data);
                }

            } else {
                // add session message
                flashMessage('info', 'User not found.');
                // redirect logged in user to the main page
                redirect('/');
            }
        }
    }

    public function settings($urlParam = 'overview')
    {
        $allowedParams = array('overview', 'change-email', 'change-password', 'forum-name', 'email-login', 'authenticator');

        if (!isLoggedIn()) {
            flashMessage('danger', 'Please log in to be able to access this page.');
            redirect('/');
        } else if (!in_array($urlParam, $allowedParams)) {
            $this->error('404', 'Page Not Found!');
        } else {
            $userInfo = $this->userModel->searchUserById($_SESSION['user_id']);

            $data = [
                'pageTitle' => "Settings",
                'userInfo' => $userInfo,
                'urlParam' => $urlParam
            ];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['change_email'])) {
                    // sanitize post data
                    $_POST['new_email'] = filter_var($_POST['new_email'], FILTER_SANITIZE_EMAIL);
                    $_POST['confirm_password'] = filter_var($_POST['confirm_password'], FILTER_SANITIZE_STRING);

                    // handle errors
                    $errors = ValidateSettings::validateEmailChange($_POST, $userInfo);

                    // check if there are no errors
                    if (count(array_filter($errors)) == 0) {
                        // update email
                        if ($this->userModel->updateUserEmail($_SESSION['user_id'], $_POST['new_email'])) {
                            // log action
                            $logAction = $_SESSION['user_name'] . ' changed his account email from ' . $userInfo['Mail'] . ' to ' . $_POST['new_email'] . '.';
                            $logData = [
                                'type' => 'Account',
                                'action' => $logAction
                            ];
                            $this->logModel->playerLog($logData);

                            flashMessage('success', 'Your email has been successfully changed.');
                            redirect('/users/settings');
                        } else {
                            die('Something went wrong.');
                        }
                    } else {
                        // load view with errors
                        $this->loadView('settings', $data, $errors);
                    }

                } else if (isset($_POST['change_forum_nick'])) {
                    // sanitize post data
                    $_POST['form_nickname'] = filter_var($_POST['forum_nickname'], FILTER_SANITIZE_STRING);

                    // handle errors
                    $errors = ValidateSettings::validateForumNameChange($_POST);

                    // check if there are no errors
                    if (count(array_filter($errors)) == 0) {
                        // update forum name
                        if ($this->userModel->updateForumName($_SESSION['user_id'], $_POST['forum_nickname'])) {
                            // log action
                            $logAction = $_SESSION['user_name'] . ' changed his forum name from ' . $userInfo['ForumName'] . ' to ' . $_POST['forum_nickname'] . '.';
                            $logData = [
                                'type' => 'Account',
                                'action' => $logAction
                            ];
                            $this->logModel->playerLog($logData);

                            flashMessage('success', 'Your forum name has been successfully changed.');
                            redirect('/users/settings');
                        } else {
                            die('Something went wrong.');
                        }
                    } else {
                        // load view with errors
                        $this->loadView('settings', $data, $errors);
                    }

                } else if (isset($_POST['change_password'])) {
                    // sanitize post data
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                    // handle errors
                    $errors = ValidateSettings::validatePasswordChange($_POST, $userInfo);

                    // check if there are no errors
                    if (count(array_filter($errors)) == 0) {
                        // hash password
                        $_POST['new_password'] = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

                        // change password
                        if ($this->userModel->updateUserPassword($_SESSION['user_id'], $_POST['new_password'])) {
                            // log action
                            $logAction = $_SESSION['user_name'] . ' changed his account password.';
                            $logData = [
                                'type' => 'Account',
                                'action' => $logAction
                            ];
                            $this->logModel->playerLog($logData);

                            flashMessage('success', 'Your password has been changed successfully.');
                            redirect('/users/settings');
                        } else {
                            die('Something went wrong.');
                        }
                    } else {
                        // load view with errors
                        $this->loadView('settings', $data, $errors);
                    }

                } else if (isset($_POST['activate_email_start']) && empty($_POST['activate_email_start'])) {
                    $sendCode = random_int(100000, 999999);
                    $_SESSION['secure_code'] = $sendCode;
                    $message = "Salutare " . $_SESSION['user_name'] . ",<br><br>Ai ales sa activezi optiunea de autentificare prin email. Introdu codul de mai jos pentru a finaliza actiunea.<br><br>Codul de securitate este: " . $sendCode . ".";
                    sendMail($userInfo['Mail'], 'do-not-reply@dreamvibe.ro', 'DreamVibe RPG', 'Activare Email Login', $message);

                    // load view
                    $this->loadView('settings', $data);

                } else if (isset($_POST['activate_email_end'])) {
                    // sanitize post data
                    $_POST['secret_code'] = filter_var($_POST['secret_code'], FILTER_SANITIZE_NUMBER_INT);

                    // handle errors
                    $errors = ValidateSettings::validateEmailCode($_POST, $_SESSION['secure_code']);

                    // check if there are no errors
                    if (count(array_filter($errors)) == 0) {
                        // activate email login
                        if ($this->userModel->changeEmailLogin($_SESSION['user_id'], 1)) {
                            // log action
                            $logAction = $_SESSION['user_name'] . ' activated Email Login for his account.';
                            $logData = [
                                'type' => 'Account',
                                'action' => $logAction
                            ];
                            $this->logModel->playerLog($logData);

                            unset($_SESSION['secure_code']);
                            $_POST = array();
                            flashMessage('success', 'You have successfully activated email login.');
                            redirect('/users/settings/email-login');
                        } else {
                            die('Something went wrong.');
                        }
                    } else {
                        $_POST['activate_email_start'] = "thatIsTopSECRET";

                        // load view with errors
                        $this->loadView('settings', $data, $errors);
                    }

                } else if (isset($_POST['deactivate_email_start']) && empty($_POST['deactivate_email_start'])) {
                    $sendCode = random_int(100000, 999999);
                    $_SESSION['secure_code_check'] = $sendCode;
                    $message = "Salutare " . $_SESSION['user_name'] . ",<br><br>Ai ales sa dezactivezi optiunea de autentificare prin email.<br>Daca ai fost tu, introdu codul de mai jos pentru a finaliza actiunea. Daca nu tu ai facut acest lucru, iti recomandam sa ignori acest email si sa iti schimbi parola contului.<br><br>Codul de securitate este: " . $sendCode . ".";
                    sendMail($userInfo['Mail'], 'do-not-reply@dreamvibe.ro', 'DreamVibe RPG', 'Dezactivare Email Login', $message);

                    // load view
                    $this->loadView('settings', $data);

                } else if (isset($_POST['deactivate_email_end'])) {
                    // sanitize post data
                    $_POST['secret_code_check'] = filter_var($_POST['secret_code_check'], FILTER_SANITIZE_NUMBER_INT);
                    $_POST['confirm_user_pass'] = filter_var($_POST['confirm_user_pass'], FILTER_SANITIZE_STRING);

                    // handle errors
                    $errors = ValidateSettings::validateEmailCodeDisabling($_POST, $_SESSION['secure_code_check'], $userInfo);

                    // check if there are no errors
                    if (count(array_filter($errors)) == 0) {
                        // deactivate email login
                        if ($this->userModel->changeEmailLogin($_SESSION['user_id'], 0)) {
                            // log action
                            $logAction = $_SESSION['user_name'] . ' deactivated Email Login for his account.';
                            $logData = [
                                'type' => 'Account',
                                'action' => $logAction
                            ];
                            $this->logModel->playerLog($logData);

                            unset($_SESSION['secure_code_check']);
                            $_POST = array();
                            flashMessage('success', 'Email login has been successfully deactivated.');
                            redirect('/users/settings/email-login');
                        } else {
                            die('Something went wrong.');
                        }
                    } else {
                        $_POST['deactivate_email_start'] = "topSecretTOO";

                        // load view with errors
                        $this->loadView('settings', $data, $errors);
                    }

                } else if (isset($_POST['activate_auth_start']) && empty($_POST['activate_auth_start'])) {
                    $_SESSION['dv_secret_code'] = $this->authModel->createSecretCode();
                    $_SESSION['dv_qr_code'] = $this->authModel->createQrCode($_SESSION['user_name'], $_SESSION['dv_secret_code']);
                    $_SESSION['dv_auth_code'] = $this->authModel->createCode($_SESSION['dv_secret_code']);

                    // load view
                    $this->loadView('settings', $data);

                } else if (isset($_POST['activate_auth_end'])) {
                    // sanitize post data
                    $_POST['g_auth_code'] = filter_var($_POST['g_auth_code'], FILTER_SANITIZE_NUMBER_INT);

                    // handle errors
                    $errors = ValidateSettings::validateGAuthEnabling($_POST, $_SESSION['dv_auth_code']);

                    // check if there are no errors
                    if (count(array_filter($errors)) == 0) {
                        // enable google authenticator
                        if ($this->userModel->enableGAuth($_SESSION['user_id'], $_SESSION['dv_secret_code'])) {
                            // log action
                            $logAction = $_SESSION['user_name'] . ' activated Google Authenticator for his account.';
                            $logData = [
                                'type' => 'Account',
                                'action' => $logAction
                            ];
                            $this->logModel->playerLog($logData);

                            unset($_SESSION['dv_secret_code']);
                            unset($_SESSION['dv_qr_code']);
                            unset($_SESSION['dv_auth_code']);
                            $_POST = array();
                            flashMessage('success', 'Google Authenticator has been successfully enabled.');
                            redirect('/users/settings/authenticator');
                        } else {
                            die('Something went wrong.');
                        }
                    } else {
                        $_POST['activate_auth_start'] = "thatIsSecret";
                        $_SESSION['dv_auth_code'] = $this->authModel->createCode($_SESSION['dv_secret_code']);

                        // load view with errors
                        $this->loadView('settings', $data, $errors);
                    }

                } else if (isset($_POST['deactivate_auth_start']) && empty($_POST['deactivate_auth_start'])) {
                    $sendCode = random_int(100000, 999999);
                    $_SESSION['auth_code_check'] = $sendCode;
                    $message = "Salutare " . $_SESSION['user_name'] . ",<br><br>Ai ales sa dezactivezi optiunea de autentificare prin Google Authenticator..<br>Daca ai fost tu, introdu codul de mai jos pentru a finaliza actiunea. Daca nu tu ai facut acest lucru, iti recomandam sa ignori acest email si sa iti schimbi parola contului.<br><br>Codul de securitate este: " . $sendCode . ".";
                    sendMail($userInfo['Mail'], 'do-not-reply@dreamvibe.ro', 'DreamVibe RPG', 'Dezactivare Google Authenticator', $message);

                    // load view
                    $this->loadView('settings', $data);

                } else if (isset($_POST['deactivate_auth_end'])) {
                    // sanitize post data
                    $_POST['g_auth_code_check'] = filter_var($_POST['g_auth_code_check'], FILTER_SANITIZE_NUMBER_INT);
                    $_POST['confirm_auth_pass'] = filter_var($_POST['confirm_auth_pass'], FILTER_SANITIZE_STRING);

                    // handle errors
                    $errors = ValidateSettings::validateGAuthDisabling($_POST, $_SESSION['auth_code_check'], $userInfo);

                    // check if there are no errors
                    if (count(array_filter($errors)) == 0) {
                        // disable google authenticator
                        if ($this->userModel->disableGAuth($_SESSION['user_id'])) {
                            // log action
                            $logAction = $_SESSION['user_name'] . ' deactivated Google Authenticator for his account.';
                            $logData = [
                                'type' => 'Account',
                                'action' => $logAction
                            ];
                            $this->logModel->playerLog($logData);

                            unset($_SESSION['auth_code_check']);
                            $_POST = array();
                            flashMessage('success', 'Google Authenticator has been successfully disabled for your account.');
                            redirect('/users/settings/authenticator');
                        } else {
                            die('Something went wrong.');
                        }
                    } else {
                        $_POST['deactivate_auth_start'] = "thatIsSecretToo";

                        // load view with errors
                        $this->loadView('settings', $data, $errors);
                    }
                }
            } else {
                // load settings view
                $this->loadView('settings', $data);
            }
        }
    }
}