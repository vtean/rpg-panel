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

    public function getFaction($factionId) {
        $sql = "SELECT Name FROM orgsinfo WHERE ID=:factionId";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':factionId', $factionId);
        // get the result
        $result = $this->db->getResult();
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

}