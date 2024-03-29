<?php
/**
 * @brief The model for groups control
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Group
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    // get all groups
    public function getAllGroups()
    {
        $sql = "SELECT * FROM `panel_groups`";
        // prepare the query
        $this->db->prepareQuery($sql);
        // return result
        return $this->db->getResults();
    }

    // get group by user id
    public function getSingleGroup($id)
    {
        $sql = "SELECT * FROM `panel_groups` WHERE `group_id`=:group_id";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':group_id', $id);
        // return result
        return $this->db->getResult();
    }

    // search for existing group
    public function searchExistingGroup($name)
    {
        $sql = "SELECT * FROM `panel_groups` WHERE `group_name`=:group_name";
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':group_name', $name);
        // get the result
        $result = $this->db->getResult();
        // check if group exists
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // create group
    public function createGroup($data)
    {
        $sql = "INSERT INTO `panel_groups` (";
        $i = 0;
        foreach ($data as $key => $value) {
            if ($i == 0) {
                $sql = $sql . "$key";
            } else {
                $sql = $sql . ", $key";
            }
            $i++;
        }
        $sql = $sql . ') VALUES (';
        $j = 0;
        foreach ($data as $key => $value) {
            if ($j == 0) {
                $sql = $sql . ":$key";
            } else {
                $sql = $sql . ", :$key";
            }
            $j++;
        }
        $sql = $sql . ')';
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        foreach ($data as $key => $value) {
            $this->db->bind(":$key", $value);
        }
        // execute query
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // edit group
    public function editGroup($data, $id)
    {
        $sql = "UPDATE `panel_groups` SET ";
        $i = 0;
        foreach ($data as $key => $value) {
            if ($i == 0) {
                $sql = $sql . "$key=:$key";
            } else {
                $sql = $sql . ", $key=:$key";
            }
            $i++;
        }
        $sql = $sql . " WHERE group_id=:id";
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        foreach ($data as $key => $value) {
            $this->db->bind(":$key", $value);
        }
        $this->db->bind(':id', $id);
        // execute query
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // delete group
    public function deleteGroup($id)
    {
        $sql = "DELETE FROM `panel_groups` WHERE `group_id`=:id";
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':id', $id);
        // execute query
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // assign groups
    public function assignGroups($groups, $username)
    {
        $sql = "UPDATE `sv_accounts` SET `PanelGroups`=:groups WHERE `NickName`=:username";
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':groups', $groups);
        $this->db->bind(':username', $username);
        // execute query
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }
}