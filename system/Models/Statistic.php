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
                $result['faction_name'] = $this->getFactionName($result['Member'])['Name'];
                $result['faction_members'] = $this->countFactionMembers($result['Member']);
                array_push($final_results, $result);
            }
        }
        return $final_results;
    }
}