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
    private $privileges;

    public function __construct()
    {
        // store user privileges
        $this->privileges = $this->checkPrivileges();
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

        $data = [
            'pageTitle' => 'Online',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'players' => $players,
            'info' => $info
        ];
        $this->loadView('online', $data);
    }
}