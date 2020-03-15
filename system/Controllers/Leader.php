<?php
/**
 * @brief Leader controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Leader extends MainController
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
        $leader = $this->generalModel->checkLeader($_SESSION['user_name']);
        if ($leader != 0 ) {
            $faction = $this->userModel->getFaction($leader);
        }
        $data = [
            'pageTitle' => 'Home',
            'name' => $_SESSION['user_name'],
            'faction' => $faction['Name']
        ];
        $this->loadView('leader', $data);
    }
}