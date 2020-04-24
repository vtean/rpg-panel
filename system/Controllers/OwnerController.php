<?php
/**
 * @brief Owner Panel controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/Validations/ValidateOwner.php';

class OwnerController extends Controller
{
    private $generalModel;
    private $secretModel;
    private $logModel;
    use ValidateOwner;

    public function __construct()
    {
        parent::__construct();

        // load models
        $this->generalModel = $this->loadModel('General');
        $this->secretModel = $this->loadModel('Secret');
        $this->logModel = $this->loadModel('Log');

        if (!$this->privileges['fullAccess']) {
            // add session message
            flashMessage('danger', 'You are not allowed to access this page.');
            // redirect to main page
            redirect('/');
        }

    }
    public function index()
    {
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
        $helperApps = $this->secretModel->countHelperApps();

        $maintenanceStatus = $this->generalModel->getSettingValue('maintenance_status');
        $maintenanceMessage = html_entity_decode($this->generalModel->getSettingValue('maintenance_message'));

        $data = [
            'pageTitle' => 'Owner Panel',
            'name' => $_SESSION['user_name'],
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
            'ownerUnbans' => $ownerUnbans,
            'helperApps' => $helperApps,
            'maintenanceStatus' => $maintenanceStatus,
            'maintenanceMessage' => $maintenanceMessage
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->privileges['fullAccess'] == 1) {
                if (isset($_POST['panel_maintenance'])) {
                    // sanitize post data
                    $_POST['maintenance_message'] = htmlentities($_POST['maintenance_message']);
                    $_POST['maintenance_status'] = isset($_POST['maintenance_status']) ? 1 : 0;

                    // handle errors
                    $errors = ValidateOwner::validateMaintenance($_POST);

                    // check if there are no errors
                    if (count(array_filter($errors)) == 0) {
                        $firstSetting = [
                            'setting_key' => 'maintenance_status',
                            'setting_value' => $_POST['maintenance_status']
                        ];

                        $secondSetting = [
                            'setting_key' => 'maintenance_message',
                            'setting_value' => $_POST['maintenance_message']
                        ];

                        // change maintenance status
                        if ($this->secretModel->updatePanelSetting($firstSetting) && $this->secretModel->updatePanelSetting($secondSetting)) {
                            // log action
                            $logAction = $_SESSION['user_name'] . ' changed panel maintenance status to ' . $_POST['maintenance_status'] . '.';
                            $logData = [
                                'type' => 'Panel',
                                'action' => $logAction
                            ];
                            $this->logModel->adminLog($logData);

                            flashMessage('success', 'Maintenance mode has been successfully updated.');
                            redirect('/owner');
                        } else {
                            die('Something went wrong.');
                        }
                    } else {
                        // load view with errors
                        $this->loadView('owner', $data, $errors);
                    }
                }
            }
        } else {
            // load view
            $this->loadView('owner', $data);
        }
    }
}