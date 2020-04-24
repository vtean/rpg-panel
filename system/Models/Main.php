<?php
/**
 * @brief The model for main page functions
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Main
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function getUserSkin($id)
    {
        $sql = "SELECT `Skin` FROM `sv_accounts` WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        return $this->db->getResult()['Skin'];
    }

    public function getHouses()
    {
        $sql = "SELECT `ID` FROM `sv_houses`";
        // prepare the query
        $this->db->prepareQuery($sql);
        // get the result
        $this->db->getResult();
        return $this->db->countRows();
    }

    public function getBusiness()
    {
        $sql = "SELECT `ID` FROM `sv_businesses`";
        // prepare the query
        $this->db->prepareQuery($sql);
        // get the result
        $this->db->getResult();
        return $this->db->countRows();
    }

    public function getVehicles()
    {
        $sql = "SELECT `Owner` FROM `sv_vehicles` WHERE NOT `Owner`='The State'";
        // prepare the query
        $this->db->prepareQuery($sql);
        // get the result
        $this->db->getResult();
        return $this->db->countRows();
    }

    public function getRegUsers()
    {
        $sql = "SELECT `ID` FROM `sv_accounts`";
        // prepare the query
        $this->db->prepareQuery($sql);
        // get the result
        $this->db->getResult();
        return $this->db->countRows();
    }

    public function latestFactionHistory()
    {
        $sql = "SELECT * FROM `sv_faction_history` ORDER BY `date` DESC LIMIT 15";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player_skin'] = $this->getUserSkin($result['player_id']);
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }
}