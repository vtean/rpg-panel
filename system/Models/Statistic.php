<?php
/**
 * @brief The model for statistics control.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Statistic
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function getAllUsers()
    {
        $sql = "SELECT `NickName`, `Level`, `Exp`, `TotalPlayed` FROM `sv_accounts`";
        $this->db->prepareQuery($sql);
        return $this->db->getResults();
    }

    public function getAdmins()
    {
        $sql = "SELECT `NickName`, `Admin`, `Online_status`, `LastLogin`, `PanelGroups` FROM `sv_accounts` WHERE `Admin` > :notAdmin ORDER BY `Admin` DESC, `ID` ASC";
        $this->db->prepareQuery($sql);
        $this->db->bind(':notAdmin', 0);
        return $this->db->getResults();
    }

    public function getAdminGroup($id)
    {
        $sql = "SELECT * FROM `panel_groups` WHERE `group_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        return $this->db->getResult();
    }

    public function getBannedUsers()
    {
        $sql = "SELECT * FROM `sv_bannames`";
        $this->db->prepareQuery($sql);
        return $this->db->getResults();
    }

    public function getHouses()
    {
        $sql = "SELECT * FROM `sv_houses`";
        $this->db->prepareQuery($sql);
        return $this->db->getResults();
    }

    public function getBusinesses()
    {
        $sql = "SELECT * FROM `sv_businesses`";
        $this->db->prepareQuery($sql);
        return $this->db->getResults();
    }

    public function getVehicleName($model)
    {
        $sql = "SELECT `Name` FROM `sv_modellimit` WHERE `Model`=:model";
        $this->db->prepareQuery($sql);
        $this->db->bind(':model', $model);
        return $this->db->getResult();
    }

    public function getVehicles()
    {
        $sql = "SELECT * FROM `sv_vehicles`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['name'] = $this->getVehicleName($result['Model'])['Name'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function getFactionName($id)
    {
        $sql = "SELECT `Name` FROM `sv_factions` WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        return $this->db->getResult();
    }

    public function countFactionMembers($factionId)
    {
        $sql = "SELECT `NickName` FROM `sv_accounts` WHERE `Member`=:factionId";
        $this->db->prepareQuery($sql);
        $this->db->bind(':factionId', $factionId);
        $this->db->executeStmt();
        return $this->db->countRows();
    }

    public function getLeaders()
    {
        $sql = "SELECT `NickName`, `Member`, `LastLogin`, `Online_status` FROM `sv_accounts` WHERE `Leader` > :notLeader ORDER BY `Leader`";
        $this->db->prepareQuery($sql);
        $this->db->bind('notLeader', 0);
        $results = $this->db->getResults();
        $final_results = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                if ($result['Member'] != 0) {
                    $result['faction_name'] = $this->getFactionName($result['Member'])['Name'];
                }
                $result['faction_members'] = $this->countFactionMembers($result['Member']);
                array_push($final_results, $result);
            }
        }
        return $final_results;
    }

    public function searchExistingUser($nickname)
    {
        $sql = "SELECT * FROM `sv_accounts` WHERE `NickName`=:user_nick";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':user_nick', $nickname);
        // get the result
        $result = $this->db->getResult();
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function onlineUsers($users)
    {
        $final_results = array();
        if (!empty($users)) {
            foreach ($users as $user) {
                $user['faction_name'] = $this->getFactionName($this->searchExistingUser($user['name'])['Member'])['Name'];
                $user['played_time'] = convertMinutes($this->searchExistingUser($user['name'])['PlayedTime']);
                array_push($final_results, $user);
            }
        }
        return $final_results;
    }
}