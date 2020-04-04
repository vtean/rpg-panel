<?php
/**
 * @brief The model for applications control.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class App
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
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
}