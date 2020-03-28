<?php
/**
 * @brief The model for ticket control
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Ticket
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    // get category name
    public function getCategoryName($id)
    {
        $sql = "SELECT name FROM panel_categories WHERE id=:id";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':id', $id);
        // return result
        return $this->db->getResult();
    }

    // get author name
    public function getReplyAuthor($id)
    {
        $sql = "SELECT NickName, Skin FROM sv_accounts WHERE id=:id";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':id', $id);
        // return result
        return $this->db->getResult();
    }

    // get all tickets
    public function getAllTickets()
    {
        $sql = "SELECT * FROM panel_tickets";
        // prepare the query
        $this->db->prepareQuery($sql);
        // return result
        $results = $this->db->getResults();
        $final_results = array();
        foreach ($results as $result) {
            $result['category_name'] = $this->getCategoryName($result['category_id']);
            $result['author_name'] = $this->getReplyAuthor($result['author_id'])['NickName'];
            array_push($final_results, $result);
        }
        return $final_results;
    }

    // get ticket by id
    public function getTicket($id)
    {
        $sql = "SELECT * FROM panel_tickets WHERE id=:id";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':id', $id);
        // return result
        $result = $this->db->getResult();
        $result['category_name'] = $this->getCategoryName($result['category_id'])['name'];
        return $result;
    }

    // get user's tickets
    public function getUserTickets($id)
    {
        $sql = "SELECT * FROM panel_tickets WHERE author_id=:id";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':id', $id);
        // return result
        $results = $this->db->getResults();
        $final_results = array();
        foreach ($results as $result) {
            $result['category_name'] = $this->getCategoryName($result['category_id']);
            $result['author_name'] = $this->getReplyAuthor($result['author_id'])['NickName'];
            array_push($final_results, $result);
        }
        return $final_results;
    }

    // create ticket
    public function createTicket($data)
    {
        $sql = "INSERT INTO panel_tickets (body, author_id, author_ip, category_id, status) 
                VALUES (:body, :author_id, :author_ip, :category_id, :status)";
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':author_ip', $data['author_ip']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':status', 'Open');
        // execute query
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // edit ticket
    public function editTicket($data, $id)
    {
        $sql = "UPDATE panel_tickets SET body=:body, category_id=:category_id, is_edited=:is_edited, edit_ip=:edit_ip WHERE id=:id";
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':is_edited', '1');
        $this->db->bind(':edit_ip', $data['edit_ip']);
        $this->db->bind(':id', $id);
        // execute query
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // delete ticket
    public function deleteTicket($id)
    {
        $sql = "DELETE FROM panel_tickets WHERE id = :id";
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

    // update ticket's status
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE panel_tickets SET status=:status WHERE id = :id";
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        // execute query
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function createReply($data)
    {
        $sql = "INSERT INTO panel_treplies (ticket_id, body, author_id, author_ip, user_status) 
                VALUES (:ticket_id, :body, :author_id, :author_ip, :user_status)";
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':ticket_id', $data['ticket_id']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':author_ip', $data['author_id']);
        $this->db->bind(':user_status', $data['user_status']);
        // execute query
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function getReplies($id)
    {
        $sql = "SELECT * FROM panel_treplies WHERE ticket_id=:id ORDER BY created_at ASC";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':id', $id);
        // return result
        $results = $this->db->getResults();
        $final_results = array();
        foreach ($results as $result) {
            $result['author_name'] = $this->getReplyAuthor($result['author_id'])['NickName'];
            $result['author_avatar'] = $this->getReplyAuthor($result['author_id'])['Skin'];
            array_push($final_results, $result);
        }
        return $final_results;
    }

    public function countTickets()
    {
        $sql = "SELECT * FROM panel_tickets WHERE status=:status";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':status', 'Open');
        $this->db->getResults();
        return $this->db->countRows();
    }
}