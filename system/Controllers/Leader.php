<?php
/**
 * @brief Leader controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Leader extends MainController
{
    private $userModel;

    public function __construct()
    {
        // load the model
        $this->userModel = $this->loadModel('User');

        $leader = $this->userModel->checkLeader($_SESSION['user_name']);
        if ($leader == 0) {
            // add session message
            flashMessage('danger', 'You are not allowed to access this page.');
            // redirect to main page
            redirect('/');
        }

    }
    public function index()
    {
        $leader = $this->userModel->checkLeaderq($_SESSION['user_name']);
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