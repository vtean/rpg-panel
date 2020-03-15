<?php
/**
 * @brief MainController index controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class MainController extends Controller
{
    private $generalModel;

    public function __construct()
    {
        // load the model
        $this->generalModel = $this->loadModel('General');
    }
    public function index()
    {
        $fullAccess = isLoggedIn() ? $this->generalModel->checkFullAccess($_SESSION['user_name']) : 0;
        $isAdmin = isLoggedIn() ? $this->generalModel->checkAdmin($_SESSION['user_name']) : 0;
        $isLeader = isLoggedIn() ? $this->generalModel->checkLeader($_SESSION['user_name']) : 0;
        $data = [
            'pageTitle' => 'Home',
            'fullAccess' => $fullAccess,
            'isAdmin' => $isAdmin,
            'isLeader' => $isLeader
        ];
        $this->loadView('main', $data);
    }
}