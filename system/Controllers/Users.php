<?php
/**
 * @brief Users controller
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Users extends MainController
{
    private $userModel;
    private $generalModel;

    public function __construct()
    {
        // load the model
        $this->userModel = $this->loadModel('User');
        // load general model
        $this->generalModel = $this->loadModel('General');
    }

    public function index()
    {
        echo 'aloha bitch';
    }

    public function profile($nickname = '')
    {
        if (empty($nickname)) {
            echo 'nothing to see here';
        } else {
            if ($this->userModel->searchExistingUser($nickname) != false) {
                $userInfo = $this->userModel->searchExistingUser($nickname);
            } else {
                // add session message
                flashMessage('info', 'User not found.');
                // redirect logged in user to the main page
                redirect('/');
            }
            $fullAccess = isLoggedIn() ? $this->generalModel->checkFullAccess($_SESSION['user_name']) : 0;
            $isAdmin = isLoggedIn() ? $this->generalModel->checkAdmin($_SESSION['user_name']) : 0;
            $isLeader = isLoggedIn() ? $this->generalModel->checkLeader($_SESSION['user_name']) : 0;
            $data = [
                'pageTitle' => $userInfo['NickName'] . "'s Profile",
                'user' => $userInfo,
                'fullAccess' => $fullAccess,
                'isAdmin' => $isAdmin,
                'isLeader' => $isLeader
            ];
            // load the profile view
            $this->loadView('profile', $data);
        }
    }
}