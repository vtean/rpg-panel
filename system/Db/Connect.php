<?php
/**
 * @brief Create the connection to the database
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Connect
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $dbName = DB_NAME;
    private $pass = DB_PASS;
    protected $dbh;
    protected $stmt;
    private $error;

    public function __construct()
    {
        // set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
        $options = array(
            PDO::ATTR_PERSISTENT => true, // check if there is already a connection established with the database
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // the way to handle errors
        );

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }
}