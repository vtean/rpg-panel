<?php
/**
 * @brief The model for user control
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function searchExistingUser($nickname)
    {
        $sql = "SELECT * FROM sv_accounts WHERE NickName=:user_nick";
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

    public function getFaction($factionId)
    {
        $sql = "SELECT Name FROM sv_factions WHERE ID=:factionId";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':factionId', $factionId);
        // get the result
        $result = $this->db->getResult();
        $faction = $result['Name'];
        if ($this->db->countRows() > 0) {
            return $faction;
        } else {
            return false;
        }
    }

    public function getJob($jobId)
    {
        $sql = "SELECT * FROM sv_jobs WHERE ID=:jobId";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':jobId', $jobId);
        // get the result
        $result = $this->db->getResult();
        $job = $result['name'];
        if ($this->db->countRows() > 0) {
            return $job;
        } else {
            return false;
        }
    }

    public function getFamily($familyId)
    {
        $sql = "SELECT * FROM sv_families WHERE ID=:familyId";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':familyId', $familyId);
        // get the result
        $result = $this->db->getResult();
        $job = $result['name'];
        if ($this->db->countRows() > 0) {
            return $job;
        } else {
            return false;
        }
    }

    public function getFactionRank($factionId, $rankId)
    {
        if ($rankId == 0) return false;
        $sql = "SELECT Rank_$rankId FROM sv_Factions WHERE ID=:factionId";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':factionId', $factionId);
        // get the result
        $result = $this->db->getResult();
        $rank = $result["Rank_" . $rankId];
        if ($this->db->countRows() > 0) {
            return $rank;
        } else {
            return false;
        }
    }

    public function getVehicle($nickName)
    {
        $sql = "SELECT * FROM sv_vehicles WHERE Owner=:nickname";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':nickname', $nickName);
        // get the result
        $result = $this->db->getResults();
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getModelName($nickName)
    {
        $sql = "SELECT * FROM sv_vehicles JOIN sv_modellimit ON sv_vehicles.Model = sv_modellimit.Model WHERE sv_vehicles.Owner=:nickname";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':nickname', $nickName);
        // get the result
        $result = $this->db->getResults();
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

}