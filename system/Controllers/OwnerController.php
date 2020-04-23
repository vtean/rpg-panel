<?php
/**
 * @brief Owner Panel controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class OwnerController extends Controller
{
    private $generalModel;
    private $privileges;

    public function __construct()
    {
        // load model
        $this->generalModel = $this->loadModel('General');

        // store user privileges
        $this->privileges = $this->checkPrivileges();

        if (!$this->privileges['fullAccess']) {
            // add session message
            flashMessage('danger', 'You are not allowed to access this page.');
            // redirect to main page
            redirect('/');
        }

    }
    public function index()
    {
        global $lang;
        $badges = $this->badges();
        $allTickets = $this->generalModel->countAllTickets();
        $openTickets = $this->generalModel->countTickets('Open');
        $closedTickets = $this->generalModel->countTickets('Closed');
        $ownerTickets = $this->generalModel->countTickets('Needs Owner Involvement');
        $allComplaints = $this->generalModel->countAllComplaints();
        $openComplaints = $this->generalModel->countComplaints('Open');
        $closedComplaints = $this->generalModel->countComplaints('Closed');
        $ownerComplaints = $this->generalModel->countComplaints('Needs Owner Involvement');
        $allUnbans = $this->generalModel->countAllUnbans();
        $openUnbans = $this->generalModel->countUnbans('Open');
        $closedUnbans = $this->generalModel->countUnbans('Closed');
        $ownerUnbans = $this->generalModel->countUnbans('Needs Owner Involvement');

        $data = [
            'pageTitle' => 'Owner Panel',
            'name' => $_SESSION['user_name'],
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'lang' => $lang,
            'badges' => $badges,
            'allTickets' => $allTickets,
            'openTickets' => $openTickets,
            'closedTickets' => $closedTickets,
            'ownerTickets' => $ownerTickets,
            'allComplaints' => $allComplaints,
            'openComplaints' => $openComplaints,
            'closedComplaints' => $closedComplaints,
            'ownerComplaints' => $ownerComplaints,
            'allUnbans' => $allUnbans,
            'openUnbans' => $openUnbans,
            'closedUnbans' => $closedUnbans,
            'ownerUnbans' => $ownerUnbans
        ];

        $this->loadView('owner', $data);
    }
}