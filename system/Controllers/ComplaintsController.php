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
    private $logModel;

    public function __construct()
    {
        parent::__construct();

        // load models
        $this->complaintModel = $this->loadModel('Complaint');
        $this->categoryModel = $this->loadModel('Category');
        $this->userModel = $this->loadModel('User');
        $this->logModel = $this->loadModel('Log');
    }

    public function index()
    {
        if ($this->privileges['fullAccess'] == 1) {
            $complaints = $this->complaintModel->getAllComplaints();
        } else {
            $complaints = $this->complaintModel->getUnhiddenComplaints();
        }

        $data = [
            'pageTitle' => 'Complaints',
            'complaints' => $complaints
        ];

        // load view
        $this->loadView('complaints_index', $data);
    }

    public function create()
    {
        if (isLoggedIn()) {
            $categories = $this->categoryModel->getAllCategories('complaint');

            if (isset($_POST['create_complaint'])) {
                // sanitize post data
                $_POST['against_name'] = filter_var($_POST['against_name'], FILTER_SANITIZE_STRING);
                $_POST['complaint_category'] = filter_var($_POST['complaint_category'], FILTER_SANITIZE_NUMBER_INT);
                $_POST['complaint_desc'] = htmlentities($_POST['complaint_desc']);

                $postData = [
                    'against_name' => $_POST['against_name'],
                    'complaint_category' => $_POST['complaint_category'],
                    'complaint_desc' => $_POST['complaint_desc'],
                    'author_id' => $_SESSION['user_id'],
                    'author_ip' => getUserIp(),
                    'status' => 'Open',
                    'is_hidden' => 0
                ];

                $data = [
                    'pageTitle' => 'New Complaint',
                    'complaint' => $postData,
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
                    'complaint' => [
                        'against_name' => '',
                        'complaint_desc' => '',
                    ],
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
        } else if (($complaint['author_id'] != $_SESSION['user_id'] && $complaint['status'] != 'Open' && $this->privileges['isAdmin'] < 1 && !$this->privileges['canEditAComplaints']) || (($this->privileges['isAdmin'] > 0) && !$this->privileges['canEditAComplaints'])) {
            $this->error('403', 'Forbidden!');
        } else {
            $complaint['description'] = html_entity_decode($complaint['description']);
            $categories = $this->categoryModel->getAllCategories('complaint');

            $data = [
                'pageTitle' => 'Edit Complaint',
                'categories' => $categories,
                'complaint' => $complaint
            ];

            if (isset($_POST['edit_complaint'])) {
                // sanitize post data
                $_POST['against_name'] = filter_var($_POST['against_name'], FILTER_SANITIZE_STRING);
                $_POST['complaint_category'] = filter_var($_POST['complaint_category'], FILTER_SANITIZE_NUMBER_INT);
                $_POST['complaint_desc'] = htmlentities($_POST['complaint_desc']);

                $postData = [
                    'complaint_desc' => $_POST['complaint_desc'],
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
                        $logAction = $_SESSION['user_name'] . ' edited complaint (ID: ' . $id . ').';
                        $logData = [
                            'type' => 'Complaint',
                            'action' => $logAction
                        ];
                        if ($complaint['author_id'] == $_SESSION['user_id']) {
                            $this->logModel->playerLog($logData);
                        } else {
                            $this->logModel->adminLog($logData);
                        }
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
        $complaint = $this->complaintModel->getComplaint($id);

        if ($id == 0 || $complaint == false || ($complaint['is_hidden'] == 1) && ($this->privileges['fullAccess'] == 0)) {
            $this->error('404', 'Page Not Found!');
        } else {
            $complaint['description'] = html_entity_decode($complaint['description']);
            $categories = $this->categoryModel->getAllCategories('complaint');

            $cReplies = $this->complaintModel->getComplaintReplies($id);
            $finalReplies = array();
            if (!empty($cReplies)) {
                foreach ($cReplies as $reply) {
                    $reply['body'] = html_entity_decode($reply['body']);
                    array_push($finalReplies, $reply);
                }
            }

            $data = [
                'pageTitle' => 'Complaint against ' . $complaint['against_user']['NickName'],
                'complaint' => $complaint,
                'categories' => $categories,
                'cReplies' => $finalReplies
            ];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ((isLoggedIn() && $_SESSION['user_id'] == $data['complaint']['author_id']) || $this->privileges['canCloseAComplaints'] && $complaint['category_id'] == 5 || $this->privileges['canCloseHComplaints'] && $complaint['category_id'] == 6 || $this->privileges['canCloseLComplaints'] && $complaint['category_id'] == 7 || $this->privileges['canCloseUComplaints'] && $complaint['category_id'] == 8) {
                    if (isset($_POST['close_complaint'])) {
                        $closeData = [
                            'status' => 'Closed',
                            'closed_by' => $_SESSION['user_id']
                        ];

                        // close complaint
                        if ($this->complaintModel->closeComplaint($closeData, $id)) {
                            $logAction = $_SESSION['user_name'] . ' closed complaint (ID: ' . $id . ').';
                            $logData = [
                                'type' => 'Complaint',
                                'action' => $logAction
                            ];
                            if ($_SESSION['user_id'] == $data['complaint']['author_id']) {
                                $this->logModel->playerLog($logData);
                            } else {
                                $this->logModel->adminlog($logData);
                            }
                            flashMessage('success', 'Complaint has been successfully locked.');
                            redirect('/complaints/view/' . $id);
                        } else {
                            die('Something went wrong.');
                        }
                    }
                }

                if ($this->privileges['canCloseAComplaints'] && $complaint['category_id'] == 5 || $this->privileges['canCloseHComplaints'] && $complaint['category_id'] == 6 || $this->privileges['canCloseLComplaints'] && $complaint['category_id'] == 7 || $this->privileges['canCloseUComplaints'] && $complaint['category_id'] == 8) {
                    if (isset($_POST['open_complaint'])) {
                        $closeData = [
                            'status' => 'Open',
                            'closed_by' => 0
                        ];

                        // open complaint
                        if ($this->complaintModel->closeComplaint($closeData, $id)) {
                            $logAction = $_SESSION['user_name'] . ' opened complaint (ID: ' . $id . ').';
                            $logData = [
                                'type' => 'Complaint',
                                'action' => $logAction
                            ];
                            $this->logModel->adminlog($logData);
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
                            $logAction = $_SESSION['user_name'] . ' changed category for complaint (ID: ' . $id . ') to ' . $cID . '.';
                            $logData = [
                                'type' => 'Complaint',
                                'action' => $logAction
                            ];
                            $this->logModel->adminLog($logData);
                            flashMessage('success', 'Complaint category has been successfully changed.');
                            redirect('/complaints/view/' . $id);
                        } else {
                            die('Something went wrong');
                        }
                    }
                }

                if ($this->privileges['canDeleteAComplaints'] && $complaint['category_id'] == 5 || $this->privileges['canDeleteHComplaints'] && $complaint['category_id'] == 6 || $this->privileges['canDeleteLComplaints'] && $complaint['category_id'] == 7 || $this->privileges['canDeleteUComplaints'] && $complaint['category_id'] == 8) {
                    if (isset($_POST['delete_complaint'])) {
                        // delete complaint
                        if ($this->complaintModel->deleteComplaint($id)) {
                            $logAction = $_SESSION['user_name'] . ' deleted complaint (ID: ' . $id . ').';
                            $logData = [
                                'type' => 'Complaint',
                                'action' => $logAction
                            ];
                            $this->logModel->adminLog($logData);
                            flashMessage('success', 'Complaint has been successfully deleted.');
                            redirect('/complaints');
                        } else {
                            die('Something went wrong.');
                        }
                    }
                }

                if ($this->privileges['canHideAComplaints'] && $complaint['category_id'] == 5 || $this->privileges['canHideHComplaints'] && $complaint['category_id'] == 6 || $this->privileges['canHideLComplaints'] && $complaint['category_id'] == 7 || $this->privileges['canHideUComplaints'] && $complaint['category_id'] == 8) {
                    if (isset($_POST['hide_complaint'])) {
                        $isHidden = 1;
                        // hide complaint
                        if ($this->complaintModel->hideComplaint($isHidden, $id)) {
                            $logAction = $_SESSION['user_name'] . ' hid complaint (ID: ' . $id . ').';
                            $logData = [
                                'type' => 'Complaint',
                                'action' => $logAction
                            ];
                            $this->logModel->adminLog($logData);
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
                            $logAction = $_SESSION['user_name'] . ' made complaint (ID: ' . $id . ') visible.';
                            $logData = [
                                'type' => 'Complaint',
                                'action' => $logAction
                            ];
                            $this->logModel->adminLog($logData);
                            flashMessage('success', 'Complaint has been successfully unhidden.');
                            redirect('/complaints/view/' . $id);
                        } else {
                            die('Something went wrong.');
                        }
                    }
                }

                if ($this->privileges['canDeleteACReplies'] && $complaint['category_id'] == 5 || $this->privileges['canDeleteHCReplies'] && $complaint['category_id'] == 6 || $this->privileges['canDeleteLCReplies'] && $complaint['category_id'] == 7 || $this->privileges['canDeleteUCReplies'] && $complaint['category_id'] == 8) {
                    if (isset($_POST['delete_reply'])) {
                        // filter post
                        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                        $reply_id = $_POST['reply_id'];
                        if ($this->complaintModel->deleteReply($reply_id)) {
                            $logAction = $_SESSION['user_name'] . ' deleted reply #' . $reply_id . ' from complaint (ID: ' . $id . ').';
                            $logData = [
                                'type' => 'Reply',
                                'action' => $logAction
                            ];
                            $this->logModel->adminLog($logData);
                            flashMessage('success', 'Reply has been successfully deleted.');
                            redirect('/complaints/view/' . $id);
                        } else {
                            die('Something went wrong.');
                        }
                    }
                }

                if (isset($_POST['post_reply'])) {
                    // sanitize post data
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