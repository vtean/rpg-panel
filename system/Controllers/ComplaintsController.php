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

        if ($this->privileges['fullAccess'] == 1) {
            $complaints = $this->complaintModel->getAllComplaints();
        } else {
            $complaints = $this->complaintModel->getUnhiddenComplaints();
        }

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
        } else if (($complaint['author_id'] != $_SESSION['user_id'] && $complaint['status'] != 'Open' && $this->privileges['isAdmin'] < 1 && !in_array(1, $this->privileges['canEditAComplaints'])) || (($this->privileges['isAdmin'] > 0) && !in_array(1, $this->privileges['canEditAComplaints']))) {
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
                        redirect('/complaints/view/' . $id);
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

        if ($id == 0 || $complaint == false || ($complaint['is_hidden'] == 1) && ($this->privileges['fullAccess'] == 0)) {
            $this->error('404', 'Page Not Found!');
        } else {
            $complaint['description'] = html_entity_decode($complaint['description']);
            $complaint['proof'] = html_entity_decode($complaint['proof']);
            $complaint['other_info'] = html_entity_decode($complaint['other_info']);
            $categories = $this->categoryModel->getAllCategories('complaint');

            $data = [
                'pageTitle' => 'Complaint against ' . $complaint['against_user']['NickName'],
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'canEditAComplaints' => $complaint['category_id'] == 5 && in_array(1, $this->privileges['canEditAComplaints']),
                'canDeleteAComplaints' => $complaint['category_id'] == 5 && in_array(1, $this->privileges['canDeleteAComplaints']),
                'canDeleteACReplies' => $complaint['category_id'] == 5 && in_array(1, $this->privileges['canDeleteACReplies']),
                'canCloseAComplaints' => $complaint['category_id'] == 5 && in_array(1, $this->privileges['canCloseAComplaints']),
                'canHideAComplaints' => $complaint['category_id'] == 5 && in_array(1, $this->privileges['canHideAComplaints']),
                'canEditHComplaints' => $complaint['category_id'] == 6 && in_array(1, $this->privileges['canEditHComplaints']),
                'canDeleteHComplaints' => $complaint['category_id'] == 6 && in_array(1, $this->privileges['canDeleteHComplaints']),
                'canDeleteHCReplies' => $complaint['category_id'] == 6 && in_array(1, $this->privileges['canDeleteHCReplies']),
                'canCloseHComplaints' => $complaint['category_id'] == 6 && in_array(1, $this->privileges['canCloseHComplaints']),
                'canHideHComplaints' => $complaint['category_id'] == 6 && in_array(1, $this->privileges['canHideHComplaints']),
                'canEditLComplaints' => $complaint['category_id'] == 7 && in_array(1, $this->privileges['canEditLComplaints']),
                'canDeleteLComplaints' => $complaint['category_id'] == 7 && in_array(1, $this->privileges['canDeleteLComplaints']),
                'canDeleteLCReplies' => $complaint['category_id'] == 7 && in_array(1, $this->privileges['canDeleteLCReplies']),
                'canCloseLComplaints' => $complaint['category_id'] == 7 && in_array(1, $this->privileges['canCloseLComplaints']),
                'canHideLComplaints' => $complaint['category_id'] == 7 && in_array(1, $this->privileges['canHideLComplaints']),
                'canEditUComplaints' => $complaint['category_id'] == 8 && in_array(1, $this->privileges['canEditUComplaints']),
                'canDeleteUComplaints' => $complaint['category_id'] == 8 && in_array(1, $this->privileges['canDeleteUComplaints']),
                'canDeleteUCReplies' => $complaint['category_id'] == 8 && in_array(1, $this->privileges['canDeleteUCReplies']),
                'canCloseUComplaints' => $complaint['category_id'] == 8 && in_array(1, $this->privileges['canCloseUComplaints']),
                'canHideUComplaints' => $complaint['category_id'] == 8 && in_array(1, $this->privileges['canHideUComplaints']),
                'lang' => $lang,
                'badges' => $badges,
                'complaint' => $complaint,
                'categories' => $categories
            ];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($data['canCloseAComplaints'] || $data['canCloseHComplaints'] || $data['canCloseLComplaints'] || $data['canCloseUComplaints'] || ($_SESSION['user_id'] == $complaint['author_id'])) {
                    if (isset($_POST['close_complaint'])) {
                        $closeData = [
                            'status' => 'Closed',
                            'closed_by' => $_SESSION['user_id']
                        ];

                        // close complaint
                        if ($this->complaintModel->closeComplaint($closeData, $id)) {
                            flashMessage('success', 'Complaint has been successfully locked.');
                            redirect('/complaints/view/' . $id);
                        } else {
                            die('Something went wrong.');
                        }
                    }
                }

                if ($data['canCloseAComplaints'] || $data['canCloseHComplaints'] || $data['canCloseLComplaints'] || $data['canCloseUComplaints']) {
                    if (isset($_POST['open_complaint'])) {
                        $closeData = [
                            'status' => 'Open',
                            'closed_by' => 0
                        ];

                        // open complaint
                        if ($this->complaintModel->closeComplaint($closeData, $id)) {
                            flashMessage('success', 'Complaint has been successfully unlocked.');
                            redirect('/complaints/view/' . $id);
                        } else {
                            die('Something went wrong.');
                        }
                    }

                    if (isset($_POST['change_category'])) {
                        // filter post
                        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                        $cID = $_POST['new_category_id'];
                        // change category
                        if ($this->complaintModel->changeCategory($cID, $id)) {
                            flashMessage('success', 'Complaint category has been successfully changed.');
                            redirect('/complaints/view/' . $id);
                        } else {
                            die('Something went wrong');
                        }
                    }
                }

                if ($data['canDeleteAComplaints'] || $data['canDeleteHComplaints'] || $data['canDeleteLComplaints'] || $data['canDeleteUComplaints']) {
                    if (isset($_POST['delete_complaint'])) {
                        // delete complaint
                        if ($this->complaintModel->deleteComplaint($id)) {
                            flashMessage('success', 'Complaint has been successfully deleted.');
                            redirect('/complaints');
                        } else {
                            die('Something went wrong.');
                        }
                    }
                }

                if ($data['canHideAComplaints'] || $data['canHideHComplaints'] || $data['canHideLComplaints'] || $data['canHideUComplaints']) {
                    if (isset($_POST['hide_complaint'])) {
                        $isHidden = 1;
                        // hide complaint
                        if ($this->complaintModel->hideComplaint($isHidden, $id)) {
                            flashMessage('success', 'Complaint has been successfully hidden.');
                            redirect('/complaints/view/' . $id);
                        } else {
                            die('Something went wrong.');
                        }
                    }

                    if (isset($_POST['unhide_complaint'])) {
                        $isHidden = 0;
                        // hide complaint
                        if ($this->complaintModel->hideComplaint($isHidden, $id)) {
                            flashMessage('success', 'Complaint has been successfully unhidden.');
                            redirect('/complaints/view/' . $id);
                        } else {
                            die('Something went wrong.');
                        }
                    }
                }

                if ($data['canDeleteACReplies'] || $data['canDeleteHCReplies'] || $data['canDeleteLCReplies'] || $data['canDeleteUCReplies']) {
                    if (isset($_POST['delete_reply'])) {
                        // filter post
                        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                        $reply_id = $_POST['reply_id'];
                        if ($this->complaintModel->deleteReply($reply_id)) {
                            flashMessage('success', 'Reply has been successfully deleted.');
                            redirect('/complaints/view/' . $id);
                        } else {
                            die('Something went wrong.');
                        }
                    }
                }

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
                }
            } else {
                // load view
                $this->loadView('complaint_view', $data);
            }
        }
    }
}