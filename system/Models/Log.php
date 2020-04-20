<?php
/**
 * @brief The model for logs page.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Log
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function getUserName($id)
    {
        $sql = "SELECT `NickName` FROM `sv_accounts` WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        return $this->db->getResult();
    }

    public function allLogs()
    {
        $sql = "SELECT * FROM `sv_logs_all`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function adminLogs()
    {
        $sql = "SELECT * FROM `sv_logs_admin`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['admin'] = $this->getUserName($result['admin_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function anticheatLogs()
    {
        $sql = "SELECT * FROM `sv_logs_anticheat`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function chatLogs()
    {
        $sql = "SELECT * FROM `sv_logs_chat`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function businessLogs()
    {
        $sql = "SELECT * FROM `sv_logs_biz`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function houseLogs()
    {
        $sql = "SELECT * FROM `sv_logs_house`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function carLogs()
    {
        $sql = "SELECT * FROM `sv_logs_car`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function moneyLogs()
    {
        $sql = "SELECT * FROM `sv_logs_money`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerAllLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_all` WHERE `player_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerAdminLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_admin` WHERE `admin_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['admin'] = $this->getUserName($result['admin_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerAnticheatLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_anticheat` WHERE `player_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerChatLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_chat` WHERE `player_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerBusinessLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_biz` WHERE `player_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerHouseLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_house` WHERE `player_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerCarLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_car` WHERE `player_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerMoneyLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_money` WHERE `player_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }
}