<?php
/**
 * @brief Logs controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class LogsController extends Controller
{
    private $logModel;

    public function __construct()
    {
        parent::__construct();

        // load model
        $this->logModel = $this->loadModel('Log');

        if (!isLoggedIn()) {
            $this->error('403', 'Forbidden!');
            exit;
        } else if ($this->privileges['isAdmin'] < 7) {
            $this->error('403', 'Forbidden!');
            exit;
        }
    }

    public function index()
    {
        $this->error('404', 'Page Not Found!');
    }

    public function panel($page = 'admin')
    {
        $allowedPages = array('admin', 'leader', 'player', 'login');
        if (!in_array($page, $allowedPages)) {
            $this->error('404', 'Page Not Found!');
        } else {
            if (isLoggedIn() && $this->privileges['isAdmin'] > 6) {
                if ($page == 'admin') {
                    $logs = $this->logModel->panelAdminLogs();
                } else if ($page == 'leader') {
                    $logs = $this->logModel->panelLeaderLogs();
                } else if ($page == 'player') {
                    $logs = $this->logModel->panelPlayerLogs();
                } else if ($page == 'login') {
                    $logs = $this->logModel->panelLoginLogs();
                }

                $data = [
                    'pageTitle' => 'Panel Logs',
                    'logs' => $logs,
                    'activePage' => $page
                ];

                // load view
                $this->loadView('logs_panel', $data);

            } else {
                $this->error('403', 'Forbidden!');
            }
        }
    }

    public function server($page = 'all')
    {
        $allowedPages = array('all', 'admin', 'anticheat', 'chat', 'business', 'house', 'car', 'money');
        if (!in_array($page, $allowedPages)) {
            $this->error('404', 'Page Not Found!');
        } else {
            if (isLoggedIn() && $this->privileges['isAdmin'] > 6) {
                if ($page == 'all') {
                    $logs = $this->logModel->allLogs();
                } else if ($page == 'admin') {
                    $logs = $this->logModel->adminLogs();
                } else if ($page == 'anticheat') {
                    $logs = $this->logModel->anticheatLogs();
                } else if ($page == 'chat') {
                    $logs = $this->logModel->chatLogs();
                } else if ($page == 'business') {
                    $logs = $this->logModel->businessLogs();
                } else if ($page == 'house') {
                    $logs = $this->logModel->houseLogs();
                } else if ($page == 'car') {
                    $logs = $this->logModel->carLogs();
                } else if ($page == 'money') {
                    $logs = $this->logModel->moneyLogs();
                }

                $data = [
                    'pageTitle' => 'Server Logs',
                    'logs' => $logs,
                    'activePage' => $page
                ];

                // load view
                $this->loadView('logs_server', $data);

            } else {
                $this->error('403', 'Forbidden!');
            }
        }
    }

    public function player($id = 0, $page = 'all')
    {
        $serverPages = array('all', 'admin', 'anticheat', 'chat', 'business', 'house', 'car', 'money');
        $panelPages = array('adm', 'leader', 'player', 'login');

        if (!in_array($page, $serverPages) && !in_array($page, $panelPages)) {
            $this->error('404', 'Page Not Found!');
        } else {
            $user = $this->logModel->getUserName($id);

            if (isLoggedIn() && $this->privileges['isAdmin'] > 6) {
                if ($id != 0 && !(empty($user))) {
                    if ($page == 'all') {
                        $logs = $this->logModel->playerAllLogs($id);
                    } else if ($page == 'admin') {
                        $logs = $this->logModel->playerAdminLogs($id);
                    } else if ($page == 'anticheat') {
                        $logs = $this->logModel->playerAnticheatLogs($id);
                    } else if ($page == 'chat') {
                        $logs = $this->logModel->playerChatLogs($id);
                    } else if ($page == 'business') {
                        $logs = $this->logModel->playerBusinessLogs($id);
                    } else if ($page == 'house') {
                        $logs = $this->logModel->playerHouseLogs($id);
                    } else if ($page == 'car') {
                        $logs = $this->logModel->playerCarLogs($id);
                    } else if ($page == 'money') {
                        $logs = $this->logModel->playerMoneyLogs($id);
                    } else if ($page == 'adm') {
                        $logs = $this->logModel->pAdminLogs($id);
                    } else if ($page == 'leader') {
                        $logs = $this->logModel->pLeaderLogs($id);
                    } else if ($page == 'player') {
                        $logs = $this->logModel->pPlayerLogs($id);
                    } else if ($page == 'login') {
                        $logs = $this->logModel->pLoginLogs($id);
                    }

                    $data = [
                        'pageTitle' => 'Player Logs',
                        'player_id' => $id,
                        'player_name' => $user['NickName'],
                        'logs' => $logs,
                        'activePage' => $page,
                        'serverPages' => $serverPages,
                        'panelPages' => $panelPages
                    ];

                    // load view
                    $this->loadView('logs_player', $data);

                } else {
                    $this->error('404', 'Page Not Found!');
                }
            } else {
                $this->error('403', 'Forbidden!');
            }
        }
    }
}