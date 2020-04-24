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

    public function getUserNickname($id)
    {
        $sql = "SELECT `NickName` FROM `sv_accounts` WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $result = $this->db->getResult();
        if (!empty($result)) {
            return $result['NickName'];
        } else {
            return 'Unknown';
        }
    }

    public function checkFullAccess($username)
    {
        $sql = "SELECT * FROM `sv_fulldostup` WHERE `FullDostup1`=:username OR `FullDostup2`=:username 
                                            OR `FullDostup3`=:username OR `FullDostup4`=:username 
                                            OR `FullDostup5`=:username OR `FullDostup6`=:username 
                                            OR `FullDostup7`=:username OR `FullDostup8`=:username 
                                            OR `FullDostup9`=:username OR `FullDostup10`=:username 
                                            OR `FullDostup11`=:username OR `FullDostup12`=:username";
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
        $sql = "SELECT * FROM `sv_accounts` WHERE `NickName`=:username";
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
        $sql = "SELECT * FROM `sv_accounts` WHERE `NickName`=:username";
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
        $sql = "SELECT * FROM `sv_accounts` WHERE `NickName`=:username";
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

    public function getUserGroupById($group_id)
    {
        $sql = "SELECT * FROM `panel_groups` WHERE `group_id`=:group_id";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':group_id', $group_id);
        // get the result
        $result = $this->db->getResult();
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getUserGroups($user_id)
    {
        $sql = "SELECT `PanelGroups` from `sv_accounts` WHERE `ID`=:user_id";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':user_id', $user_id);
        // get result
        $result = $this->db->getResult();
        // transform result into an array of group IDs
        $groups = unserialize(implode($result));
        // create an array with user groups permissions
        $final_results = array();
        if (!empty($groups)) {
            foreach ($groups as $key => $value) {
                $group = $this->getUserGroupById($value);
                array_push($final_results, $group);
            }
        }
        return $final_results;
    }

    public function countAllTickets()
    {
        $sql = "SELECT * FROM `panel_tickets`";
        $this->db->prepareQuery($sql);
        $this->db->executeStmt();
        return $this->db->countRows();
    }

    public function countTickets($status)
    {
        $sql = "SELECT * FROM `panel_tickets` WHERE `status`=:status";
        $this->db->prepareQuery($sql);
        $this->db->bind(':status', $status);
        $this->db->executeStmt();
        return $this->db->countRows();
    }

    public function countAllComplaints()
    {
        $sql = "SELECT * FROM `panel_complaints`";
        $this->db->prepareQuery($sql);
        $this->db->executeStmt();
        return $this->db->countRows();
    }

    public function countComplaints($status)
    {
        $sql = "SELECT * FROM `panel_complaints` WHERE `status`=:status";
        $this->db->prepareQuery($sql);
        $this->db->bind(':status', $status);
        $this->db->executeStmt();
        return $this->db->countRows();
    }

    public function countAllUnbans()
    {
        $sql = "SELECT * FROM `panel_unbans`";
        $this->db->prepareQuery($sql);
        $this->db->executeStmt();
        return $this->db->countRows();
    }

    public function countUnbans($status)
    {
        $sql = "SELECT * FROM `panel_unbans` WHERE `status`=:status";
        $this->db->prepareQuery($sql);
        $this->db->bind(':status', $status);
        $this->db->executeStmt();
        return $this->db->countRows();
    }

    public function getSuspendedUser($id)
    {
        $sql = "SELECT * FROM `panel_suspended_users` WHERE `user_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        return $this->db->getResult();
    }

    public function unsuspendUser($id)
    {
        $sql = "DELETE FROM `panel_suspended_users` WHERE `user_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function getSettingValue($setting)
    {
        $sql = "SELECT * FROM `panel_settings` WHERE `setting_key`=:settingKey";
        $this->db->prepareQuery($sql);
        $this->db->bind(':settingKey', $setting);
        return $this->db->getResult()['setting_value'];
    }
}