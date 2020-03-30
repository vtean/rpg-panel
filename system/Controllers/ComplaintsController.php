<?php
/**
 * @brief Complaints controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/Validations/ValidateComplaint.php';

class ComplaintsController extends Controller
{
    use ValidateComplaint;
    private $complaintModel;
    private $categoryModel;
    private $userModel;
    private $privileges;

    public function __construct()
    {
        global $lang;

        // load models
        $this->complaintModel = $this->loadModel('Complaint');
        $this->categoryModel = $this->loadModel('Category');
        $this->userModel = $this->loadModel('User');

        // store user privileges
        $this->privileges = $this->checkPrivileges();
    }

    public function index()
    {
        global $lang;

        $badge = $this->badges();
        $complaints = $this->complaintModel->getAllComplaints();

        $data = [
            'pageTitle' => 'Complaints',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'canEditAComplaints' => $this->privileges['canEditAComplaints'],
            'lang' => $lang,
            'badges' => $badge,
            'complaints' => $complaints
        ];
        // load view
        $this->loadView('complaints_index', $data);
    }

    public function create()
    {
        global $lang;

        if (isLoggedIn()) {
            $badge = $this->badges();

            $categories = $this->categoryModel->getAllCategories('complaint');

            if (isset($_POST['create_complaint'])) {
                // sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $_POST['complaint_desc'] = str_replace(PHP_EOL, '<br>', $_POST['complaint_desc']);
                $_POST['complaint_desc'] = htmlentities($_POST['complaint_desc']);

                $_POST['complaint_proof'] = str_replace(PHP_EOL, '<br>', $_POST['complaint_proof']);
                $_POST['complaint_proof'] = htmlentities($_POST['complaint_proof']);

                $_POST['other_info'] = str_replace(PHP_EOL, '<br>', $_POST['other_info']);
                $_POST['other_info'] = htmlentities($_POST['other_info']);

                $postData = [
                    'against_name' => $_POST['against_name'],
                    'complaint_category' => $_POST['complaint_category'],
                    'complaint_desc' => $_POST['complaint_desc'],
                    'complaint_proof' => $_POST['complaint_proof'],
                    'other_info' => $_POST['other_info'],
                    'author_id' => $_SESSION['user_id'],
                    'author_ip' => getUserIp(),
                    'status' => 'Open',
                    'is_hidden' => 0
                ];

                $data = [
                    'pageTitle' => 'New Complaint',
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader'],
                    'complaint' => $postData,
                    'lang' => $lang,
                    'badges' => $badge,
                    'categories' => $categories
                ];

                $userCheck = $this->userModel->searchExistingUser($_POST['against_name']);

                // handle errors
                $errors = ValidateComplaint::validate($postData, $userCheck);

                // check if there are no errors
                if (count(array_filter($errors)) == 0) {
                    // add against user id to the array
                    $postData['against_id'] = $userCheck['ID'];

                    // post complaint
                    if ($this->complaintModel->postComplaint($postData)) {
                        flashMessage('success', "Your complaint has been successfully posted!");
                        redirect('/complaints');
                    } else {
                        die('Something went wrong.');
                    }
                } else {
                    // load view with errors
                    $this->loadView('complaint_create', $data, $errors);
                }
            } else {
                $data = [
                    'pageTitle' => 'New Complaint',
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader'],
                    'complaint' => [
                        'against_name' => '',
                        'complaint_desc' => '',
                        'complaint_proof' => '',
                        'other_info' => ''
                    ],
                    'lang' => $lang,
                    'badges' => $badge,
                    'categories' => $categories
                ];

                // load view
                $this->loadView('complaint_create', $data);
            }
        } else {
            flashMessage('danger', "You must log in first to be able to create complaints.");
            redirect('/');
        }
    }

    public function edit($id = 0)
    {
        $complaint = $this->complaintModel->getComplaint($id);

        if (($id == 0) || ($complaint == false)) {
            $this->error('404', 'Page Not Found!');
        } else if (($complaint['author_id'] != $_SESSION['user_id'] && $complaint['status'] != 'Open') || (!in_array(1, $this->privileges['canEditAComplaints']))) {
            $this->error('403', 'Forbidden!');
        } else {
            global $lang;

            $complaint['description'] = html_entity_decode($complaint['description']);
            $complaint['description'] = str_replace('<br>', PHP_EOL, $complaint['description']);

            $complaint['proof'] = html_entity_decode($complaint['proof']);
            $complaint['proof'] = str_replace('<br>', PHP_EOL, $complaint['description']);

            $complaint['other_info'] = html_entity_decode($complaint['other_info']);
            $complaint['other_info'] = str_replace('<br>', PHP_EOL, $complaint['other_info']);

            $badges = $this->badges();
            $categories = $this->categoryModel->getAllCategories('complaint');

            $data = [
                'pageTitle' => 'Edit Complaint',
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'lang' => $lang,
                'badges' => $badges,
                'categories' => $categories,
                'complaint' => $complaint
            ];

            if (isset($_POST['edit_complaint'])) {
                // sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $_POST['complaint_desc'] = str_replace(PHP_EOL, '<br>', $_POST['complaint_desc']);
                $_POST['complaint_desc'] = htmlentities($_POST['complaint_desc']);

                $_POST['complaint_proof'] = str_replace(PHP_EOL, '<br>', $_POST['complaint_proof']);
                $_POST['complaint_proof'] = htmlentities($_POST['complaint_proof']);

                $_POST['other_info'] = str_replace(PHP_EOL, '<br>', $_POST['other_info']);
                $_POST['other_info'] = htmlentities($_POST['other_info']);

                $postData = [
                    'complaint_desc' => $_POST['complaint_desc'],
                    'complaint_proof' => $_POST['complaint_proof'],
                    'other_info' => $_POST['other_info'],
                    'against_name' => $_POST['against_name'],
                    'complaint_category' => $_POST['complaint_category'],
                    'is_edited' => 1,
                    'edit_ip' => getUserIp(),
                    'edited_by' => $_SESSION['user_id']
                ];

                $userCheck = $this->userModel->searchExistingUser($postData['against_name']);

                // handle errors
                $errors = ValidateComplaint::validate($postData, $userCheck);

                // check if there are no errors
                if (count(array_filter($errors)) == 0) {
                    // add against user id to the array
                    $postData['against_id'] = $userCheck['ID'];

                    if ($this->complaintModel->editComplaint($postData, $id)) {
                        flashMessage('success', 'Complaint has been successfully edited!');
                        redirect('/complaints');
                    } else {
                        die('Something went wrong.');
                    }
                } else {
                    // load view with errors
                    $this->loadView('complaint_edit', $data, $errors);
                }
            } else {
                $this->loadView('complaint_edit', $data);
            }
        }
    }

    public function view($id = 0)
    {
        global $lang;

        $badges = $this->badges();

        $complaint = $this->complaintModel->getComplaint($id);

        if ($id == 0 || $complaint == false) {
            $this->error('404', 'Page Not Found!');
        } else {
            $complaint['description'] = html_entity_decode($complaint['description']);
            $complaint['proof'] = html_entity_decode($complaint['proof']);
            $complaint['other_info'] = html_entity_decode($complaint['other_info']);

            $data = [
                'pageTitle' => 'Complaint against ' . $complaint['against_user']['NickName'],
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'lang' => $lang,
                'badges' => $badges,
                'complaint' => $complaint
            ];

            if (isset($_POST['post_reply'])) {
                // sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $_POST['complaint_reply'] = str_replace(PHP_EOL, '<br>', $_POST['complaint_reply']);
                $_POST['complaint_reply'] = htmlentities($_POST['complaint_reply']);

                if ($_SESSION['user_id'] == $complaint['author_id']) {
                    $user_status = 'Complaint Creator';
                } else if ($_SESSION['user_id'] == $complaint['against_id']) {
                    $user_status = 'Reported Player';
                }

                $postData = [
                    'complaint_id' => $complaint['id'],
                    'body' => $_POST['complaint_reply'],
                    'author_id' => $_SESSION['user_id'],
                    'author_ip' => getUserIp(),
                ];

                // handle errors
                $errors = ValidateComplaint::validateReply($postData);

                // check if there are no errors
                if (count(array_filter($errors)) == 0) {
                    $postData['user_status'] = $user_status;
                    // post reply
                    if ($this->complaintModel->postReply($postData)) {
                        flashMessage('success', "Your reply has been successfully posted!");
                        redirect('/complaints/view/' . $id);
                    } else {
                        die('Something went wrong.');
                    }
                } else {
                    // load view with errors
                    $this->loadView('complaint_view', $data, $errors);
                }
            } else {
                // load view
                $this->loadView('complaint_view', $data);
            }
        }
    }
}