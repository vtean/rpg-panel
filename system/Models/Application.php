<?php
/**
 * @brief The model for applications control.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Application
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function getUserInfo($id)
    {
        $sql = "SELECT `NickName`, `Level`, `Member`, `Rank`, `Warns`, `Skin`, `BlackList`, `ZKP`, `PlayedTime`, `TotalPlayed` FROM `sv_accounts` WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $result = $this->db->getResult();
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getFactionInfo($id)
    {
        $sql = "SELECT `Name`, `Leader` FROM `sv_factions` WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        return $this->db->getResult();
    }

    public function getUserFH($id)
    {
        $sql = "SELECT * FROM `sv_faction_history` WHERE `player_id`=:id ORDER BY `date` DESC";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        return $this->db->getResults();
    }

    public function factionsWithoutLeader()
    {
        $sql = "SELECT `ID`, `Name` FROM `sv_factions` WHERE `Leader`=:leaderName";
        $this->db->prepareQuery($sql);
        $this->db->bind(':leaderName', 'None');
        return $this->db->getResults();
    }

    public function alreadyApplied($id, $appType, $extra)
    {
        $sql = "SELECT * FROM `panel_apps` WHERE `author_id`=:id AND `type`=:appType AND `extra`=:extra";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':appType', $appType);
        $this->db->bind(':extra', $extra);
        $this->db->executeStmt();
        if ($this->db->countRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function createApplication($data)
    {
        $sql = "INSERT INTO `panel_apps` (`body`, `author_id`, `author_ip`, `type`, `extra`) VALUES (:body, :author_id, :author_ip, :appType, :extra)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':author_ip', $data['author_ip']);
        $this->db->bind('appType', $data['type']);
        $this->db->bind(':extra', $data['extra']);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllApps($appType)
    {
        $sql = "SELECT * FROM `panel_apps` WHERE `type`=:appType";
        $this->db->prepareQuery($sql);
        $this->db->bind(':appType', $appType);
        $results = $this->db->getResults();
        $final_results = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['author_name'] = $this->getUserInfo($result['author_id'])['NickName'];
                $result['played_time'] = $this->getUserInfo($result['author_id'])['PlayedTime'];
                array_push($final_results, $result);
            }
        }
        return $final_results;
    }

    public function getUserApps($id, $appType)
    {
        $sql = "SELECT * FROM `panel_apps` WHERE `type`=:appType AND `author_id`=:author_id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':appType', $appType);
        $this->db->bind(':author_id', $id);
        $results = $this->db->getResults();
        $final_results = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['author_name'] = $this->getUserInfo($result['author_id'])['NickName'];
                $result['played_time'] = $this->getUserInfo($result['author_id'])['PlayedTime'];
                array_push($final_results, $result);
            }
        }
        return $final_results;
    }

    public function getApplication($id)
    {
        $sql = "SELECT * FROM `panel_apps` WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $result = $this->db->getResult();
        if ($this->db->countRows() > 0) {
            $result['account_details'] = $this->getUserInfo($result['author_id']);
            if ($result['account_details']['Member'] != 0) {
                $result['account_details']['faction_name'] = $this->getFactionInfo($result['account_details']['Member'])['Name'];
            }
            return $result;
        } else {
            return false;
        }
    }

    public function editApplication($postData, $id)
    {
        $sql = "UPDATE `panel_apps` SET `body`=:body, `is_edited`=:isEdited, `edited_by`=:editedBy WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':body', $postData['body']);
        $this->db->bind(':isEdited', $postData['isEdited']);
        $this->db->bind(':editedBy', $postData['editedBy']);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteApplication($id)
    {
        $sql = "DELETE FROM `panel_apps` WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }
}