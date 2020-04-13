<?php
/**
 * @brief Statistics controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */


class StatisticsController extends Controller
{
    private $statisticModel;
    private $privileges;

    public function __construct()
    {
        // load model
        $this->statisticModel = $this->loadModel('Statistic');

        // store user privileges
        $this->privileges = $this->checkPrivileges();

    }

    public function online()
    {
        global $lang;
        $server = "rpg.dreamvibe.ro";
        $port = 7777;

        // get badges
        $badges = $this->badges();

        $query = new SampQuery($server, $port);

        if ($query->connect()) {
            $players = $query->getBasicPlayers();
            $info = $query->getInfo();
        } else {
            echo "Server did not respond!<br />";
        }
        $query->close();

        $players = $this->statisticModel->onlineUsers($players);

        $data = [
            'pageTitle' => 'Online',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'players' => $players,
            'info' => $info,
            'lang' => $lang,
            'badges' => $badges
        ];


        $this->loadView('online', $data);
    }

    public function staff()
    {
        global $lang;
        $badges = $this->badges();
        $admins = $this->statisticModel->getAdmins();
        $finalAdmins = array();
        $leaders = $this->statisticModel->getLeaders();

        if (!empty($admins)) {
            foreach ($admins as $admin) {
                $admin['groups'] = array();
                $adminGroupsArr = unserialize($admin['PanelGroups']);
                if (!empty($adminGroupsArr)) {
                    foreach ($adminGroupsArr as $key => $value) {
                        $gInfo = $this->statisticModel->getAdminGroup($value);
                        array_push($admin['groups'], $gInfo);
                    }
                }
                array_push($finalAdmins, $admin);
            }
        }

        $data = [
            'pageTitle' => 'Staff',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'lang' => $lang,
            'badges' => $badges,
            'admins' => $finalAdmins,
            'leaders' => $leaders
        ];

        // load view
        $this->loadView('staff', $data);
    }
}