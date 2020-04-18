<?php
/**
 * @brief The model for family control.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Family
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function getUser($username)
    {
        $sql = "SELECT `NickName`, `Level`, `pFamily` FROM `sv_accounts` WHERE `NickName`=:username";
        $this->db->prepareQuery($sql);
        $this->db->bind(':username', $username);
        return $this->db->getResult();
    }

    public function getFamilyMembers($familyId)
    {
        $sql = "SELECT `NickName`, `pFamily` FROM `sv_accounts` WHERE `pFamily`=:familyId";
        $this->db->prepareQuery($sql);
        $this->db->bind(':familyId', $familyId);
        return $this->db->getResults();
    }

    public function getFamilies()
    {
        $sql = "SELECT * FROM `sv_families`";
        $this->db->prepareQuery($sql);
        return $this->db->getResults();
    }

    public function getFamily($id)
    {
        $sql = "SELECT * FROM `sv_families` WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $result = $this->db->getResult();
        if (!empty($result)) {
            $result['members'] = $this->getFamilyMembers($result['ID']);
        }
        return $result;
    }
}