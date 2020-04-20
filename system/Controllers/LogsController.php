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
    private $privileges;

    public function __construct()
    {
        // load model
        $this->logModel = $this->loadModel('Log');

        // store privileges
        $this->privileges = $this->checkPrivileges();

        if (!isLoggedIn()) {
            $this->error('403', 'Forbidden!');
        }
    }

    public function index()
    {
        global $lang;
        $badges = $this->badges();

        if (isLoggedIn() && $this->privileges['isAdmin'] > 2) {
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
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'lang' => $lang,
                'badges' => $badges,
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
            $this->loadView('logs_index', $data);

        } else {
            $this->error('403', 'Forbidden!');
        }
    }

    public function player($id = 0)
    {
        global $lang;
        $badges = $this->badges();
        $user = $this->logModel->getUserName($id);

        if (isLoggedIn() && $this->privileges['isAdmin'] > 2) {
            if ($id != 0 && !(empty($user))) {
                $playerAllLogs = $this->logModel->playerAllLogs($id);
                $playerAdminLogs = $this->logModel->playerAdminLogs($id);
                $playerAnticheatLogs = $this->logModel->playerAnticheatLogs($id);
                $playerChatLogs = $this->logModel->playerChatLogs($id);
                $playerBusinessLogs = $this->logModel->playerBusinessLogs($id);
                $playerHouseLogs = $this->logModel->playerHouseLogs($id);
                $playerCarLogs = $this->logModel->playerCarLogs($id);
                $playerMoneyLogs = $this->logModel->playerMoneyLogs($id);

                $data = [
                    'pageTitle' => 'Player Logs',
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader'],
                    'lang' => $lang,
                    'badges' => $badges,
                    'player_name' => $user['NickName'],
                    'playerAllLogs' => $playerAllLogs,
                    'playerAdminLogs' => $playerAdminLogs,
                    'playerAnticheatLogs' => $playerAnticheatLogs,
                    'playerChatLogs' => $playerChatLogs,
                    'playerBusinessLogs' => $playerBusinessLogs,
                    'playerHouseLogs' => $playerHouseLogs,
                    'playerCarLogs' => $playerCarLogs,
                    'playerMoneyLogs' => $playerMoneyLogs
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