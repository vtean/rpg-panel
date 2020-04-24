<?php
/**
 * @brief The model for private pages.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Secret
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function getLeaderFaction($id)
    {
        $sql = "SELECT * FROM `sv_factions` WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        return $this->db->getResult();
    }

    public function changeAppsStatus($id, $status)
    {
        $sql = "UPDATE `sv_factions` SET `Apps_Status`=:status WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
             return true;
        } else {
            return false;
        }
    }

    public function countHelperApps()
    {
        $sql = "SELECT * FROM `panel_apps` WHERE `type`=:appType";
        $this->db->prepareQuery($sql);
        $this->db->bind(':appType', 'helper');
        $this->db->executeStmt();
        return $this->db->countRows();
    }

    public function countLeaderApps($id)
    {
        $sql = "SELECT * FROM `panel_apps` WHERE `type`=:appType AND `extra`=:extra";
        $this->db->prepareQuery($sql);
        $this->db->bind(':appType', 'leader');
        $this->db->bind(':extra', $id);
        $this->db->executeStmt();
        return $this->db->countRows();
    }

    public function getFactions()
    {
        $sql = "SELECT * FROM `sv_factions`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['leaderApps'] = $this->countLeaderApps($result['ID']);
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function countFactionComplaints($id, $status)
    {
        $sql = "SELECT * FROM `panel_fcomplaints` WHERE `faction_id`=:id AND `status`=:status";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        $this->db->executeStmt();
        return $this->db->countRows();
    }

    public function countFactionApplications($id, $status)
    {
        $sql = "SELECT * FROM `panel_faction_apps` WHERE `faction_id`=:id AND `status`=:status";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        $this->db->executeStmt();
        return $this->db->countRows();
    }

    public function countFactionResignations($id, $status)
    {
        $sql = "SELECT * FROM `panel_resignations` WHERE `faction_id`=:id AND `status`=:status";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        $this->db->executeStmt();
        return $this->db->countRows();
    }
}