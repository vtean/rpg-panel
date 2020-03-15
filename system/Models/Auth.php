<?php
/**
 * @brief The model for the register system
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Auth
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    // check for existing users with an username
    public function searchExistingUsername($username)
    {
        $sql = "SELECT * FROM accounts WHERE NickName=:username";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':username', $username);
        // get the result
        $result = $this->db->getResult();
        // check if user exists
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // check for existing users with an email
    public function searchExistingEmail($email)
    {
        $sql = "SELECT * FROM accounts WHERE Mail=:email";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':email', $email);
        // get the result
        $result = $this->db->getResult();
        // check if user exists
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // check user group
//    public function checkGroup($group_id)
//    {
//        $sql = "SELECT * FROM groups WHERE group_id=:group_id";
//        // prepare query
//        $this->db->prepareQuery($sql);
//        // bind params
//        $this->db->bind(':group_id', $group_id);
//        // execute query
//        $this->db->executeStmt();
//        // return result
//        return $this->db->getResult();
//    }


    // login user
    public function loginUser($username, $password)
    {
        $sql = "SELECT * FROM accounts WHERE NickName=:username";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':username', $username);
        // execute query
        $this->db->executeStmt();
        // return the result
        $result = $this->db->getResult();
        // assign user password to a variable
        $user_password = $result['Password'];
        // check if the entered password and the one from database match
        if (strcasecmp($password, $user_password) == 0) {
            return $result;
        } else {
            return false;
        }
    }

    // start the session
    public function startSession($user) {
        // add user id to the session
        $_SESSION['user_id'] = $user['ID'];

        // add user name to the session
        $_SESSION['user_name'] = $user['NickName'];

        // redirect user to the main page
        redirect('/');
    }
}