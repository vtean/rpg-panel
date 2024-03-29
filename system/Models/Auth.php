<?php
/**
 * @brief The model for the auth system
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Auth
{
    private $db;
    private $ga;

    public function __construct()
    {
        $this->db = new Db();
        $this->ga = new GoogleAuthenticator();
    }

    public function createSecretCode()
    {
        return $this->ga->createSecret();
    }

    public function createQrCode($username, $secret)
    {
        return $this->ga->getQRCodeGoogleUrl($username, $secret, "DreamVibe");
    }

    public function createCode($secret)
    {
        return $this->ga->getCode($secret);
    }

    public function checkCode($secret, $code, $k=2)
    {
        return $this->ga->verifyCode($secret, $code, $k);
    }

    public function getUser($id)
    {
        $sql = "SELECT * FROM `sv_accounts` WHERE `ID`=:id";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':id', $id);
        // get the result
        $result = $this->db->getResult();
        // check if user exists
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // check for existing users with an username
    public function searchExistingUsername($username)
    {
        $sql = "SELECT * FROM `sv_accounts` WHERE `NickName`=:username";
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
        $sql = "SELECT * FROM `sv_accounts` WHERE `Mail`=:email";
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

    // login user
    public function loginUser($username, $password)
    {
        $sql = "SELECT * FROM `sv_accounts` WHERE `NickName`=:username";
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
        if (password_verify($password, $user_password)) {
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

        // add user skin to the session
        $_SESSION['user_skin'] = $user['Skin'];

        // clear things
        if (isset($_SESSION['sec_id'])) {
            unset($_SESSION['sec_id']);
        }

        if (isset($_SESSION['sec_pass'])) {
            unset($_SESSION['sec_pass']);
        }

        if (isset($_SESSION['sec_type'])) {
            unset($_SESSION['sec_type']);
        }

        if (isset($_SESSION['sec_code'])) {
            unset($_SESSION['sec_code']);
        }
    }

    // start the security session
    public function startSessionSecurity($user, $type, $pass) {
        // add user id to the session
        $_SESSION['sec_id'] = $user['ID'];

        $_SESSION['sec_type'] = $type;

        if ($type == 'email') {
            $sendCode = random_int(100000, 999999);
            $_SESSION['sec_code'] = $sendCode;
        }

        $_SESSION['sec_pass'] = $pass;

        redirect('/security');
    }

    // destroy the security session
    public function destroySecuritySession() {
        // unset user id
        unset($_SESSION['sec_id']);

        unset($_SESSION['sec_pass']);

        unset($_SESSION['sec_type']);

        unset($_SESSION['sec_code']);

        session_destroy();
    }
}