<?php
/**
 * @brief The model for general functions
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class General
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function checkFullAccess($username)
    {
        $sql = "SELECT * FROM sv_fulldostup WHERE FullDostup1=:username OR FullDostup2=:username 
                                            OR FullDostup3=:username OR FullDostup4=:username 
                                            OR FullDostup5=:username OR FullDostup6=:username 
                                            OR FullDostup7=:username OR FullDostup8=:username 
                                            OR FullDostup9=:username OR FullDostup10=:username 
                                            OR FullDostup11=:username OR FullDostup12=:username";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':username', $username);
        // get the result
        $this->db->getResult();
        if ($this->db->countRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkAdmin($username)
    {
        $sql = "SELECT * FROM sv_accounts WHERE NickName=:username";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':username', $username);
        // get the result
        $result = $this->db->getResult();
        $admin = $result['Admin'];
        if ($this->db->countRows() > 0) {
            return $admin;
        } else {
            return false;
        }
    }

    public function checkHelper($username)
    {
        $sql = "SELECT * FROM sv_accounts WHERE NickName=:username";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':username', $username);
        // get the result
        $result = $this->db->getResult();
        $helper = $result['Helper'];
        if ($this->db->countRows() > 0) {
            return $helper;
        } else {
            return false;
        }
    }

    public function checkLeader($username)
    {
        $sql = "SELECT * FROM sv_accounts WHERE NickName=:username";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':username', $username);
        // get the result
        $result = $this->db->getResult();
        $leader = $result['Leader'];
        if ($this->db->countRows() > 0) {
            return $leader;
        } else {
            return false;
        }
    }

}