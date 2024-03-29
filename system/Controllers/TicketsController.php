<?php
/**
 * @brief Tickets controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/Validations/ValidateTicket.php';

class TicketsController extends Controller
{
    use ValidateTicket;
    private $ticketModel;
    private $categoryModel;
    private $userModel;
    private $logModel;

    public function __construct()
    {
        parent::__construct();

        // load models
        $this->ticketModel = $this->loadModel('Ticket');
        $this->categoryModel = $this->loadModel('Category');
        $this->userModel = $this->loadModel('User');
        $this->logModel = $this->loadModel('Log');

        if (!isLoggedIn()) {
            flashMessage('danger', siteLang()['ticket_not_logged_txt']);
            redirect('/');
        }
    }

    public function index()
    {
        $allTickets = $this->ticketModel->getAllTickets();
        $userTickets = $this->ticketModel->getUserTickets($_SESSION['user_id']);

        if ($this->privileges['canViewTickets']) {
            $tickets = $allTickets;
        } else {
            $tickets = $userTickets;
        }

        $data = [
            'pageTitle' => 'Panel Tickets',
            'tickets' => $tickets
        ];

        $this->loadView('ticket_index', $data);
    }

    public function create()
    {
        $type = 'ticket';
        $categories = $this->categoryModel->getAllCategories($type);

        if (isset($_POST['create_ticket'])) {
            // sanitize post data
            $_POST['ticket_category'] = filter_var($_POST['ticket_category'], FILTER_SANITIZE_NUMBER_INT);

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
                'ticket' => $dataPost,
                'categories' => $categories,
                'ticketBody' => $_POST['ticket_body']
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
                'ticketBody' => '',
                'ticket' => [
                    'body' => '',
                    'category_id' => 0
                ],
                'categories' => $categories
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
        } else if ($ticket['author_id'] != $_SESSION['user_id'] && $ticket['status'] != 'Open' || !$this->privileges['canEditTickets']) {
            $this->error('403', 'Forbidden!');
        } else {
            $type = 'ticket';
            $categories = $this->categoryModel->getAllCategories($type);
            $category_name = $this->ticketModel->getCategoryName($ticket['category_id']);

            // check if delete group button is set
            if ($this->privileges['canDeleteTickets'] && isset($_POST['delete_ticket'])) {
                if ($this->ticketModel->deleteTicket($id)) {
                    // log action
                    $logAction = $_SESSION['user_name'] . ' deleted ticket (ID: ' . $id . ').';
                    $logData = [
                        'type' => 'Ticket',
                        'action' => $logAction
                    ];
                    $this->logModel->adminLog($logData);

                    flashMessage('success', 'Ticket has been successfully deleted!');
                    redirect('/tickets');
                    unset($_POST);
                } else {
                    die('Something went wrong');
                }
            }

            // check if close group button is set
            if ($this->privileges['canCloseTickets'] && isset($_POST['close_ticket'])) {
                $status = 'Closed';
                $closed_by = $_SESSION['user_id'];

                if ($this->ticketModel->updateStatus($id, $status, $closed_by)) {
                    // log action
                    $logAction = $_SESSION['user_name'] . ' closed ticket (ID: ' . $id . ').';
                    $logData = [
                        'type' => 'Ticket',
                        'action' => $logAction
                    ];
                    $this->logModel->adminLog($logData);

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
                'ticket' => $ticket,
                'categories' => $categories,
            ];

            if ($_SESSION['user_id'] == $ticket['author_id'] || $this->privileges['canEditTickets']) {
                if (isset($_POST['edit_ticket'])) {
                    // sanitize post data
                    $_POST['ticket_category'] = filter_var($_POST['ticket_category'], FILTER_SANITIZE_NUMBER_INT);
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
                            // log action
                            $logAction = $_SESSION['user_name'] . ' edited ticket (ID: ' . $id . ').';
                            $logData = [
                                'type' => 'Ticket',
                                'action' => $logAction
                            ];
                            if ($_SESSION['user_id'] == $ticket['author_id']) {
                                $this->logModel->playerLog($logData);
                            } else {
                                $this->logModel->adminLog($logData);
                            }

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
                        'ticket' => [
                            'body' => $ticket['body'],
                            'category_id' => $ticket['category_id']
                        ],
                        'category_name' => $category_name,
                        'categories' => $categories
                    ];

                    // load view
                    $this->loadView('ticket_edit', $data);
                }
            }
        }
    }

    public function view($id = 0)
    {
        $ticket = $this->ticketModel->getTicket($id);
        $author = $this->userModel->searchUserById($ticket['author_id']);

        if (empty($id) || empty($ticket)) {
            $this->error('404', 'Page Not Found!');
        } else if ($ticket['author_id'] != $_SESSION['user_id'] && !$this->privileges['canViewTickets']) {
            $this->error('403', 'Forbidden!');
        } else {
            // get replies
            $replies = $this->ticketModel->getReplies($id);
            $finalReplies = array();
            if (!empty($replies)) {
                foreach ($replies as $reply) {
                    $reply['body'] = html_entity_decode($reply['body']);
                    array_push($finalReplies, $reply);
                }
            }

            $ticket['body'] = html_entity_decode($ticket['body']);

            // get categories
            $categories = $this->categoryModel->getAllCategories('ticket');

            $data = [
                'pageTitle' => 'View Ticket',
                'ticket' => $ticket,
                'author' => $author,
                'replies' => $finalReplies,
                'categories' => $categories
            ];

            if ($this->privileges['canDeleteTickets'] && isset($_POST['delete_ticket'])) {
                if ($this->ticketModel->deleteTicket($id)) {
                    // log action
                    $logAction = $_SESSION['user_name'] . ' deleted ticket (ID: ' . $id . ').';
                    $logData = [
                        'type' => 'Ticket',
                        'action' => $logAction
                    ];
                    $this->logModel->adminLog($logData);

                    flashMessage('success', 'Ticket has been successfully deleted!');
                    redirect('/tickets');
                    unset($_POST);
                } else {
                    die('Something went wrong');
                }
            } else if ($this->privileges['canCloseTickets'] && isset($_POST['close_ticket'])) {
                $status = 'Closed';
                $closed_by = $_SESSION['user_id'];

                if ($this->ticketModel->updateStatus($id, $status, $closed_by)) {
                    // log action
                    $logAction = $_SESSION['user_name'] . ' closed ticket (ID: ' . $id . ').';
                    $logData = [
                        'type' => 'Ticket',
                        'action' => $logAction
                    ];
                    $this->logModel->adminLog($logData);

                    flashMessage('success', 'Ticket has been successfully closed!');
                    redirect('/tickets/view/' . $id);
                    unset($_POST);
                } else {
                    die('Something went wrong');
                }
            } else if ($this->privileges['canCloseTickets'] && isset($_POST['open_ticket'])) {
                if ($this->ticketModel->updateStatus($id, 'Open')) {
                    // log action
                    $logAction = $_SESSION['user_name'] . ' opened ticket (ID: ' . $id . ').';
                    $logData = [
                        'type' => 'Ticket',
                        'action' => $logAction
                    ];
                    $this->logModel->adminLog($logData);

                    flashMessage('success', 'Ticket has been successfully opened!');
                    redirect('/tickets/view/' . $id);
                    unset($_POST);
                } else {
                    die('Something went wrong');
                }
            } else if ($this->privileges['canCloseTickets'] && isset($_POST['change_category'])) {
                // filter post
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $cID = $_POST['new_category_id'];
                // change category
                if ($this->ticketModel->changeCategory($cID, $id)) {
                    // log action
                    $logAction = $_SESSION['user_name'] . ' changed ticket (ID: ' . $id . ') category to ' . $cID . '.';
                    $logData = [
                        'type' => 'Ticket',
                        'action' => $logAction
                    ];
                    $this->logModel->adminLog($logData);

                    flashMessage('success', 'Ticket category has been successfully changed.');
                    redirect('/tickets/view/' . $id);
                } else {
                    die('Something went wrong');
                }
            } else if ($this->privileges['canCloseTickets'] && isset($_POST['needs_owner'])) {
                if ($this->ticketModel->updateStatus($id, 'Needs Owner Involvement')) {
                    // log action
                    $logAction = $_SESSION['user_name'] . ' changed ticket (ID: ' . $id . ') category to: Needs Owner Involvement.';
                    $logData = [
                        'type' => 'Ticket',
                        'action' => $logAction
                    ];
                    $this->logModel->adminLog($logData);

                    flashMessage('success', 'Ticket status has been successfully updated.');
                    redirect('/tickets/view/' . $id);
                } else {
                    die('Something went wrong.');
                }
            } else if ($this->privileges['canDeleteTReplies'] && isset($_POST['delete_reply'])) {
                // filter post
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $reply_id = $_POST['reply_id'];
                if ($this->ticketModel->deleteReply($reply_id)) {
                    // log action
                    $logAction = $_SESSION['user_name'] . ' deleted reply #' . $reply_id . ' from ticket (ID: ' . $id . ').';
                    $logData = [
                        'type' => 'Ticket',
                        'action' => $logAction
                    ];
                    $this->logModel->adminLog($logData);

                    flashMessage('success', 'Reply has been successfully deleted.');
                    redirect('/tickets/view/' . $id);
                } else {
                    die('Something went wrong.');
                }
            }

            if (isset($_POST['reply_ticket'])) {
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
                $this->loadView('ticket_view', $data);
            }
        }
    }
}