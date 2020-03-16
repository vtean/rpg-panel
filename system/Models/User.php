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
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

}