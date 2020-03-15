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

    public function getHouses()
    {
        $sql = "SELECT ID FROM houses";
        // prepare the query
        $this->db->prepareQuery($sql);
        // get the result
        $this->db->getResult();
        return $this->db->countRows();
    }

    public function getBusiness()
    {
        $sql = "SELECT ID FROM businesses";
        // prepare the query
        $this->db->prepareQuery($sql);
        // get the result
        $this->db->getResult();
        return $this->db->countRows();
    }

    public function getVehicles()
    {
        $sql = "SELECT Owner FROM ownable WHERE NOT Owner = 'The State'";
        // prepare the query
        $this->db->prepareQuery($sql);
        // get the result
        $this->db->getResult();
        return $this->db->countRows();
    }

    public function getRegUsers()
    {
        $sql = "SELECT ID FROM accounts";
        // prepare the query
        $this->db->prepareQuery($sql);
        // get the result
        $this->db->getResult();
        return $this->db->countRows();
    }

}