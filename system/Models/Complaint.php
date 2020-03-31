<?php
/**
 * @brief The model for complaint control
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Complaint
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function getUser($id)
    {
        $sql = "SELECT `NickName`, `Level`, `PlayedTime`, `Member`, `Skin`, `Warns` FROM `sv_accounts` WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
       return $this->db->getResult();
    }

    public function getCategoryName($id)
    {
        $sql = "SELECT `name` FROM `panel_categories` WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        return $this->db->getResult();
    }

    public function getAllComplaints()
    {
        $sql = "SELECT * FROM `panel_complaints`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $final_results = array();
        foreach ($results as $result) {
            $result['author_name'] = $this->getUser($result['author_id'])['NickName'];
            $result['against_name'] = $this->getUser($result['against_id'])['NickName'];
            $result['category_name'] = $this->getCategoryName($result['category_id'])['name'];
            array_push($final_results, $result);
        }
        return $final_results;
    }

    public function getUnhiddenComplaints()
    {
        $sql = "SELECT * FROM `panel_complaints` WHERE `is_hidden`=0";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $final_results = array();
        foreach ($results as $result) {
            $result['author_name'] = $this->getUser($result['author_id'])['NickName'];
            $result['against_name'] = $this->getUser($result['against_id'])['NickName'];
            $result['category_name'] = $this->getCategoryName($result['category_id'])['name'];
            array_push($final_results, $result);
        }
        return $final_results;
    }

    public function getComplaintReplies($id)
    {
        $sql = "SELECT * FROM `panel_creplies` WHERE `complaint_id`=:id ORDER BY `created_at` ASC";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        return $this->db->getResults();
    }

    public function getComplaint($id)
    {
        $sql = "SELECT * FROM `panel_complaints` WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $result = $this->db->getResult();
        if ($result) {
            $result['author'] = $this->getUser($result['author_id']);
            $result['against_user'] = $this->getUser($result['against_id']);
            $result['category_name'] = $this->getCategoryName($result['category_id'])['name'];
            $replies = $this->getComplaintReplies($id);
            if (!empty($replies)) {
                $final_replies = array();
                foreach ($replies as $reply) {
                    $reply['author_name'] = $this->getUser($reply['author_id'])['NickName'];
                    $reply['author_skin'] = $this->getUser($reply['author_id'])['Skin'];
                    array_push($final_replies, $reply);
                }
                $result['replies'] = $final_replies;
            } else {
                $result['replies'] = $replies;
            }
            if ($result['closed_by'] != 0) {
                $result['closed_by_name'] = $this->getUser($result['closed_by'])['NickName'];
            }
            return $result;
        } else {
            return false;
        }
    }

    public function postComplaint($data)
    {
        $sql = "INSERT INTO `panel_complaints` (`description`, `proof`, `other_info`, `author_id`, `author_ip`, `against_id`, `category_id`, `status`, `is_hidden`) VALUES (:description, :proof, :other_info, :author_id, :author_ip, :against_id, :category_id, :status, :is_hidden)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':description', $data['complaint_desc']);
        $this->db->bind(':proof', $data['complaint_proof']);
        $this->db->bind(':other_info', $data['other_info']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':author_ip', $data['author_ip']);
        $this->db->bind(':against_id', $data['against_id']);
        $this->db->bind(':category_id', $data['complaint_category']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':is_hidden', $data['is_hidden']);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function editComplaint($data, $id)
    {
        $sql = "UPDATE `panel_complaints` SET `description`=:description, `proof`=:proof, `other_info`=:other_info, `against_id`=:against_id, `category_id`=:category_id, `is_edited`=:is_edited, `edit_ip`=:edit_ip, `edited_by`=:edited_by WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':description', $data['complaint_desc']);
        $this->db->bind(':proof', $data['complaint_proof']);
        $this->db->bind(':other_info', $data['other_info']);
        $this->db->bind(':against_id', $data['against_id']);
        $this->db->bind(':category_id', $data['complaint_category']);
        $this->db->bind(':is_edited', $data['is_edited']);
        $this->db->bind(':edit_ip', $data['edit_ip']);
        $this->db->bind(':edited_by',$data['edited_by']);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function postReply($data)
    {
        $sql = "INSERT INTO `panel_creplies` (`complaint_id`, `body`, `author_id`, `author_ip`, `user_status`) VALUES (:complaint_id, :body, :author_id, :author_ip, :user_status)";
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

    public function closeComplaint($data, $id)
    {
        $sql = "UPDATE `panel_complaints` SET `status`=:status, `closed_by`=:closed_by WHERE `id`=:id";
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
        $sql = "DELETE FROM `panel_complaints` WHERE `id`=:id";
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
        $sql = "UPDATE `panel_complaints` SET `is_hidden`=:is_hidden WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':is_hidden', $isHidden);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function changeCategory($cID, $id)
    {
        $sql = "UPDATE `panel_complaints` SET `category_id`=:cat_id WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':cat_id', $cID);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteReply($id)
    {
        $sql = "DELETE FROM `panel_creplies` WHERE `id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }
}