<?php
/**
 * @brief The model for category control
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Category
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    // get all categories
    public function getAllCategories($type)
    {
        $sql = "SELECT * FROM panel_categories WHERE type=:type";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':type', $type);
        // return result
        return $this->db->getResults();
    }

    // create category
    public function createCategory($data)
    {
        $sql = "INSERT INTO panel_categories ('name', 'type') 
                VALUES (':name', ':type')";
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':type', $data['type']);
        // execute query
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // edit category
    public function editCategory($data, $id)
    {
        $sql = "UPDATE panel_categories SET name:name, type:type WHERE id=:id";
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':id', $id);
        // execute query
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }


}