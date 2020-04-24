<?php
/**
 * @brief Admin controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class AdminController extends Controller
{
    private $generalModel;
    private $secretModel;
    private $logModel;
    private $privileges;

    public function __construct()
    {
        // load models
        $this->generalModel = $this->loadModel('General');
        $this->secretModel = $this->loadModel('Secret');
        $this->logModel = $this->loadModel('Log');

        // store user privileges
        $this->privileges = $this->checkPrivileges();

        if ($this->privileges['isAdmin'] < 1) {
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
        $openTickets = $this->generalModel->countTickets('Open');
        $openComplaints = $this->generalModel->countComplaints('Open');
        $openUnbans = $this->generalModel->countUnbans('Open');
        $openHelperApps = $this->secretModel->countHelperApps();
        $factions = $this->secretModel->getFactions();

        $data = [
            'pageTitle' => 'Admin Panel',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'lang' => $lang,
            'badges' => $badges,
            'openTickets' => $openTickets,
            'openComplaints' => $openComplaints,
            'openUnbans' => $openUnbans,
            'openHelperApps' => $openHelperApps,
            'factions' => $factions
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($data['isAdmin'] > 4) {
                if (isset($_POST['open_applications'])) {
                    if ($this->secretModel->changeAppsStatus($_POST['faction_id'], 1)) {
                        $logAction = $_SESSION['user_name'] . ' opened applications for faction ' . $_POST['faction_id'] . '.';
                        $logData = [
                            'type' => 'Application',
                            'action' => $logAction
                        ];
                        $this->logModel->adminLog($logData);
                        flashMessage('success', 'Faction applications have been successfully opened.');
                        redirect('/admin');
                    } else {
                        die('Something went wrong.');
                    }
                } else if (isset($_POST['close_applications'])) {
                    if ($this->secretModel->changeAppsStatus($_POST['faction_id'], 0)) {
                        $logAction = $_SESSION['user_name'] . ' closed applications for faction ' . $_POST['faction_id'] . '.';
                        $logData = [
                            'type' => 'Application',
                            'action' => $logAction
                        ];
                        $this->logModel->adminLog($logData);
                        flashMessage('success', 'Faction applications have been successfully closed.');
                        redirect('/admin');
                    } else {
                        die('Something went wrong.');
                    }
                }
            }
        } else {
            // load view
            $this->loadView('admin', $data);
        }
    }
}