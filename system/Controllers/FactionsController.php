<?php
/**
 * @brief Factions controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/Validations/ValidateComplaint.php';
require_once ROOT_PATH . '/system/Validations/ValidateFapplication.php';

class FactionsController extends Controller
{
    private $factionModel;
    private $userModel;
    private $privileges;
    use ValidateComplaint;
    use ValidateFapplication;

    public function __construct()
    {
        // store privileges
        $this->privileges = $this->checkPrivileges();

        // load models
        $this->factionModel = $this->loadModel('Faction');
        $this->userModel = $this->loadModel('User');
    }

    public function index()
    {
        global $lang;
        $badges = $this->badges();
        $factions = $this->factionModel->getFactions();

        $data = [
            'pageTitle' => 'Factions',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'lang' => $lang,
            'badges' => $badges,
            'factions' => $factions
        ];

        // load view
        $this->loadView('factions_index', $data);
    }

    public function view($id = 0)
    {
        global $lang;
        $faction = $this->factionModel->getFaction($id);
        if (!empty($faction) && is_numeric($id)) {
            $badges = $this->badges();
            $factionMembers = $this->factionModel->getFactionMembers($id);

            $data = [
                'pageTitle' => $faction['Name'],
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'lang' => $lang,
                'badges' => $badges,
                'faction' => $faction,
                'factionMembers' => $factionMembers
            ];

            // load view
            $this->loadView('faction_view', $data);
        } else {
            $this->error('404', 'Page Not Found!');
        }
    }

    public function complaints($factionId = 0, $secondParam = '', $complaintId = 0)
    {
        global $lang;
        $faction = $this->factionModel->getFaction($factionId);
        $complaint = $this->factionModel->getComplaint($complaintId);
        $badges = $this->badges();

        if (!empty($faction) && is_numeric($factionId)) {
            if (empty($secondParam) && $complaintId === 0) {
                $fComplaints = $this->factionModel->getFactionComplaints($factionId);

                $data = [
                    'pageTitle' => $faction['Name'] . ' Complaints',
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader'],
                    'lang' => $lang,
                    'badges' => $badges,
                    'faction' => $faction,
                    'complaints' => $fComplaints
                ];

                // load view
                $this->loadView('fcomplaints_index', $data);

            } else if (strcasecmp($secondParam, 'view') == 0 && !empty($complaint) && is_numeric($complaintId)) {
                $complaint['description'] = html_entity_decode($complaint['description']);
                $cReplies = $this->factionModel->getComplaintReplies($complaintId);
                $finalReplies = array();
                if (!empty($cReplies)) {
                    foreach ($cReplies as $reply) {
                        $reply['body'] = html_entity_decode($reply['body']);
                        array_push($finalReplies, $reply);
                    }
                }

                $data = [
                    'pageTitle' => $faction['Name'] . ' Complaints',
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader'],
                    'canEditFComplaints' => $complaint['category_id'] == 9 && in_array(1, $this->privileges['canEditFComplaints']),
                    'canDeleteFComplaints' => $complaint['category_id'] == 9 && in_array(1, $this->privileges['canDeleteFComplaints']),
                    'canDeleteFCReplies' => $complaint['category_id'] == 9 && in_array(1, $this->privileges['canDeleteFCReplies']),
                    'canCloseFComplaints' => $complaint['category_id'] == 9 && in_array(1, $this->privileges['canCloseFComplaints']),
                    'lang' => $lang,
                    'badges' => $badges,
                    'complaint' => $complaint,
                    'cReplies' => $finalReplies
                ];

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (($_SESSION['user_id'] == $complaint['author_id']) || ($data['isLeader'] == $complaint['faction_id']) || $data['canCloseFComplaints']) {
                        if (isset($_POST['close_complaint'])) {
                            $closeData = [
                                'status' => 'Closed',
                                'closed_by' => $_SESSION['user_id']
                            ];

                            // close complaint
                            if ($this->factionModel->closeComplaint($closeData, $complaintId)) {
                                flashMessage('success', 'Complaint has been successfully locked.');
                                redirect('/factions/complaints/' . $factionId . '/view/' . $complaintId);
                            } else {
                                die('Something went wrong.');
                            }
                        }
                    }

                    if (($data['isLeader'] == $complaint['faction_id']) || $data['canCloseFComplaints']) {
                        if (isset($_POST['open_complaint'])) {
                            $closeData = [
                                'status' => 'Open',
                                'closed_by' => 0
                            ];

                            // close complaint
                            if ($this->factionModel->closeComplaint($closeData, $complaintId)) {
                                flashMessage('success', 'Complaint has been successfully opened.');
                                redirect('/factions/complaints/' . $factionId . '/view/' . $complaintId);
                            } else {
                                die('Something went wrong.');
                            }
                        }
                    }

                    if ($data['canDeleteFComplaints']) {
                        if (isset($_POST['delete_complaint'])) {
                            // delete complaint
                            if ($this->factionModel->deleteComplaint($complaintId)) {
                                flashMessage('success', 'Complaint has been successfully deleted.');
                                redirect('/factions/complaints/' . $factionId);
                            } else {
                                die('Something went wrong.');
                            }
                        }
                    }

                    if ($data['canDeleteFCReplies']) {
                        if (isset($_POST['delete_reply'])) {
                            $reply_id = $_POST['reply_id'];
                            // delete reply
                            if ($this->factionModel->deleteReply($reply_id)) {
                                flashMessage('success', 'Reply has been successfully deleted.');
                                redirect('/factions/complaints/' . $factionId . '/view/' . $complaintId);
                            } else {
                                die('Something went wrong.');
                            }
                        }
                    }

                    if (isset($_POST['post_reply'])) {
                        // sanitize post data
                        $_POST['complaint_reply'] = htmlentities($_POST['complaint_reply']);

                        if ($_SESSION['user_id'] == $complaint['author_id']) {
                            $userStatus = 'Complaint Creator';
                        } else if ($_SESSION['user_id'] == $complaint['against_id']) {
                            $userStatus = 'Reported Player';
                        }

                        $postData = [
                            'complaint_id' => $complaint['id'],
                            'body' => $_POST['complaint_reply'],
                            'author_id' => $_SESSION['user_id'],
                            'author_ip' => getUserIp(),
                            'user_status' => $userStatus
                        ];

                        // handle errors
                        $errors = ValidateComplaint::validateReply($postData);

                        // check if there are no errors
                        if (count(array_filter($errors)) == 0) {
                            // post reply
                            if ($this->factionModel->postReply($postData)) {
                                flashMessage('success', "Your reply has been successfully posted!");
                                redirect('/factions/complaints/' . $complaint['faction_id'] . '/view/' . $complaint['id']);
                            } else {
                                die('Something went wrong.');
                            }
                        } else {
                            // load view with errors
                            $this->loadView('fcomplaint_view', $data, $errors);
                        }
                    }

                } else {
                    // load view
                    $this->loadView('fcomplaint_view', $data);
                }

            } else if (strcasecmp($secondParam, 'create') == 0 && $complaintId === 0) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // sanitize post data
                    $_POST['against_name'] = filter_var($_POST['against_name'], FILTER_SANITIZE_STRING);
                    $_POST['complaint_desc'] = htmlentities($_POST['complaint_desc']);

                    $postData = [
                        'against_name' => $_POST['against_name'],
                        'category_id' => 9,
                        'faction_id' => $factionId,
                        'complaint_desc' => $_POST['complaint_desc'],
                        'author_id' => $_SESSION['user_id'],
                        'author_ip' => getUserIp(),
                        'status' => 'Open'
                    ];

                    $data = [
                        'pageTitle' => 'Create Complaint',
                        'fullAccess' => $this->privileges['fullAccess'],
                        'isAdmin' => $this->privileges['isAdmin'],
                        'isLeader' => $this->privileges['isLeader'],
                        'lang' => $lang,
                        'badges' => $badges,
                        'complaint' => $postData
                    ];

                    $userCheck = $this->userModel->searchExistingUser($postData['against_name']);

                    // handle errors
                    $errors = ValidateComplaint::validateForFaction($postData, $userCheck, $factionId);

                    // check if there are no errors
                    if (count(array_filter($errors)) == 0) {
                        // add against user id to the array
                        $postData['against_id'] = $userCheck['ID'];

                        // post complaint
                        if ($this->factionModel->postComplaint($postData)) {
                            flashMessage('success', 'Complaint has been successfully posted.');
                            redirect('/factions/complaints/' . $factionId);
                        } else {
                            die('Something went wrong.');
                        }
                    } else {
                        // load view with errors
                        $this->loadView('fcomplaint_create', $data, $errors);
                    }

                } else {
                    $data = [
                        'pageTitle' => 'Create Complaint',
                        'fullAccess' => $this->privileges['fullAccess'],
                        'isAdmin' => $this->privileges['isAdmin'],
                        'isLeader' => $this->privileges['isLeader'],
                        'lang' => $lang,
                        'badges' => $badges,
                        'complaint' => [
                            'against_name' => '',
                            'complaint_desc' => ''
                        ]
                    ];

                    // load view
                    $this->loadView('fcomplaint_create', $data);
                }
            } else if (strcasecmp($secondParam, 'edit') == 0 && !empty($complaint) && is_numeric($complaintId)) {
                $complaint['description'] = html_entity_decode($complaint['description']);

                $data = [
                    'pageTitle' => 'Edit Complaint',
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader'],
                    'lang' => $lang,
                    'badges' => $badges,
                    'complaint' => $complaint
                ];

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // sanitize post data
                    $_POST['against_name'] = filter_var($_POST['against_name'], FILTER_SANITIZE_STRING);
                    $_POST['complaint_desc'] = htmlentities($_POST['complaint_desc']);

                    $editData = [
                        'complaint_desc' => $_POST['complaint_desc'],
                        'against_name' => $_POST['against_name'],
                        'is_edited' => 1,
                        'edit_ip' => getUserIp(),
                        'edited_by' => $_SESSION['user_id']
                    ];

                    $userCheck = $this->userModel->searchExistingUser($_POST['against_name']);

                    // handle errors
                    $errors = ValidateComplaint::validateForFaction($editData, $userCheck, $factionId);

                    // check if there are no errors
                    if (count(array_filter($errors)) == 0) {
                        // add against user id to the array
                        $editData['against_id'] = $userCheck['ID'];

                        if ($this->factionModel->editComplaint($editData, $complaintId)) {
                            flashMessage('success', 'Complaint has been successfully edited!');
                            redirect('/factions/complaints/' . $factionId . '/view/' . $complaintId);
                        } else {
                            die('Something went wrong.');
                        }
                    } else {
                        // load view with errors
                        $this->loadView('fcomplaint_edit', $data, $errors);
                    }

                } else {
                    // load view
                    $this->loadView('fcomplaint_edit', $data);
                }

            } else {
                $this->error('404', 'Page Not Found!');
            }
        } else {
            $this->error('404', 'Page Not Found!');
        }
    }

    public function applications($factionId = 0, $secondParam = '', $applicationId = 0)
    {
        global $lang;
        $badges = $this->badges();
        $faction = $this->factionModel->getFaction($factionId);
        $application = $this->factionModel->getApplication($applicationId);

        if ($factionId != 0 && !empty($faction) && is_numeric($factionId)) {
            $appsStatus = $this->factionModel->getFaction($factionId)['Apps_Status'];

            if (empty($secondParam) && $applicationId === 0) {
                $factionApps = $this->factionModel->getFactionApplications($factionId);

                $data = [
                    'pageTitle' => $faction['Name'] . ' Applications',
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader'],
                    'lang' => $lang,
                    'badges' => $badges,
                    'faction' => $faction,
                    'factionApps' => $factionApps,
                    'appsStatus' => $appsStatus
                ];

                // load view
                $this->loadView('fapplications_index', $data);

            } else if (strcasecmp($secondParam, 'create') == 0 && $applicationId === 0) {
                $userApplied = $this->factionModel->userApplied($_SESSION['user_id']);
                if ($appsStatus == 0) {
                    flashMessage('danger', 'Applications for this faction are currently closed.');
                    redirect('/factions/applications/' . $factionId);
                } else {
                    if ($userApplied) {
                        flashMessage('danger', 'You already have an opened application.');
                        redirect('/factions/applications/' . $factionId);
                    } else {
                        $questions = $this->factionModel->getFactionAppsQuestions($factionId);
                        $countQuestions = $this->factionModel->countFactionApps($factionId);

                        $data = [
                            'pageTitle' => 'Post Application',
                            'fullAccess' => $this->privileges['fullAccess'],
                            'isAdmin' => $this->privileges['isAdmin'],
                            'isLeader' => $this->privileges['isLeader'],
                            'lang' => $lang,
                            'badges' => $badges,
                            'faction' => $faction,
                            'questions' => $questions
                        ];

                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            // sanitize post data
                            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                            $_POST['questionsNumber'] = $countQuestions;

                            // handle errors
                            $errors = ValidateFapplication::validateApp($_POST);

                            $postBody = '';
                            for ($i = 1; $i <= $countQuestions; $i++) {
                                $postInput = "<p><span class='dv-first'><strong>" . $_POST['question' . $i] . ": </strong></span><span class='dv-second'>" . $_POST['answer' . $i] . "</span></p>";
                                $postBody = $postBody . $postInput;
                            }
                            $postBody = htmlentities($postBody);

                            $postData = [
                                'body' => $postBody,
                                'author_id' => $_SESSION['user_id'],
                                'faction_id' => $factionId,
                                'status' => 'Open',
                            ];

                            if (count(array_filter($errors)) == 0 && $countQuestions > 0) {
                                if ($this->factionModel->postApplication($postData)) {
                                    flashMessage('success', 'Your application has been successfully posted.');
                                    redirect('/factions/applications/' . $factionId);
                                } else {
                                    die('Something went wrong.');
                                }
                            } else {
                                $this->loadView('fapplication_create', $data, $errors);
                            }

                        } else {
                            // load view
                            $this->loadView('fapplication_create', $data);
                        }
                    }
                }

            } else if (strcasecmp($secondParam, 'view') == 0 && (!empty($application)) && is_numeric($applicationId)) {
                $application['body'] = html_entity_decode($application['body']);

                $data = [
                    'pageTitle' => 'View Application',
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader'],
                    'lang' => $lang,
                    'badges' => $badges,
                    'application' => $application
                ];

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if ($data['isLeader'] == $factionId || $data['fullAccess']) {
                        if (isset($_POST['accept_application'])) {
                            $postData = [
                                'status' => 'Accepted for tests',
                                'updated_by' => $_SESSION['user_id']
                            ];

                            if ($this->factionModel->updateAppStatus($postData, $applicationId)) {
                                flashMessage('success', 'Application has been accepted successfully.');
                                redirect('/factions/applications/' . $factionId);
                            } else {
                                die('Something went wrong.');
                            }
                        } else if (isset($_POST['reject_application'])) {
                            $postData = [
                                'status' => 'Rejected',
                                'updated_by' => $_SESSION['user_id']
                            ];

                            if ($this->factionModel->updateAppStatus($postData, $applicationId)) {
                                flashMessage('success', 'Application has been rejected successfully.');
                                redirect('/factions/applications/' . $factionId);
                            } else {
                                die('Something went wrong.');
                            }
                        }
                    }

                    if (isset($_POST['delete_application']) && $data['fullAccess']) {
                        if ($this->factionModel->deleteApplication($applicationId)) {
                            flashMessage('success', 'Application has been deleted successfully.');
                            redirect('/factions/applications/' . $factionId);
                        } else {
                            die('Something went wrong.');
                        }
                    }
                }

                // load view
                $this->loadView('fapplication_view', $data);

            } else if (strcasecmp($secondParam, 'edit') == 0 && (!empty($application)) && is_numeric($applicationId)) {

            } else if (strcasecmp($secondParam, 'questions') == 0 && $applicationId === 0 && $this->privileges['isLeader'] && $this->privileges['isLeader'] == $factionId) {
                $questions = $this->factionModel->getFactionAppsQuestions($factionId);

                $data = [
                    'pageTitle' => 'Application Questions',
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader'],
                    'lang' => $lang,
                    'badges' => $badges,
                    'questions' => $questions
                ];

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['add_question'])) {
                        // sanitize post data
                        $_POST['question_body'] = filter_var($_POST['question_body'], FILTER_SANITIZE_STRING);

                        $postData = [
                            'faction_id' => $factionId,
                            'question_body' => $_POST['question_body']
                        ];

                        // handle errors
                        $errors = ValidateFapplication::validateInput($postData);

                        // check if there are no errors
                        if (count(array_filter($errors)) == 0) {
                            // add question
                            if ($this->factionModel->addQuestion($postData)) {
                                flashMessage('success', 'Question has been successfully added.');
                                redirect('/factions/applications/' . $factionId . '/questions');
                            } else {
                                die('Something went wrong.');
                            }
                        } else {
                            // load view with errors
                            $this->loadView('fapplications_questions', $data, $errors);
                        }
                    } else if (isset($_POST['delete_question'])) {
                        // delete question
                        if ($this->factionModel->deleteQuestion($_POST['question_id'])) {
                            flashMessage('success', 'Question has been successfully deleted.');
                            redirect('/factions/applications/' . $factionId . '/questions');
                        } else {
                            die('Something went wrong.');
                        }
                    }

                } else {
                    // load view
                    $this->loadView('fapplications_questions', $data);
                }

            } else {
                $this->error('404', 'Page Not Found!');
            }
        }
    }
}