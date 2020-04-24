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
        } else if ($this->privileges['isAdmin'] < 7) {
            $this->error('403', 'Forbidden!');
        }
    }

    public function index()
    {
        $this->error('404', 'Page Not Found!');
    }

    public function panel()
    {
        if (isLoggedIn() && $this->privileges['isAdmin'] > 6) {
            $adminLogs = $this->logModel->panelAdminLogs();
            $leaderLogs = $this->logModel->panelLeaderLogs();
            $playerLogs = $this->logModel->panelPlayerLogs();
            $loginLogs = $this->logModel->panelLoginLogs();

            $data = [
                'pageTitle' => 'Panel Logs',
                'adminLogs' => $adminLogs,
                'leaderLogs' => $leaderLogs,
                'playerLogs' => $playerLogs,
                'loginLogs' => $loginLogs
            ];

            // load view
            $this->loadView('logs_panel', $data);

        } else {
            $this->error('403', 'Forbidden!');
        }
    }

    public function server()
    {
        if (isLoggedIn() && $this->privileges['isAdmin'] > 6) {
            $allLogs = $this->logModel->allLogs();
            $adminLogs = $this->logModel->adminLogs();
            $anticheatLogs = $this->logModel->anticheatLogs();
            $chatLogs = $this->logModel->chatLogs();
            $businessLogs = $this->logModel->businessLogs();
            $houseLogs = $this->logModel->houseLogs();
            $carLogs = $this->logModel->carLogs();
            $moneyLogs = $this->logModel->moneyLogs();

            $data = [
                'pageTitle' => 'Server Logs',
                'allLogs' => $allLogs,
                'adminLogs' => $adminLogs,
                'anticheatLogs' => $anticheatLogs,
                'chatLogs' => $chatLogs,
                'businessLogs' => $businessLogs,
                'houseLogs' => $houseLogs,
                'carLogs' => $carLogs,
                'moneyLogs' => $moneyLogs
            ];

            // load view
            $this->loadView('logs_server', $data);

        } else {
            $this->error('403', 'Forbidden!');
        }
    }

    public function player($id = 0)
    {
        $user = $this->logModel->getUserName($id);

        if (isLoggedIn() && $this->privileges['isAdmin'] > 6) {
            if ($id != 0 && !(empty($user))) {
                $playerAllLogs = $this->logModel->playerAllLogs($id);
                $playerAdminLogs = $this->logModel->playerAdminLogs($id);
                $playerAnticheatLogs = $this->logModel->playerAnticheatLogs($id);
                $playerChatLogs = $this->logModel->playerChatLogs($id);
                $playerBusinessLogs = $this->logModel->playerBusinessLogs($id);
                $playerHouseLogs = $this->logModel->playerHouseLogs($id);
                $playerCarLogs = $this->logModel->playerCarLogs($id);
                $playerMoneyLogs = $this->logModel->playerMoneyLogs($id);
                $pAdminLogs = $this->logModel->pAdminLogs($id);
                $pLeaderLogs = $this->logModel->pLeaderLogs($id);
                $pPlayerLogs = $this->logModel->pPlayerLogs($id);
                $pLoginLogs = $this->logModel->pLoginLogs($id);

                $data = [
                    'pageTitle' => 'Player Logs',
                    'player_name' => $user['NickName'],
                    'playerAllLogs' => $playerAllLogs,
                    'playerAdminLogs' => $playerAdminLogs,
                    'playerAnticheatLogs' => $playerAnticheatLogs,
                    'playerChatLogs' => $playerChatLogs,
                    'playerBusinessLogs' => $playerBusinessLogs,
                    'playerHouseLogs' => $playerHouseLogs,
                    'playerCarLogs' => $playerCarLogs,
                    'playerMoneyLogs' => $playerMoneyLogs,
                    'pAdminLogs' => $pAdminLogs,
                    'pLeaderLogs' => $pLeaderLogs,
                    'pPlayerLogs' => $pPlayerLogs,
                    'pLoginLogs' => $pLoginLogs
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