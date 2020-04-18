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

    public function top()
    {
        global $lang;
        $badges = $this->badges();
        $allPlayers = $this->statisticModel->getAllUsers();

        $data = [
            'pageTitle' => 'Top Players',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'lang' => $lang,
            'badges' => $badges,
            'allPlayers' => $allPlayers
        ];

        // load view
        $this->loadView('top', $data);
    }

    public function bans()
    {
        global $lang;
        $badges = $this->badges();
        $bannedPlayers = $this->statisticModel->getBannedUsers();
        $finalBannedPlayers = array();
        if (!empty($bannedPlayers)) {
            foreach ($bannedPlayers as $player) {
                $player['banDateUnix'] = strtotime($player['CreatedAt']);
                $player['unbanDateUnix'] = $player['banDateUnix'] + $player['BanSeconds'];
                $player['unbanDate'] = date("Y-m-d H:i:s", $player['unbanDateUnix']);
                unset($player['banDateUnix'], $player['unbanDateUnix']);
                array_push($finalBannedPlayers, $player);
            }
        }

        $data = [
            'pageTitle' => 'Banned Players',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'lang' => $lang,
            'badges' => $badges,
            'bannedPlayers' => $finalBannedPlayers
        ];

        // load view
        $this->loadView('bans', $data);
    }

    public function houses()
    {
        global $lang;
        $badges = $this->badges();
        $houses = $this->statisticModel->getHouses();

        $data = [
            'pageTitle' => 'Houses',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'lang' => $lang,
            'badges' => $badges,
            'houses' => $houses
        ];

        // load view
        $this->loadView('houses', $data);
    }

    public function businesses()
    {
        global $lang;
        $badges = $this->badges();
        $businesses = $this->statisticModel->getBusinesses();

        $data = [
            'pageTitle' => 'Businesses',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'lang' => $lang,
            'badges' => $badges,
            'businesses' => $businesses
        ];

        // load view
        $this->loadView('businesses', $data);
    }

    public function vehicles()
    {
        global $lang;
        $badges = $this->badges();
        $vehicles = $this->statisticModel->getVehicles();

        $data = [
            'pageTitle' => 'Vehicles',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'lang' => $lang,
            'badges' => $badges,
            'vehicles' => $vehicles
        ];

        // load view
        $this->loadView('vehicles', $data);
    }
}