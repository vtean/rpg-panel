<?php
/**
 * @brief Main index controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Main extends MainController
{
    private $userModel;

    public function __construct()
    {
        // load the model
        $this->userModel = $this->loadModel('User');
    }
    public function index()
    {
        $fullAccess = $this->userModel->checkFullAccess($_SESSION['user_name']);
        $isAdmin = $this->userModel->checkAdmin($_SESSION['user_name']);
        $isLeader = $this->userModel->checkLeader($_SESSION['user_name']);
        $data = [
            'pageTitle' => 'Home',
            'fullAccess' => $fullAccess,
            'isAdmin' => $isAdmin,
            'isLeader' => $isLeader
        ];
        $this->loadView('main', $data);
    }
}