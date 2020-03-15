<?php
/**
 * @brief LoginController controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/Validations/ValidateLogin.php';

class LoginController extends Controller
{
    use ValidateLogin;
    private $authModel;
    private $generalModel;

    public function __construct()
    {
        // load the model
        $this->authModel = $this->loadModel('Auth');
        // load general model
        $this->generalModel = $this->loadModel('General');
    }

    public function index()
    {
        // check if user is logged in or not
        if (isLoggedIn()) {
            // add session message
            flashMessage('info', 'You are already logged in.');
            // redirect logged in user to the main page
            redirect('/');
        } else {
            $fullAccess = isLoggedIn() ? $this->generalModel->checkFullAccess($_SESSION['user_name']) : 0;
            $isAdmin = isLoggedIn() ? $this->generalModel->checkAdmin($_SESSION['user_name']) : 0;
            $isLeader = isLoggedIn() ? $this->generalModel->checkLeader($_SESSION['user_name']) : 0;
            // check if the form is submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // user data
                $data = [
                    'pageTitle' => 'LoginController',
                    'user_name' => $_POST['username'],
                    'user_password' => $_POST['password'],
                    'fullAccess' => $fullAccess,
                    'isAdmin' => $isAdmin,
                    'isLeader' => $isLeader
                ];

                // check if the user with this username exists
                $userCheck = $this->authModel->searchExistingUsername($data['user_name']);

                // handle errors
                $errors = ValidateLogin::validateInput($data, $userCheck);

                // check if there are errors
                if (count(array_filter($errors)) == 0) {
                    // log in the user
                    $loggedInUser = $this->authModel->loginUser($data['user_name'], $data['user_password']);
                    // store group id
//                    $userGroup = $this->authModel->checkGroup($loggedInUser['user_group_id']);
                    if ($loggedInUser) {
                        // add a session message
                        flashMessage('success', 'You were successfully logged in.');
                        // start the session
                        $this->authModel->startSession($loggedInUser);
                        // redirect
                        redirect('/');
                    } else {
                        die('Oops, something went wrong');
                    }
                } else {
                    // load the view with errors
                    $this->loadView('login', $data, $errors);
                }

            } else {
                $data = [
                    'pageTitle' => 'LoginController',
                    'user_name' => '',
                    'fullAccess' => $fullAccess,
                    'isAdmin' => $isAdmin,
                    'isLeader' => $isLeader
                ];

                $errors = [
                    'user_name_error' => '',
                    'user_password_error' => ''
                ];

                // load the view
                $this->loadView('login', $data, $errors);
            }
        }
    }
}