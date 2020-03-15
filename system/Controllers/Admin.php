<?php
/**
 * @brief Admin controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Admin extends MainController
{
    private $generalModel;

    public function __construct()
    {
        // load the model
        $this->generalModel = $this->loadModel('General');

        $admin = $this->generalModel->checkAdmin($_SESSION['user_name']);
        if ($admin == 0) {
            // add session message
            flashMessage('danger', 'You are not allowed to access this page.');
            // redirect to main page
            redirect('/');
        }

    }
    public function index()
    {
        $admin = $this->generalModel->checkAdmin($_SESSION['user_name']);
        $data = [
            'pageTitle' => 'Home',
            'name' => $_SESSION['user_name'],
            'admin' => $admin
        ];
        $this->loadView('admin', $data);
    }
}