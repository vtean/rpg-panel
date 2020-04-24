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
    private $secretModel;
    private $logModel;

    public function __construct()
    {
        parent::__construct();

        // load models
        $this->generalModel = $this->loadModel('General');
        $this->secretModel = $this->loadModel('Secret');
        $this->logModel = $this->loadModel('Log');

        if ($this->privileges['isLeader'] == 0) {
            // add session message
            flashMessage('danger', 'You are not allowed to access this page.');
            // redirect to main page
            redirect('/');
        }
    }

    public function index()
    {
        $faction = $this->secretModel->getLeaderFaction($this->privileges['isLeader']);
        $openComplaints = $this->secretModel->countFactionComplaints($this->privileges['isLeader'], 'Open');
        $openApplications = $this->secretModel->countFactionApplications($this->privileges['isLeader'], 'Open');
        $openResignations = $this->secretModel->countFactionResignations($this->privileges['isLeader'], 'Open');

        $data = [
            'pageTitle' => 'Leader Panel',
            'faction' => $faction,
            'openComplaints' => $openComplaints,
            'openApplications' => $openApplications,
            'openResignations' => $openResignations
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->privileges['isLeader'] > 0 && isset($_POST['close_applications'])) {
                if ($this->secretModel->changeAppsStatus($this->privileges['isLeader'], 0)) {
                    // log action
                    $logAction = $_SESSION['user_name'] . ' closed applications for faction (ID: ' . $this->privileges['isLeader'] . ').';
                    $logData = [
                        'type' => 'Faction Application',
                        'action' => $logAction
                    ];
                    $this->logModel->leaderLog($logData);

                    flashMessage('success', 'Faction applications have been successfully closed.');
                    redirect('/leader');
                } else {
                    die('Something went wrong.');
                }
            } else if ($this->privileges['isLeader'] > 0 && isset($_POST['open_applications'])) {
                if ($this->secretModel->changeAppsStatus($this->privileges['isLeader'], 1)) {
                    // log action
                    $logAction = $_SESSION['user_name'] . ' opened applications for faction (ID: ' . $this->privileges['isLeader'] . ').';
                    $logData = [
                        'type' => 'Faction Application',
                        'action' => $logAction
                    ];
                    $this->logModel->leaderLog($logData);

                    flashMessage('success', 'Faction applications have been successfully opened.');
                    redirect('/leader');
                } else {
                    die('Something went wrong.');
                }
            }
        } else {
            // load view
            $this->loadView('leader', $data);
        }
    }
}