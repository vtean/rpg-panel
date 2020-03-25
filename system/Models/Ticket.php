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
            array_push($final_results, $result);
        }
        return $final_results;
    }

    // create ticket
    public function createTicket($data)
    {
        $sql = "INSERT INTO panel_tickets (body, author_id, author_name, author_ip, category_id, status) 
                VALUES (:body, :author_id, :author_name, :author_ip, :category_id, :status)";
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':author_name', $data['author_name']);
        $this->db->bind(':author_ip', $data['author_ip']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':status', 'Active');
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
        $sql = "UPDATE panel_tickets SET body:body, category_id:category_id WHERE id=:id";
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':id', $id);
        // execute query
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }


}