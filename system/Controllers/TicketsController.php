<?php
/**
 * @brief TicketsController controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/Validations/ValidateTicket.php';

class TicketsController extends Controller
{
    use ValidateTicket;
    private $ticketModel;
    private $privileges;
    private $categoryModel;
    private $userModel;

    public function __construct()
    {
        global $lang;

        // load the model
        $this->ticketModel = $this->loadModel('Ticket');
        $this->categoryModel = $this->loadModel('Category');
        $this->userModel = $this->loadModel('User');

        // store user privileges
        $this->privileges = $this->checkPrivileges();

        if (!isLoggedIn()) {
            flashMessage('danger', $lang['ticket_not_logged_txt']);
            redirect('/');
        }
    }

    public function index()
    {
        global $lang;

        $allTickets = $this->ticketModel->getAllTickets();
        $userTickets = $this->ticketModel->getUserTickets($_SESSION['user_id']);

        // get badges
        $badges = $this->badges();

        if (in_array(1, $this->privileges['canViewTickets'])) {
            $tickets = $allTickets;
        } else {
            $tickets = $userTickets;
        }

        $data = [
            'pageTitle' => 'Panel Tickets',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'tickets' => $tickets,
            'lang' => $lang,
            'canViewTickets' => $this->privileges['canViewTickets'],
            'canDeleteTickets' => $this->privileges['canDeleteTickets'],
            'badges' => $badges
        ];

        $this->loadView('ticket_index', $data);
    }

    public function create()
    {
        global $lang;

        $type = 'ticket';
        $categories = $this->categoryModel->getAllCategories($type);

        // get badges
        $badges = $this->badges();

        if (isset($_POST['create_ticket'])) {
            // sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $_POST['ticket_body'] = str_replace(PHP_EOL, "<br>", $_POST['ticket_body']);
            $_POST['ticket_body'] = htmlentities($_POST['ticket_body']);

            $dataPost = [
                'body' => $_POST['ticket_body'],
                'author_id' => $_SESSION['user_id'],
                'author_ip' => getUserIp(),
                'category_id' => $_POST['ticket_category']
            ];

            // parse data
            $data = [
                'pageTitle' => 'Create Ticket',
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'ticket' => $dataPost,
                'categories' => $categories,
                'lang' => $lang,
                'ticketBody' => $_POST['ticket_body'],
                'badges' => $badges
            ];

            // handle errors
            $errors = ValidateTicket::validate($dataPost);

            // check if there are no errors
            if (count(array_filter($errors)) == 0) {
                // create group
                if ($this->ticketModel->createTicket($dataPost)) {
                    flashMessage('success', 'The ticket has been successfully created!');
                    redirect('/tickets');
                } else {
                    die('Something went wrong.');
                }
            } else {
                // load view with errors
                $this->loadView('ticket_create', $data, $errors);
            }
        } else {
            $data = [
                'pageTitle' => 'Create Ticket',
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'ticketBody' => '',
                'ticket' => [
                    'body' => '',
                    'category_id' => 0
                ],
                'categories' => $categories,
                'lang' => $lang,
                'badges' => $badges
            ];

            // load view
            $this->loadView('ticket_create', $data);
        }
    }

    public function edit($id = 0)
    {
        $ticket = $this->ticketModel->getTicket($id);

        if ($id == 0) {
            $this->error('404', 'Page Not Found!');
        } else if ($ticket['author_id'] != $_SESSION['user_id'] || $ticket['status'] != 'Open') {
            $this->error('403', 'Forbidden!');
        } else {
            global $lang;

            // get badges
            $badges = $this->badges();
            $type = 'ticket';
            $categories = $this->categoryModel->getAllCategories($type);
            $category_name = $this->ticketModel->getCategoryName($ticket['category_id']);

            // check if delete group button is set
            if (isset($_POST['delete_ticket'])) {
                if ($this->ticketModel->deleteTicket($id)) {
                    flashMessage('success', 'Ticket has been successfully deleted!');
                    redirect('/tickets');
                    unset($_POST);
                } else {
                    die('Something went wrong');
                }
            }

            // check if close group button is set
            if (isset($_POST['close_ticket'])) {
                if ($this->ticketModel->updateStatus($id, 'Closed')) {
                    flashMessage('success', 'Ticket has been successfully closed!');
                    redirect('/tickets');
                    unset($_POST);
                } else {
                    die('Something went wrong');
                }
            }

            // parse data
            $data = [
                'pageTitle' => 'Edit Ticket',
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'ticket' => $ticket,
                'categories' => $categories,
                'lang' => $lang,
                'canDeleteTickets' => $this->privileges['canDeleteTickets'],
                'badges' => $badges
            ];

            if (isset($_POST['edit_ticket'])) {
                // sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $_POST['ticket_body'] = str_replace(PHP_EOL, "<br>", $_POST['ticket_body']);
                $_POST['ticket_body'] = htmlentities($_POST['ticket_body']);

                $dataPost = [
                    'body' => $_POST['ticket_body'],
                    'category_id' => $_POST['ticket_category'],
                    'edit_ip' => getUserIp()
                ];

                // handle errors
                $errors = ValidateTicket::validate($dataPost);

                // check if there are no errors
                if (count(array_filter($errors)) == 0) {
                    // create group
                    if ($this->ticketModel->editTicket($dataPost, $id)) {
                        flashMessage('success', 'The ticket has been successfully edited!');
                        redirect('/tickets');
                    } else {
                        die('Something went wrong.');
                    }
                } else {
                    // load view with errors
                    $this->loadView('ticket_edit', $data, $errors);
                }
            } else {
                $data = [
                    'pageTitle' => 'Edit Ticket',
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader'],
                    'canDeleteTickets' => $this->privileges['canDeleteTickets'],
                    'ticket' => [
                        'body' => $ticket['body'],
                        'category_id' => $ticket['category_id']
                    ],
                    'category_name' => $category_name,
                    'categories' => $categories,
                    'lang' => $lang,
                    'badges' => $badges
                ];

                // load view
                $this->loadView('ticket_edit', $data);
            }
        }
    }

    public function view($id = 0)
    {
        $ticket = $this->ticketModel->getTicket($id);
        $author = $this->userModel->searchUserById($ticket['author_id']);

        if (empty($id) || empty($ticket)) {
            $this->error('404', 'Page Not Found!');
        } else if ($ticket['author_id'] != $_SESSION['user_id'] && !in_array(1, $this->privileges['canViewTickets'])) {
            $this->error('403', 'Forbidden!');
        } else {
            global $lang;

            // get badges
            $badges = $this->badges();

            // get replies
            $replies = $this->ticketModel->getReplies($id);

            if (isset($_POST['reply_ticket'])) {
                // sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $_POST['ticket_reply'] = str_replace(PHP_EOL, "<br>", $_POST['ticket_reply']);
                $_POST['ticket_reply'] = htmlentities($_POST['ticket_reply']);

                if ($ticket['author_id'] == $_SESSION['user_id']) {
                    $user_status = 'Author';
                    $status = 'Author Reply';
                } else {
                    $status = 'Admin Reply';
                    $user_status = 'Ticket Manager';
                }

                $dataPost = [
                    'ticket_id' => $id,
                    'body' => $_POST['ticket_reply'],
                    'author_id' => $_SESSION['user_id'],
                    'author_ip' => getUserIp(),
                    'user_status' => $user_status,
                ];

                $data = [
                    'pageTitle' => 'View Ticket',
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader'],
                    'canEditTickets' => $this->privileges['canEditTickets'],
                    'canDeleteTickets' => $this->privileges['canDeleteTickets'],
                    'ticket' => $ticket,
                    'reply' => $_POST['ticket_reply'],
                    'author' => $author,
                    'lang' => $lang,
                    'badges' => $badges,
                    'replies' => $replies
                ];

                // handle errors
                $errors = ValidateTicket::validateReply($_POST['ticket_reply']);

                // check if there are no errors
                if (count(array_filter($errors)) == 0) {
                    // create reply
                    if ($this->ticketModel->createReply($dataPost) && $this->ticketModel->updateStatus($id, $status)) {
                        flashMessage('success', 'The reply has been successfully posted!');
                        redirect('/tickets/view/' . $id);
                    } else {
                        die('Something went wrong.');
                    }
                } else {
                    // load view with errors
                    $this->loadView('ticket_view', $data, $errors);
                }
            } else {
                $data = [
                    'pageTitle' => 'View Ticket',
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader'],
                    'canEditTickets' => $this->privileges['canEditTickets'],
                    'canDeleteTickets' => $this->privileges['canDeleteTickets'],
                    'ticket' => $ticket,
                    'author' => $author,
                    'lang' => $lang,
                    'badges' => $badges,
                    'replies' => $replies,
                ];
                $this->loadView('ticket_view', $data);
            }
        }
    }
}