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

    public function __construct()
    {
        // load the model
        $this->userModel = $this->loadModel('User');
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
            $data = [
                'pageTitle' => $userInfo['NickName'] . "'s Profile",
                'user' => $userInfo
            ];
            // load the profile view
            $this->loadView('profile', $data);
        }
    }
}