<?php
/**
 * @brief Owner controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Owner extends MainController
{
    private $userModel;

    public function __construct()
    {
        // load the model
        $this->userModel = $this->loadModel('User');

        $fullAccess = $this->userModel->checkFullAccess($_SESSION['user_name']);
        if (!$fullAccess) {
            // add session message
            flashMessage('danger', 'You are not allowed to access this page.');
            // redirect to main page
            redirect('/');
        }

    }
    public function index()
    {
        $data = [
            'pageTitle' => 'Home',
            'name' => $_SESSION['user_name']
        ];
        $this->loadView('owner', $data);
    }
}