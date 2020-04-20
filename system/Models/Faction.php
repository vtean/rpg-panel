<?php
/**
 * @brief The model for faction control.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Faction
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function getFactions()
    {
        $sql = "SELECT * FROM `sv_factions`";
        $this->db->prepareQuery($sql);
        return $this->db->getResults();
    }

    public function getFaction($factionId)
    {
        $sql = "SELECT * FROM `sv_factions` WHERE `ID`=:factionId";
        $this->db->prepareQuery($sql);
        $this->db->bind(':factionId', $factionId);
        return $this->db->getResult();
    }

    public function getUser($id)
    {
        $sql = "SELECT `NickName`, `Level`, `Admin`, `Leader`, `PlayedTime`, `Member`, `Rank`, `Warns`, `FWarns`, `Skin`, `TotalPlayed` FROM `sv_accounts` WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $result = $this->db->getResult();
        if (!empty($result)) {
            if ($result['Member'] != 0) {
                $result['faction_name'] = $this->getFaction($result['Member'])['Name'];
            }
        }
        return $result;
    }

    public function getFactionMembers($factionId)
    {
        $sql = "SELECT `NickName`, `Member`, `Rank`, `FWarns`, `Skin` FROM `sv_accounts` WHERE `Member`=:factionId";
        $this->db->prepareQuery($sql);
        $this->db->bind(':factionId', $factionId);
        return $this->db->getResults();
    }

    public function getFactionComplaints($factionId)
    {
        $sql = "SELECT * FROM `panel_fcomplaints` WHERE `faction_id`=:factionId";
        $this->db->prepareQuery($sql);
        $this->db->bind(':factionId', $factionId);
        $results = $this->db->getResults();
        $final_results = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['author_name'] = $this->getUser($result['author_id'])['NickName'];
                $result['against_name'] = $this->getUser($result['against_id'])['NickName'];
                array_push($final_results, $result);
            }
        }
        return $final_results;
    }

    public function postComplaint($data)
    {
        $sql = "INSERT INTO `panel_fcomplaints` (`description`, `author_id`, `author_ip`, `against_id`, `category_id`, `faction_id`, `status`) VALUES (:description, :author_id, :author_ip, :against_id, :category_id, :faction_id, :status)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':description', $data['complaint_desc']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':author_ip', $data['author_ip']);
        $this->db->bind(':against_id', $data['against_id']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':faction_id', $data['faction_id']);
        $this->db->bind(':status', $data['status']);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function getComplaint($id)
    {
        $sql = "SELECT * FROM `panel_fcomplaints` WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $result = $this->db->getResult();
        if (!empty($result)) {
            $result['author'] = $this->getUser($result['author_id']);
            $result['against_user'] = $this->getUser($result['against_id']);
            $result['category_name'] = 'Faction Complaint';
            if ($result['closed_by'] != 0) {
                $result['closed_by_name'] = $this->getUser($result['closed_by'])['NickName'];
            }
        }
        return $result;
    }

    public function editComplaint($data, $id)
    {
        $sql = "UPDATE `panel_fcomplaints` SET `description`=:description, `against_id`=:against_id, `is_edited`=:is_edited, `edit_ip`=:edit_ip, `edited_by`=:edited_by WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':description', $data['complaint_desc']);
        $this->db->bind(':against_id', $data['against_id']);
        $this->db->bind(':is_edited', $data['is_edited']);
        $this->db->bind(':edit_ip', $data['edit_ip']);
        $this->db->bind(':edited_by', $data['edited_by']);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function closeComplaint($data, $id)
    {
        $sql = "UPDATE `panel_fcomplaints` SET `status`=:status, `closed_by`=:closed_by WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':closed_by', $data['closed_by']);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteComplaint($id)
    {
        $sql = "DELETE FROM `panel_fcomplaints` WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function hideComplaint($isHidden, $id)
    {
        $sql = "UPDATE `panel_fcomplaints` SET `is_hidden`=:is_hidden WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':is_hidden', $isHidden);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function getComplaintReplies($id)
    {
        $sql = "SELECT * FROM `panel_fcreplies` WHERE `complaint_id`=:id ORDER BY `created_at` ASC";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $final_results = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['author_name'] = $this->getUser($result['author_id'])['NickName'];
                $result['author_skin'] = $this->getUser($result['author_id'])['Skin'];
                $result['admin_level'] = $this->getUser($result['author_id'])['Admin'];
                array_push($final_results, $result);
            }
        }
        return $final_results;
    }

    public function postReply($data)
    {
        $sql = "INSERT INTO `panel_fcreplies` (`complaint_id`, `body`, `author_id`, `author_ip`, `user_status`) VALUES (:complaint_id, :body, :author_id, :author_ip, :user_status)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':complaint_id', $data['complaint_id']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':author_ip', $data['author_ip']);
        $this->db->bind(':user_status', $data['user_status']);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteReply($id)
    {
        $sql = "DELETE FROM `panel_fcreplies` WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function getFactionApplications($factionId)
    {
        $sql = "SELECT * FROM `panel_faction_apps` WHERE `faction_id`=:factionId";
        $this->db->prepareQuery($sql);
        $this->db->bind(':factionId', $factionId);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['author_name'] = $this->getUser($result['author_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function getApplication($id)
    {
        $sql = "SELECT * FROM `panel_faction_apps` WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $result = $this->db->getResult();
        if (!empty($result)) {
            $result['author'] = $this->getUser($result['author_id']);
        }
        return $result;
    }

    public function postApplication($data)
    {
        $sql = "INSERT INTO `panel_faction_apps` (`body`, `author_id`, `faction_id`, `status`) VALUES (:body, :authorId, :factionId, :status)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':authorId', $data['author_id']);
        $this->db->bind(':factionId', $data['faction_id']);
        $this->db->bind(':status', $data['status']);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateAppStatus($data, $id)
    {
        $sql = "UPDATE `panel_faction_apps` SET `status`=:status, `updated_by`=:updatedBy WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':updatedBy', $data['updated_by']);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteApplication($id)
    {
        $sql = "DELETE FROM `panel_faction_apps` WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function userApplied($id)
    {
        $sql = "SELECT `id` FROM `panel_faction_apps` WHERE `author_id`=:id AND `status`=:appStatus";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':appStatus', 'Open');
        $this->db->executeStmt();
        if ($this->db->countRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addQuestion($data)
    {
        $sql = "INSERT INTO `panel_fapps_questions` (`faction_id`, `body`) VALUES (:factionId, :body)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':factionId', $data['faction_id']);
        $this->db->bind(':body', $data['question_body']);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function getFactionAppsQuestions($factionId)
    {
        $sql = "SELECT * FROM `panel_fapps_questions` WHERE `faction_id`=:factionId";
        $this->db->prepareQuery($sql);
        $this->db->bind(':factionId', $factionId);
        return $this->db->getResults();
    }

    public function deleteQuestion($id)
    {
        $sql = "DELETE FROM `panel_fapps_questions` WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function countFactionApps($factionId)
    {
        $sql = "SELECT `id` FROM `panel_fapps_questions` WHERE `faction_id`=:factionId";
        $this->db->prepareQuery($sql);
        $this->db->bind(':factionId', $factionId);
        $this->db->executeStmt();
        return $this->db->countRows();
    }

    public function getResignations($id)
    {
        $sql = "SELECT * FROM `panel_resignations` WHERE `faction_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['author_name'] = $this->getUser($result['author_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function getResignation($id)
    {
        $sql = "SELECT * FROM `panel_resignations` WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $result = $this->db->getResult();
        if (!empty($result)) {
            $result['author'] = $this->getUser($result['author_id']);
            if ($result['closed_by'] != 0) {
                $result['closed_by_name'] = $this->getUser($result['closed_by'])['NickName'];
            }
        }
        return $result;
    }

    public function userPostedResignation($user_id)
    {
        $sql = "SELECT `id` FROM `panel_resignations` WHERE `author_id`=:authorId AND `status`=:status";
        $this->db->prepareQuery($sql);
        $this->db->bind(':authorId', $user_id);
        $this->db->bind(':status', 'Open');
        $this->db->executeStmt();
        if ($this->db->countRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function postResignation($data)
    {
        $sql = "INSERT INTO `panel_resignations` (`body`, `author_id`, `author_ip`, `faction_id`, `status`) VALUES (:body, :author_id, :author_ip, :faction_id, :status)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':author_ip', $data['author_ip']);
        $this->db->bind(':faction_id', $data['faction_id']);
        $this->db->bind(':status', $data['status']);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateResignationStatus($data, $resignationId)
    {
        $sql = "UPDATE `panel_resignations` SET `status`=:status, `closed_by`=:closedBy WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':closedBy', $data['closed_by']);
        $this->db->bind(':id', $resignationId);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function userBanned($username)
    {
        $sql = "SELECT * FROM `sv_bannames` WHERE `Name`=:username";
        $this->db->prepareQuery($sql);
        $this->db->bind(':username', $username);
        $this->db->executeStmt();
        $result = $this->db->getResult();
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getResignationReplies($resignationId)
    {
        $sql = "SELECT * FROM `panel_resign_replies` WHERE `resignation_id`=:resignation_id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':resignation_id', $resignationId);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['author'] = $this->getUser($result['author_id']);
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function postResignationReply($data)
    {
        $sql = "INSERT INTO `panel_resign_replies` (`resignation_id`, `author_id`, `body`, `user_status`) VALUES (:resignationId, :authorId, :body, :userStatus)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':resignationId', $data['resignation_id']);
        $this->db->bind(':authorId', $data['author_id']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':userStatus', $data['user_status']);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteResignationReply($id)
    {
        $sql = "DELETE FROM `panel_resign_replies` WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }
}