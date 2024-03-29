<?php
/**
 * @brief Applications controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/Validations/ValidateApplication.php';

class ApplicationsController extends Controller
{
    private $appModel;
    private $logModel;
    use ValidateApplication;

    public function __construct()
    {
        parent::__construct();

        // load models
        $this->appModel = $this->loadModel('Application');
        $this->logModel = $this->loadModel('Log');

        if (!isLoggedIn()) {
            flashMessage('danger', 'You must log in to be able to post an application.');
            redirect('/');
        }
    }

    public function index()
    {
        $fWithoutLeader = $this->appModel->factionsWithoutLeader();

        if ($this->privileges['isAdmin'] > 2) {
            $helperApps = $this->appModel->getAllApps('helper');
            $leaderApps = $this->appModel->getAllApps('leader');
        } else {
            $helperApps = $this->appModel->getUserApps($_SESSION['user_id'], 'helper');
            $leaderApps = $this->appModel->getUserApps($_SESSION['user_id'], 'leader');
        }

        $finalLApps = array();
        if (!empty($leaderApps)) {
            foreach ($leaderApps as $lApp) {
                $lApp['faction_name'] = $this->appModel->getFactionInfo($lApp['extra'])['Name'];
                array_push($finalLApps, $lApp);
            }
        }

        $data = [
            'pageTitle' => 'Applications',
            'helperApps' => $helperApps,
            'leaderApps' => $finalLApps,
            'fWithoutLeader' => $fWithoutLeader
        ];

        // load view
        $this->loadView('apps_index', $data);
    }

    public function create($firstParam = '', $secondParam = '')
    {
        if ($firstParam == 'leader' && !empty($secondParam)) {
            $allowedSecond = range(1, 28);
            if (in_array($secondParam, $allowedSecond)) {
                $leaderName = $this->appModel->getFactionInfo($secondParam)['Leader'];
                $appsOpen = $leaderName == 'None';
            }
        }

        if ($firstParam == 'helper' && empty($secondParam) || $firstParam == 'leader' && !empty($secondParam) && in_array($secondParam, $allowedSecond) && $appsOpen) {
            if ($firstParam == 'helper') {
                $alreadyApplied = $this->appModel->alreadyApplied($_SESSION['user_id'], 'helper', 'staff');
            } else if ($firstParam == 'leader') {
                $alreadyApplied = $this->appModel->alreadyApplied($_SESSION['user_id'], 'leader', $secondParam);
            }

            if (($firstParam == 'helper' && $alreadyApplied) || ($firstParam == 'leader' && $alreadyApplied)) {
                flashMessage('danger', 'You have already an application.');
                redirect('/apps');
            }

            $data = [
                'pageTitle' => 'Apply'
            ];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['create_application'])) {
                    // sanitize input
                    $_POST['body'] = htmlentities($_POST['body']);

                    $firstParam = filter_var($firstParam, FILTER_SANITIZE_STRING);
                    $secondParam = filter_var($secondParam, FILTER_SANITIZE_STRING);

                    if ($firstParam == 'helper') {
                        $extra = 'staff';
                    } else if ($firstParam == 'leader' && in_array($secondParam, $allowedSecond)) {
                        $extra = $secondParam;
                    }

                    $postData = [
                        'body' => $_POST['body'],
                        'author_id' => $_SESSION['user_id'],
                        'author_ip' => getUserIp(),
                        'type' => $firstParam,
                        'extra' => $extra
                    ];

                    // handle errors
                    $errors = ValidateApplication::validate($_POST);

                    // check if there are not errors
                    if (count(array_filter($errors)) == 0) {
                        // post app
                        if ($this->appModel->createApplication($postData)) {
                            flashMessage('success', 'Your application has been successfully posted.');
                            redirect('/apps');
                        } else {
                            die('Something went wrong.');
                        }
                    } else {
                        // load the view with errors
                        $this->loadView('app_create', $data, $errors);
                    }
                }
            } else {
                // load view
                $this->loadView('app_create', $data);
            }
        } else {
            $this->error('404', 'Page not found!');
        }
    }

    public function edit($id = 0)
    {
        $userApp = $this->appModel->getApplication($id);
        $userApp['body'] = html_entity_decode($userApp['body']);

        if ($id == 0 || empty($userApp)) {
            $this->error('404', 'Application not found!');
        } else if ($this->privileges['canEditHApps'] && $userApp['type'] == 'helper' || $this->privileges['canEditLApps'] && $userApp['type'] == 'leader' || $_SESSION['user_id'] == $userApp['author_id']) {
            $data = [
                'pageTitle' => 'Edit Application',
                'userApp' => $userApp
            ];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['edit_application'])) {
                    // sanitize post data
                    $_POST['app_body'] = htmlentities($_POST['app_body']);

                    $postData = [
                        'body' => $_POST['app_body'],
                        'isEdited' => 1,
                        'editedBy' => $_SESSION['user_id']
                    ];

                    // handle errors
                    $errors = ValidateApplication::validate($postData);

                    // check if there are no errors
                    if (count(array_filter($errors)) == 0) {
                        // edit app
                        if ($this->appModel->editApplication($postData, $id)) {
                            $logAction = $_SESSION['user_name'] . ' edited application (ID: ' . $id . ').';
                            $logData = [
                                'type' => 'Application',
                                'action' => $logAction
                            ];
                            if ($_SESSION['user_id'] == $userApp['author_id']) {
                                $this->logModel->playerLog($logData);
                            } else {
                                $this->logModel->adminLog($logData);
                            }
                            flashMessage('success', 'Application has been successfully edited.');
                            redirect('/apps/view/' . $id);
                        } else {
                            die('Something went wrong');
                        }
                    } else {
                        // load view with errors
                        $this->loadView('app_edit', $data, $errors);
                    }
                }
            } else {
                // load view
                $this->loadView('app_edit', $data);
            }
        } else {
            $this->error('403', 'Forbidden!');
        }
    }

    public function view($id = 0)
    {
        $userApp = $this->appModel->getApplication($id);
        $userApp['body'] = html_entity_decode($userApp['body']);

        if ($id == 0 || empty($userApp)) {
            $this->error('404', 'Application not found!');
        } else if ($this->privileges['isAdmin'] > 2 || $_SESSION['user_id'] == $userApp['author_id']) {
            if ($userApp['extra'] != 'staff') {
                $userApp['applied_to'] = $this->appModel->getFactionInfo($userApp['extra'])['Name'];
            }
            $userFH = $this->appModel->getUserFH($userApp['author_id']);

            $data = [
                'pageTitle' => $userApp['account_details']['NickName'] . "'s Application",
                'userApp' => $userApp,
                'userFH' => $userFH
            ];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($this->privileges['canDeleteHApps'] && $userApp['type'] == 'helper' || $this->privileges['canDeleteLApps'] && $userApp['type'] == 'leader') {
                    if (isset($_POST['delete_application'])) {
                        // delete application
                        if ($this->appModel->deleteApplication($id)) {
                            $logAction = $_SESSION['user_name'] . ' deleted application (ID: ' . $id . ').';
                            $logData = [
                                'type' => 'Application',
                                'action' => $logAction
                            ];
                            $this->logModel->adminLog($logData);
                            flashMessage('success', 'Application has been deleted successfully.');
                            redirect('/apps');
                        } else {
                            die('Something went wrong.');
                        }
                    }
                }
            } else {
                // load view
                $this->loadView('app_view', $data);
            }
        } else {
            $this->error('403', 'Forbidden!');
        }
    }
}