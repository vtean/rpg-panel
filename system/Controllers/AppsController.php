<?php
/**
 * @brief Applications controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/Validations/ValidateApplication.php';

class AppsController extends Controller
{
    private $appModel;
    private $privileges;
    use ValidateApplication;

    public function __construct()
    {
        // load model
        $this->appModel = $this->loadModel('App');

        // store privileges
        $this->privileges = $this->checkPrivileges();

        if (!isLoggedIn()) {
            flashMessage('danger', 'You must log in to be able to post an application.');
            redirect('/');
        }
    }

    public function index()
    {
        global $lang;

        $badges = $this->badges();

        if ($this->privileges['isAdmin'] > 2) {
            $helperApps = $this->appModel->getAllApps('helper');
            $leaderApps = $this->appModel->getAllApps('leader');
        } else {
            $helperApps = $this->appModel->getUserApps($_SESSION['user_id'], 'helper');
            $leaderApps = $this->appModel->getUserApps($_SESSION['user_id'], 'leader');
        }

        $data = [
            'pageTitle' => 'Applications',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'lang' => $lang,
            'badges' => $badges,
            'helperApps' => $helperApps,
            'leaderApps' => $leaderApps
        ];

        // load view
        $this->loadView('apps_index', $data);
    }

    public function create($firstParam = '', $secondParam = '')
    {
        if ($firstParam == 'helper' && empty($secondParam) || $firstParam == 'leader' && !empty($secondParam)) {
            global $lang;

            $badges = $this->badges();

            $allowedSecond = array('lspd', 'rcpd', 'fbi', 'sfpd', 'lshospital', 'government', 'lvarmy', 'sfhospital', 'instructors', 'nrls', 'grove', 'vagos', 'ballas', 'aztecas', 'rifa', 'russian', 'yakuza', 'lcn', 'warlock', 'lsarmy', 'bank', 'lvhospital', 'lvpd', 'nrlv', 'wolves', 'nrsf', 'sfarmy', 'msp');

            $data = [
                'pageTitle' => 'Apply',
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'lang' => $lang,
                'badges' => $badges
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
        global $lang;
        $userApp = $this->appModel->getApp($id);
        $badges = $this->badges();

        if ($id = 0 || empty($userApp)) {
            $this->error('404', 'Application not found!');
        } else if (in_array(1, $this->privileges['canEditLApps']) || in_array(1, $this->privileges['canEditHApps']) || $_SESSION['user_id'] == $userApp['author_id']) {
            $data = [
                'pageTitle' => 'Edit App',
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'canEditHApps' => in_array(1, $this->privileges['canEditHApps']),
                'canEditLApps' => in_array(1, $this->privileges['canEditLApps']),
                'lang' => $lang,
                'badges' => $badges,
                'userApp' => $userApp
            ];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($data['canEditLApps'] || $data['canEditHApps'] || $_SESSION['user_id'] == $userApp['author_id']) {
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
                            if ($this->appModel->editApp($postData, $id)) {
                                flashMessage('success', 'Application has been successfully edited.');
                                redirect('/apps');
                            } else {
                                die('Something went wrong');
                            }
                        } else {
                            // load view with errors
                            $this->loadView('app_edit', $data, $errors);
                        }
                    }
                } else {
                    die('No no no');
                }
            } else {
                // load view
                $this->loadView('app_edit', $data);
            }
        } else {
            $this->error('403', 'Forbidden!');
        }
    }
}