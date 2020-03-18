<?php
/**
 * @brief Admin controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class AdminController extends Controller
{
    private $privileges;

    public function __construct()
    {
        // store user privileges
        $this->privileges = $this->checkPrivileges();

        if ($this->privileges['isAdmin'] == 0) {
            // add session message
            flashMessage('danger', 'You are not allowed to access this page.');
            // redirect to main page
            redirect('/');
        }

    }
    public function index()
    {
        global $lang;

        $data = [
            'pageTitle' => 'Admin Panel',
            'name' => $_SESSION['user_name'],
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'lang' => $lang
        ];

        $this->loadView('admin', $data);
    }
}