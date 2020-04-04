<?php
/**
 * @brief Unbans controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/Validations/ValidateUnban.php';

class UnbansController extends Controller
{
    private $unbanModel;
    private $privileges;
    use ValidateUnban;

    public function __construct()
    {
        // load unban model
        $this->unbanModel = $this->loadModel('Unban');

        // store privileges
        $this->privileges = $this->checkPrivileges();

        if (!isLoggedIn()) {
            flashMessage('danger', 'Log in to be able to view or post unban requests.');
            redirect('/');
        }
    }

    public function index()
    {
        global $lang;

        $badges = $this->badges();

        if (in_array(1, $this->privileges['canViewUnbans'])) {
            $unbanRequests = $this->unbanModel->getAllUnbanRequests();
        } else {
            $unbanRequests = $this->unbanModel->getUserUnbanRequests($_SESSION['user_id']);
        }

        $data = [
            'pageTitle' => 'Unban Requests',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'canViewUnbans' => in_array(1, $this->privileges['canViewUnbans']),
            'canEditUnbans' => in_array(1, $this->privileges['canEditUnbans']),
            'canCloseUnbans' => in_array(1, $this->privileges['canCloseUnbans']),
            'canDeleteUnbans' => in_array(1, $this->privileges['canDeleteUnbans']),
            'lang' => $lang,
            'badges' => $badges,
            'unbans' => $unbanRequests
        ];

        // load view
        $this->loadView('unbans_index', $data);
    }

    public function create()
    {
        global $lang;

        $badges = $this->badges();
        $bannedUser = $this->unbanModel->getBannedUser($_SESSION['user_id']);
        $hasOpenRequest = $this->unbanModel->hasOpenUnbanRequest($_SESSION['user_id']);

        $data = [
            'pageTitle' => 'Unban Request',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'canViewUnbans' => in_array(1, $this->privileges['canViewUnbans']),
            'canEditUnbans' => in_array(1, $this->privileges['canEditUnbans']),
            'canCloseUnbans' => in_array(1, $this->privileges['canCloseUnbans']),
            'canDeleteUnbans' => in_array(1, $this->privileges['canDeleteUnbans']),
            'lang' => $lang,
            'badges' => $badges,
            'bannedUser' => $bannedUser
        ];

        if ($bannedUser == false) {
            flashMessage('danger', 'You are not banned!');
            redirect('/');
        } else if ($hasOpenRequest == true) {
            flashMessage('danger', 'You already have an opened unban request. Wait for an admin reply.');
            redirect('/unbans');
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // sanitize post data
                $_POST['unban_comment'] = htmlentities($_POST['unban_comment']);

                $postData = [
                    'description' => $_POST['unban_comment'],
                    'author_id' => $_SESSION['user_id'],
                    'author_ip' => getUserIp(),
                    'banned_by' => $bannedUser['BanAdmin'],
                    'ban_reason' => $bannedUser['BanReason'],
                    'ban_time' => $bannedUser['BanSeconds'],
                    'status' => 'Open'
                ];

                // handle errors
                $errors = ValidateUnban::validate($postData);

                // check if there are no errors
                if (count(array_filter($errors)) == 0) {
                    // post unban request
                    if ($this->unbanModel->postUnbanRequest($postData)) {
                        flashMessage('success', 'Your request has been successfully posted.');
                        redirect('/unbans');
                    } else {
                        die('Something went wrong.');
                    }
                } else {
                    // load view with errors
                    $this->loadView('unban_create', $data, $errors);
                }
            } else {
                // load view
                $this->loadView('unban_create', $data);
            }
        }
    }

    public function view($id = 0)
    {
        global $lang;

        $unbanRequest = $this->unbanModel->getUnban($id);

        if ($id == 0 || empty($unbanRequest)) {
            $this->error('404', 'Topic not found!');
        } else if (($_SESSION['user_id'] == $unbanRequest['author_id']) || ($_SESSION['user_id'] == $unbanRequest['banned_by']) || in_array(1, $this->privileges['canViewUnbans'])) {
            $badges = $this->badges();
            $uReplies = $this->unbanModel->getUnbanReplies($id);
            $finalReplies = array();

            if (!empty($uReplies)) {
                foreach ($uReplies as $reply) {
                    $reply['body'] = html_entity_decode($reply['body']);
                    array_push($finalReplies, $reply);
                }
            }

            $unbanRequest['description'] = html_entity_decode($unbanRequest['description']);

            $data = [
                'pageTitle' => 'Unban Request from ' . $unbanRequest['author_name'],
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'canViewUnbans' => in_array(1, $this->privileges['canViewUnbans']),
                'canEditUnbans' => in_array(1, $this->privileges['canEditUnbans']),
                'canCloseUnbans' => in_array(1, $this->privileges['canCloseUnbans']),
                'canDeleteUnbans' => in_array(1, $this->privileges['canDeleteUnbans']),
                'lang' => $lang,
                'badges' => $badges,
                'unban' => $unbanRequest,
                'uReplies' => $finalReplies
            ];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ((isLoggedIn() && $_SESSION['user_id'] == $data['unban']['author_id']) || $data['canCloseUnbans']) {
                    if (isset($_POST['close_unban'])) {
                        $status = 'Closed';
                        $closedBy = $_SESSION['user_id'];

                        if ($this->unbanModel->updateStatus($id, $status, $closedBy)) {
                            flashMessage('success', 'Unban request has been successfully closed.');
                            redirect('/unbans/view/' . $id);
                        } else {
                            die('Something went wrong.');
                        }
                    }
                }

                if ($data['canCloseUnbans'] && isset($_POST['open_unban'])) {
                    $status = 'Open';

                    if ($this->unbanModel->updateStatus($id, $status)) {
                        flashMessage('success', 'Unban request has been successfully opened.');
                        redirect('/unbans/view/' . $id);
                    } else {
                        die('Something went wrong.');
                    }
                }

                if ($data['canCloseUnbans'] && isset($_POST['needs_owner'])) {
                    $status = 'Needs Owner Involvement';

                    if ($this->unbanModel->updateStatus($id, $status)) {
                        flashMessage('success', 'Request has been sent to an owner for moderation.');
                        redirect('/unbans/view/' . $id);
                    } else {
                        die('Something went wrong.');
                    }
                }

                if ($data['canDeleteUnbans'] && isset($_POST['delete_unban'])) {
                    if ($this->unbanModel->deleteUnban($id)) {
                        flashMessage('success', 'Request has been successfully deleted.');
                        redirect('/unbans');
                    } else {
                        die('Something went wrong.');
                    }
                }

                if (isset($_POST['post_reply'])) {
                    // sanitize post data
                    $_POST['unban_reply'] = htmlentities($_POST['unban_reply']);

                    $postData = [
                        'unban_request_id' => $id,
                        'body' => $_POST['unban_reply'],
                        'author_id' => $_SESSION['user_id'],
                        'author_ip' => getUserIp()
                    ];

                    // post reply
                    if ($this->unbanModel->postUnbanReply($postData)) {
                        flashMessage('success', 'Your reply has been successfully posted.');
                        redirect('/unbans/view/' . $id);
                    } else {
                        die('Something went wrong.');
                    }
                }
            } else {
                // load view
                $this->loadView('unban_view', $data);
            }
        } else {
            $this->error('403', 'Forbidden!');
        }
    }
}