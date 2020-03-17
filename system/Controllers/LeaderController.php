<?php
/**
 * @brief LeaderController controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class LeaderController extends Controller
{
    private $userModel;
    private $privileges;

    public function __construct()
    {
        // load user model
        $this->userModel = $this->loadModel('User');

        // store user privileges
        $this->privileges = $this->checkPrivileges();

        if ($this->privileges['isLeader'] == 0) {
            // add session message
            flashMessage('danger', 'You are not allowed to access this page.');
            // redirect to main page
            redirect('/');
        }

    }
    public function index()
    {
        if ($this->privileges['isLeader'] != 0 ) {
            $factionName = $this->userModel->getFaction($this->privileges['isLeader']);
        }
        $data = [
            'pageTitle' => 'Leader Panel',
            'name' => $_SESSION['user_name'],
            'faction' => $factionName,
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader']
        ];
        $this->loadView('leader', $data);
    }
}