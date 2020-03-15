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

    public function checkFullAccess($username)
    {
        $sql = "SELECT FullDostup1 FROM fulldostup WHERE FullDostup1=:username";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':username', $username);
        // get the result
        $this->db->getResult();
        if ($this->db->countRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkAdmin($username)
    {
        $sql = "SELECT * FROM accounts WHERE NickName=:username";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':username', $username);
        // get the result
        $result = $this->db->getResult();
        $admin = $result['Admin'];
        if ($this->db->countRows() > 0) {
            return $admin;
        } else {
            return false;
        }
    }

    public function checkHelper($username)
    {
        $sql = "SELECT * FROM accounts WHERE NickName=:username";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':username', $username);
        // get the result
        $result = $this->db->getResult();
        $helper = $result['Helper'];
        if ($this->db->countRows() > 0) {
            return $helper;
        } else {
            return false;
        }
    }

    public function checkLeader($username)
    {
        $sql = "SELECT * FROM accounts WHERE NickName=:username";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':username', $username);
        // get the result
        $result = $this->db->getResult();
        $leader = $result['Leader'];
        if ($this->db->countRows() > 0) {
            return $leader;
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

        // add user email to the session
        $_SESSION['user_email'] = $user['Mail'];

        // check and add owner access to the session
        if ($this->checkFullAccess($user['NickName'])) {
            $_SESSION['isBigBoss'] = true;
        }

        // check and add admin access to the session
        if ($this->checkAdmin($user['NickName']) > 0) {
            $_SESSION['isAdmin'] = true;
        }

        // check and add helper access to the session
        if ($this->checkHelper($user['NickName']) > 0) {
            $_SESSION['isHelper'] = true;
        }

        // check and add leader access to the session
        if ($this->checkLeader($user['NickName']) > 0) {
            $_SESSION['isLeader'] = true;
        }

        // redirect user to the main page
        redirect('/');
    }
}