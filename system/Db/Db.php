<?php
/**
 * @brief Database queries
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Db extends Connect
{
    // prepare statement with query
    public function prepareQuery($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // bind values
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    // execute the prepared statement
    public function executeStmt()
    {
        return $this->stmt->execute();
    }

    // get multiple results as an array of objects
    public function getResults()
    {
        $this->executeStmt();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get a single result
    public function getResult()
    {
        $this->executeStmt();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    // get row count
    public function countRows()
    {
        return $this->stmt->rowCount();
    }
}