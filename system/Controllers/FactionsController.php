<?php
/**
 * @brief Factions controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/Validations/ValidateComplaint.php';
require_once ROOT_PATH . '/system/Validations/ValidateFApplication.php';
require_once ROOT_PATH . '/system/Validations/ValidateResignation.php';

class FactionsController extends Controller
{
    private $factionModel;
    private $userModel;
    private $logModel;
    use ValidateComplaint;
    use ValidateFApplication;
    use ValidateResignation;

    public function __construct()
    {
        parent::__construct();

        // load models
        $this->factionModel = $this->loadModel('Faction');
        $this->userModel = $this->loadModel('User');
        $this->logModel = $this->loadModel('Log');
    }

    public function index()
    {
        $factions = $this->factionModel->getFactions();

        $data = [
            'pageTitle' => 'Factions',
            'factions' => $factions
        ];

        // load view
        $this->loadView('factions_index', $data);
    }

    public function view($id = 0)
    {
        $faction = $this->factionModel->getFaction($id);
        if (!empty($faction) && is_numeric($id)) {
            $factionMembers = $this->factionModel->getFactionMembers($id);

            $data = [
                'pageTitle' => $faction['Name'],
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
        $faction = $this->factionModel->getFaction($factionId);

        if (!empty($faction) && is_numeric($factionId)) {
            $complaint = $this->factionModel->getComplaint($complaintId);

            if (empty($secondParam) && $complaintId === 0) {
                $fComplaints = $this->factionModel->getFactionComplaints($factionId);

                $data = [
                    'pageTitle' => $faction['Name'] . ' Complaints',
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
                    'complaint' => $complaint,
                    'cReplies' => $finalReplies
                ];

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (($_SESSION['user_id'] == $complaint['author_id']) || ($this->privileges['isLeader'] == $complaint['faction_id']) || $this->privileges['canCloseFComplaints'] && $complaint['category_id'] == 9) {
                        if (isset($_POST['close_complaint'])) {
                            $closeData = [
                                'status' => 'Closed',
                                'closed_by' => $_SESSION['user_id']
                            ];

                            // close complaint
                            if ($this->factionModel->closeComplaint($closeData, $complaintId)) {
                                $logAction = $_SESSION['user_name'] . ' closed faction complaint (ID: ' . $complaintId . ').';
                                $logData = [
                                    'type' => 'Faction Complaint',
                                    'action' => $logAction
                                ];
                                if ($_SESSION['user_id'] == $complaint['author_id']) {
                                    $this->logModel->playerLog($logData);
                                } else if ($this->privileges['isLeader'] == $complaint['faction_id']) {
                                    $this->logModel->leaderLog($logData);
                                } else {
                                    $this->logModel->adminLog($logData);
                                }
                                flashMessage('success', 'Complaint has been successfully locked.');
                                redirect('/factions/complaints/' . $factionId . '/view/' . $complaintId);
                            } else {
                                die('Something went wrong.');
                            }
                        }
                    }

                    if (($this->privileges['isLeader'] == $complaint['faction_id']) || $this->privileges['canCloseFComplaints'] && $complaint['category_id'] == 9) {
                        if (isset($_POST['open_complaint'])) {
                            $closeData = [
                                'status' => 'Open',
                                'closed_by' => 0
                            ];

                            // close complaint
                            if ($this->factionModel->closeComplaint($closeData, $complaintId)) {
                                $logAction = $_SESSION['user_name'] . ' opened faction complaint (ID: ' . $complaintId . ').';
                                $logData = [
                                    'type' => 'Faction Complaint',
                                    'action' => $logAction
                                ];
                                if ($this->privileges['isLeader'] == $complaint['faction_id']) {
                                    $this->logModel->leaderLog($logData);
                                } else {
                                    $this->logModel->adminLog($logData);
                                }
                                flashMessage('success', 'Complaint has been successfully opened.');
                                redirect('/factions/complaints/' . $factionId . '/view/' . $complaintId);
                            } else {
                                die('Something went wrong.');
                            }
                        }
                    }

                    if ($this->privileges['canDeleteFComplaints'] && $complaint['category_id'] == 9) {
                        if (isset($_POST['delete_complaint'])) {
                            // delete complaint
                            if ($this->factionModel->deleteComplaint($complaintId)) {
                                $logAction = $_SESSION['user_name'] . ' deleted faction complaint (ID: ' . $complaintId . ').';
                                $logData = [
                                    'type' => 'Faction Complaint',
                                    'action' => $logAction
                                ];
                                $this->logModel->adminLog($logData);
                                flashMessage('success', 'Complaint has been successfully deleted.');
                                redirect('/factions/complaints/' . $factionId);
                            } else {
                                die('Something went wrong.');
                            }
                        }
                    }

                    if ($this->privileges['canDeleteFCReplies'] && $complaint['category_id'] == 9) {
                        if (isset($_POST['delete_reply'])) {
                            $reply_id = $_POST['reply_id'];
                            // delete reply
                            if ($this->factionModel->deleteReply($reply_id)) {
                                $logAction = $_SESSION['user_name'] . ' deleted reply #' . $reply_id . ' from faction complaint (ID: ' . $complaintId . ').';
                                $logData = [
                                    'type' => 'Faction Complaint',
                                    'action' => $logAction
                                ];
                                $this->logModel->adminlog($logData);
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
                        'complaint' => [
                            'against_name' => '',
                            'complaint_desc' => ''
                        ]
                    ];

                    // load view
                    $this->loadView('fcomplaint_create', $data);
                }
            } else if (strcasecmp($secondParam, 'edit') == 0 && !empty($complaint) && is_numeric($complaintId)) {
                if ($_SESSION['user_id'] == $complaint['author_id'] || $this->privileges['canEditFComplaints'] && $complaint['category_id'] == 9) {
                    $complaint['description'] = html_entity_decode($complaint['description']);

                    $data = [
                        'pageTitle' => 'Edit Complaint',
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
                                $logAction = $_SESSION['user_name'] . ' edited faction complaint (ID: ' . $complaintId . ').';
                                $logData = [
                                    'type' => 'Faction Complaint',
                                    'action' => $logAction
                                ];
                                if ($_SESSION['user_id'] == $complaint['author_id']) {
                                    $this->logModel->playerLog($logData);
                                } else {
                                    $this->logModel->adminLog($logData);
                                }
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
                    $this->error('403', 'Forbidden!');
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
        $faction = $this->factionModel->getFaction($factionId);
        if (isLoggedIn()) {
            $userFaction = $this->factionModel->getUser($_SESSION['user_id'])['Member'];
        }

        if ($factionId != 0 && !empty($faction) && is_numeric($factionId)) {
            $application = $this->factionModel->getApplication($applicationId);
            $appsStatus = $this->factionModel->getFaction($factionId)['Apps_Status'];

            if (empty($secondParam) && $applicationId === 0) {
                $factionApps = $this->factionModel->getFactionApplications($factionId);

                $data = [
                    'pageTitle' => $faction['Name'] . ' Applications',
                    'faction' => $faction,
                    'factionApps' => $factionApps,
                    'appsStatus' => $appsStatus
                ];

                // load view
                $this->loadView('fapplications_index', $data);

            } else if (strcasecmp($secondParam, 'create') == 0 && $applicationId === 0 && $userFaction == 0) {
                $userApplied = $this->factionModel->userApplied($_SESSION['user_id']);
                if ($appsStatus == 0) {
                    flashMessage('danger', 'Applications for this faction are currently closed.');
                    redirect('/factions/applications/' . $factionId);
                } else {
                    if ($userApplied) {
                        flashMessage('danger', 'You have already an opened application.');
                        redirect('/factions/applications/' . $factionId);
                    } else {
                        $questions = $this->factionModel->getFactionAppsQuestions($factionId);
                        $countQuestions = $this->factionModel->countFactionApps($factionId);

                        $data = [
                            'pageTitle' => 'Post Application',
                            'faction' => $faction,
                            'questions' => $questions
                        ];

                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            // sanitize post data
                            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                            $_POST['questionsNumber'] = $countQuestions;

                            // handle errors
                            $errors = ValidateFApplication::validateApp($_POST);

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
                    'application' => $application
                ];

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if ($this->privileges['isLeader'] == $factionId || $this->privileges['fullAccess']) {
                        if (isset($_POST['accept_application'])) {
                            $postData = [
                                'status' => 'Accepted for tests',
                                'updated_by' => $_SESSION['user_id']
                            ];

                            if ($this->factionModel->updateAppStatus($postData, $applicationId)) {
                                $logAction = $_SESSION['user_name'] . ' accepted faction application (ID: ' . $applicationId . ').';
                                $logData = [
                                    'type' => 'Faction Application',
                                    'action' => $logAction
                                ];
                                if ($this->privileges['isLeader'] == $factionId) {
                                    $this->logModel->leaderLog($logData);
                                } else {
                                    $this->logModel->adminLog($logData);
                                }
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
                                $logAction = $_SESSION['user_name'] . ' rejected faction application (ID: ' . $applicationId . ').';
                                $logData = [
                                    'type' => 'Faction Application',
                                    'action' => $logAction
                                ];
                                if ($this->privileges['isLeader'] == $factionId) {
                                    $this->logModel->leaderLog($logData);
                                } else {
                                    $this->logModel->adminLog($logData);
                                }
                                flashMessage('success', 'Application has been rejected successfully.');
                                redirect('/factions/applications/' . $factionId);
                            } else {
                                die('Something went wrong.');
                            }
                        }
                    }

                    if (isset($_POST['delete_application']) && $data['fullAccess']) {
                        if ($this->factionModel->deleteApplication($applicationId)) {
                            $logAction = $_SESSION['user_id'] . ' deleted faction application (ID: ' . $applicationId . ').';
                            $logData = [
                                'type' => 'Faction Application',
                                'action' => $logAction
                            ];
                            $this->logModel->adminLog($logData);
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

            } else if (strcasecmp($secondParam, 'questions') == 0 && $applicationId === 0 && $this->privileges['isLeader'] == $factionId) {
                $questions = $this->factionModel->getFactionAppsQuestions($factionId);

                $data = [
                    'pageTitle' => 'Application Questions',
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
                        $errors = ValidateFApplication::validateInput($postData);

                        // check if there are no errors
                        if (count(array_filter($errors)) == 0) {
                            // add question
                            if ($this->factionModel->addQuestion($postData)) {
                                $logAction = $_SESSION['user_name'] . ' added new application question for faction ' . $factionId . '. (Q: ' . $postData['question_body'] . ')';
                                $logData = [
                                    'type' => 'Faction Application',
                                    'action' => $logAction
                                ];
                                $this->logModel->leaderLog($logData);
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
                            $logAction = $_SESSION['user_name'] . ' deleted a question for faction applications.';
                            $logData = [
                                'type' => 'Faction Application',
                                'action' => $logAction
                            ];
                            $this->logModel->leaderLog($logData);
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

    public function resignations($factionId = 0, $secondParam = '', $resignationId = 0)
    {
        $faction = $this->factionModel->getFaction($factionId);
        if (isLoggedIn()) {
            $isFactionMember = $this->factionModel->getUser($_SESSION['user_id'])['Member'] == $factionId ? 1 : 0;
        }

        if ($factionId != 0 && !empty($faction) && is_numeric($factionId) && isLoggedIn() && ($isFactionMember || $this->privileges['fullAccess'])) {
            $resignation = $this->factionModel->getResignation($resignationId);

            if (empty($secondParam) && $resignationId === 0) {
                $resignations = $this->factionModel->getResignations($factionId);

                $data = [
                    'pageTitle' => 'Resignations',
                    'faction' => $faction,
                    'resignations' => $resignations,
                    'isFactionMember' => $isFactionMember
                ];

                // load view
                $this->loadView('resignations_index', $data);

            } else if (strcasecmp($secondParam, 'create') == 0 && $resignationId === 0) {
                $userPostedResignation = $this->factionModel->userPostedResignation($_SESSION['user_id']);

                if ($userPostedResignation) {
                    flashMessage('danger', 'You have already an opened resignation.');
                    redirect('/factions/resignations/' . $factionId);
                } else {
                    $data = [
                        'pageTitle' => 'Post Resignation'
                    ];

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['post_resignation'])) {
                            // sanitize post data
                            $_POST['resignation_body'] = htmlentities($_POST['resignation_body']);

                            $postData = [
                                'body' => $_POST['resignation_body'],
                                'author_id' => $_SESSION['user_id'],
                                'author_ip' => getUserIp(),
                                'faction_id' => $factionId,
                                'status' => 'Open'
                            ];

                            // handle errors
                            $errors = ValidateResignation::validatePost($postData);

                            if (count(array_filter($errors)) == 0) {
                                if ($this->factionModel->postResignation($postData)) {
                                    flashMessage('success', 'Resignation has been successfully posted.');
                                    redirect('/factions/resignations/' . $factionId);
                                } else {
                                    die('Something went wrong.');
                                }
                            } else {
                                // load view with errors
                                $this->loadView('resignation_create', $data, $errors);
                            }
                        }
                    } else {
                        // load view
                        $this->loadView('resignation_create', $data);
                    }
                }

            } else if (strcasecmp($secondParam, 'view') == 0 && is_numeric($resignationId) && !empty($resignation)) {
                $userBanned = $this->factionModel->userBanned($resignation['author']['NickName']);
                $resignation['body'] = html_entity_decode($resignation['body']);
                $replies = $this->factionModel->getResignationReplies($resignationId);
                $finalReplies = array();
                foreach ($replies as $reply) {
                    $reply['body'] = html_entity_decode($reply['body']);
                    array_push($finalReplies, $reply);
                }

                $data = [
                    'pageTitle' => 'View Resignation',
                    'resignation' => $resignation,
                    'userBanned' => $userBanned,
                    'replies' => $finalReplies
                ];

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['post_reply'])) {
                        // sanitize post data
                        $_POST['resignation_reply'] = htmlentities($_POST['resignation_reply']);
                        if ($_SESSION['user_id'] == $resignation['author_id']) {
                            $userStatus = 'Resignation Creator';
                        } else {
                            $userStatus = 'Player';
                        }

                        $postData = [
                            'resignation_id' => $resignationId,
                            'author_id' => $_SESSION['user_id'],
                            'body' => $_POST['resignation_reply'],
                            'user_status' => $userStatus
                        ];

                        // handle errors
                        $errors = ValidateResignation::validatePostReply($postData);

                        if (count(array_filter($errors)) == 0) {
                            // post reply
                            if ($this->factionModel->postResignationReply($postData)) {
                                flashMessage('success', 'Reply has been successfully posted.');
                                redirect('/factions/resignations/' . $factionId . '/view/' . $resignationId);
                            } else {
                                die('Something went wrong.');
                            }
                        } else {
                            $this->loadView('resignation_view', $data, $errors);
                        }
                    }

                    if ($_SESSION['user_id'] == $resignation['author_id'] || $this->privileges['isLeader'] == $factionId || $this->privileges['fullAccess']) {
                        if (isset($_POST['close_resignation'])) {
                            $closeData = [
                                'status' => 'Closed',
                                'closed_by' => $_SESSION['user_id']
                            ];

                            if ($this->factionModel->updateResignationStatus($closeData, $resignationId)) {
                                $logAction = $_SESSION['user_name'] . ' closed faction resignation (ID: ' . $resignationId . ').';
                                $logData = [
                                    'type' => 'Faction Resignation',
                                    'action' => $logAction
                                ];
                                if ($this->privileges['isLeader'] == $factionId) {
                                    $this->logModel->leaderLog($logData);
                                } else {
                                    $this->logModel->adminLog($logData);
                                }
                                flashMessage('success', 'Resignation has been successfully closed.');
                                redirect('/factions/resignations/' . $factionId . '/view/' . $resignationId);
                            } else {
                                die('Something went wrong.');
                            }
                        }
                    }

                    if ($this->privileges['fullAccess']) {
                        if (isset($_POST['delete_reply'])) {
                            $replyId = filter_var($_POST['reply_id'], FILTER_SANITIZE_NUMBER_INT);
                            if ($this->factionModel->deleteResignationReply($replyId)) {
                                $logAction = $_SESSION['user_name'] . ' deleted reply #' . $replyId . ' from faction resignation (ID: ' . $resignationId . ').';
                                $logData = [
                                    'type' => 'Faction Resignation',
                                    'action' => $logAction
                                ];
                                $this->logModel->adminLog($logData);
                                flashMessage('success', 'Reply has been deleted successfully.');
                                redirect('/factions/resignations/' . $factionId . '/view/' . $resignationId);
                            } else {
                                die('Something went wrong.');
                            }
                        }
                    }
                } else {
                    // load view
                    $this->loadView('resignation_view', $data);
                }

            } else if (strcasecmp($secondParam, 'edit') == 0 && is_numeric($resignationId) && !empty($resignation)) {

            } else {
                $this->error('404', 'Page Not Found!');
            }
        } else {
            $this->error('404', 'Page Not Found!');
        }
    }
}