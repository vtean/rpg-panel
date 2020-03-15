<?php
/**
 * @brief LeaderController controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class LeaderController extends Controller
{
    private $generalModel;
    private $userModel;

    public function __construct()
    {
        // load models
        $this->generalModel = $this->loadModel('General');
        $this->userModel = $this->loadModel('user');

        $leader = $this->generalModel->checkLeader($_SESSION['user_name']);
        if ($leader == 0) {
            // add session message
            flashMessage('danger', 'You are not allowed to access this page.');
            // redirect to main page
            redirect('/');
        }

    }
    public function index()
    {
        $fullAccess = isLoggedIn() ? $this->generalModel->checkFullAccess($_SESSION['user_name']) : 0;
        $isAdmin = isLoggedIn() ? $this->generalModel->checkAdmin($_SESSION['user_name']) : 0;
        $isLeader = isLoggedIn() ? $this->generalModel->checkLeader($_SESSION['user_name']) : 0;
        if ($isLeader != 0 ) {
            $faction = $this->userModel->getFaction($isLeader);
        }
        $data = [
            'pageTitle' => 'Leader Panel',
            'name' => $_SESSION['user_name'],
            'faction' => $faction['Name'],
            'fullAccess' => $fullAccess,
            'isAdmin' => $isAdmin,
            'isLeader' => $isLeader
        ];
        $this->loadView('leader', $data);
    }
}