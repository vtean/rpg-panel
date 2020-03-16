<?php
/**
 * @brief Statistics controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/API/SampQuery.class.php';

class StatisticsController extends Controller
{
    private $generalModel;

    public function __construct()
    {
        // load the model
        $this->generalModel = $this->loadModel('General');
    }
    public function online()
    {
        $query = new SampQuery("rpg.dreamvibe.ro", 7777);

        if ($query->connect()) {
            $players = $query->getBasicPlayers();
            $info = $query->getInfo();
        } else {
            echo "Server did not respond!<br />";
        }
        $query->close(); // Close the connection


        $fullAccess = isLoggedIn() ? $this->generalModel->checkFullAccess($_SESSION['user_name']) : 0;
        $isAdmin = isLoggedIn() ? $this->generalModel->checkAdmin($_SESSION['user_name']) : 0;
        $isLeader = isLoggedIn() ? $this->generalModel->checkLeader($_SESSION['user_name']) : 0;
        $data = [
            'pageTitle' => 'Online',
            'fullAccess' => $fullAccess,
            'isAdmin' => $isAdmin,
            'isLeader' => $isLeader,
            'players' => $players,
            'info' => $info
        ];
        $this->loadView('online', $data);
    }
}