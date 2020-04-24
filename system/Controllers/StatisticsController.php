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

    public function __construct()
    {
        parent::__construct();

        // load model
        $this->statisticModel = $this->loadModel('Statistic');
    }

    public function online()
    {
        $server = '188.212.102.123';
        $port = 7777;

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
            'players' => $players,
            'info' => $info,
        ];

        $this->loadView('online', $data);
    }

    public function staff()
    {
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
            'admins' => $finalAdmins,
            'leaders' => $leaders
        ];

        // load view
        $this->loadView('staff', $data);
    }

    public function top()
    {
        $allPlayers = $this->statisticModel->getAllUsers();

        $data = [
            'pageTitle' => 'Top Players',
            'allPlayers' => $allPlayers
        ];

        // load view
        $this->loadView('top', $data);
    }

    public function bans()
    {
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
            'bannedPlayers' => $finalBannedPlayers
        ];

        // load view
        $this->loadView('bans', $data);
    }

    public function houses()
    {
        $houses = $this->statisticModel->getHouses();

        $data = [
            'pageTitle' => 'Houses',
            'houses' => $houses
        ];

        // load view
        $this->loadView('houses', $data);
    }

    public function businesses()
    {
        $businesses = $this->statisticModel->getBusinesses();

        $data = [
            'pageTitle' => 'Businesses',
            'businesses' => $businesses
        ];

        // load view
        $this->loadView('businesses', $data);
    }

    public function vehicles()
    {
        $vehicles = $this->statisticModel->getVehicles();

        $data = [
            'pageTitle' => 'Vehicles',
            'vehicles' => $vehicles
        ];

        // load view
        $this->loadView('vehicles', $data);
    }
}