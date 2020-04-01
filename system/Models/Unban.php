<?php
/**
 * @brief The model for unban requests control.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Unban
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    // get user name
    public function getUser($id)
    {
        $sql = "SELECT `NickName`, `Admin`, `Skin` FROM `sv_accounts` WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        return $this->db->getResult();
    }

    // check if user is banned
    public function getBannedUser($id)
    {
        $sql = "SELECT * FROM `sv_bannames` WHERE `Name`=:username";
        $username = $this->getUser($id)['NickName'];
        $this->db->prepareQuery($sql);
        $this->db->bind(':username', $username);
        $result = $this->db->getResult();
        $result['admin_name'] = $this->getUser($result['BanAdmin'])['NickName'];
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // get all unban requests
    public function getAllUnbanRequests()
    {
        $sql = "SELECT * FROM `panel_unbans`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $final_results = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['author_name'] = $this->getUser($result['author_id'])['NickName'];
                $result['admin_name'] = $this->getUser($result['banned_by'])['NickName'];
                array_push($final_results, $result);
            }
        }
        return $final_results;
    }

    // get user unban requests
    public function getUserUnbanRequests($id)
    {
        $sql = "SELECT * FROM `panel_unbans` WHERE `author_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $final_results = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['author_name'] = $this->getUser($result['author_id'])['NickName'];
                $result['admin_name'] = $this->getUser($result['banned_by'])['NickName'];
                array_push($final_results, $result);
            }
        }
        return $final_results;
    }

    // check if user has already an opened unban request
    public function hasOpenUnbanRequest($id)
    {
        $sql = "SELECT * FROM `panel_unbans` WHERE `author_id`=:author_id AND NOT `status`=:status";
        $this->db->prepareQuery($sql);
        $this->db->bind(':author_id', $id);
        $this->db->bind(':status', 'Closed');
        $this->db->executeStmt();
        if ($this->db->countRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // post new unban request
    public function postUnbanRequest($data)
    {
        $sql = "INSERT INTO `panel_unbans` (`description`, `author_id`, `author_ip`, `banned_by`, `ban_reason`, `ban_time`, `status`) VALUES (:description, :author_id, :author_ip, :banned_by, :ban_reason, :ban_time, :status)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':author_ip', $data['author_ip']);
        $this->db->bind(':banned_by', $data['banned_by']);
        $this->db->bind(':ban_reason', $data['ban_reason']);
        $this->db->bind(':ban_time', $data['ban_time']);
        $this->db->bind(':status', $data['status']);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // get single unban request
    public function getUnban($id)
    {
        $sql = "SELECT * FROM `panel_unbans` WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $result = $this->db->getResult();
        if (!empty($result)) {
            $result['author_name'] = $this->getUser($result['author_id'])['NickName'];
            $result['admin_name'] = $this->getUser($result['banned_by'])['NickName'];
        }
        return $result;
    }

    // get unban replies
    public function getUnbanReplies($id)
    {
        $sql = "SELECT * FROM `panel_ureplies` WHERE `unban_request_id`=:id ORDER BY `created_at` ASC";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $final_results = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['author_name'] = $this->getUser($result['author_id'])['NickName'];
                $result['author_avatar'] = $this->getUser($result['author_id'])['Skin'];
                $result['admin_level'] = $this->getUser($result['author_id'])['Admin'];
                array_push($final_results, $result);
            }
        }
        return $final_results;
    }

    // post new reply
    public function postUnbanReply($data)
    {
        $sql = "INSERT INTO `panel_ureplies` (`unban_request_id`, `body`, `author_id`, `author_ip`) VALUES (:req_id, :body, :author_id, :author_ip)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':req_id', $data['unban_request_id']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':author_ip', $data['author_ip']);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }
}