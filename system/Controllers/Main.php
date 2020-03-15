<?php
/**
 * @brief Main index controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Main extends MainController
{
    private $generalModel;

    public function __construct()
    {
        // load the model
        $this->generalModel = $this->loadModel('General');

    }
    public function index()
    {
        $fullAccess = $this->generalModel->checkFullAccess($_SESSION['user_name']);
        $isAdmin = $this->generalModel->checkAdmin($_SESSION['user_name']);
        $isLeader = $this->generalModel->checkLeader($_SESSION['user_name']);
        $data = [
            'pageTitle' => 'Home',
            'fullAccess' => $fullAccess,
            'isAdmin' => $isAdmin,
            'isLeader' => $isLeader
        ];
        $this->loadView('main', $data);
    }
}