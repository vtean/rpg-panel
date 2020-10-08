<?php
/**
 * @brief The model for user control
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function searchExistingUser($nickname)
    {
        $sql = "SELECT * FROM `sv_accounts` WHERE `NickName`=:user_nick";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':user_nick', $nickname);
        // get the result
        $result = $this->db->getResult();
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function searchUserById($user_id)
    {
        $sql = "SELECT * FROM `sv_accounts` WHERE `ID`=:user_id";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':user_id', $user_id);
        // get the result
        $result = $this->db->getResult();
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getFaction($factionId)
    {
        $sql = "SELECT `Name` FROM `sv_factions` WHERE `ID`=:factionId";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':factionId', $factionId);
        // get the result
        $result = $this->db->getResult();
        if ($this->db->countRows() > 0) {
            return $result['Name'];
        } else {
            return 'No Faction';
        }
    }

    public function getJob($jobId)
    {
        $sql = "SELECT * FROM `sv_jobs` WHERE `ID`=:jobId";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':jobId', $jobId);
        // get the result
        $result = $this->db->getResult();
        if ($this->db->countRows() > 0) {
            return $result['name'];
        } else {
            return 'Unemployed';
        }
    }

    public function getFamily($familyId)
    {
        $sql = "SELECT * FROM `sv_families` WHERE `ID`=:familyId";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':familyId', $familyId);
        // get the result
        $result = $this->db->getResult();
        if ($this->db->countRows() > 0) {
            return $result['name'];
        } else {
            return 'No Family';
        }
    }

    public function getFactionRank($factionId, $rankId)
    {
        if ($rankId == 0) return false;
        $sql = "SELECT `Rank_$rankId` FROM `sv_factions` WHERE `ID`=:factionId";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':factionId', $factionId);
        // get the result
        $result = $this->db->getResult();
        $rank = $result["Rank_" . $rankId];
        if ($this->db->countRows() > 0) {
            return $rank;
        } else {
            return false;
        }
    }

    public function getVehicle($nickName)
    {
        $sql = "SELECT * FROM `sv_vehicles` WHERE `Owner`=:nickname";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':nickname', $nickName);
        // get the result
        $result = $this->db->getResults();
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getModelName($nickName)
    {
        $sql = "SELECT * FROM `sv_vehicles` JOIN `sv_modellimit` ON sv_vehicles.Model = sv_modellimit.Model WHERE sv_vehicles.Owner=:nickname";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':nickname', $nickName);
        // get the result
        $result = $this->db->getResults();
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getBusiness($nickName)
    {
        $sql = "SELECT * FROM `sv_businesses` WHERE `Owner`=:nickname";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':nickname', $nickName);
        // get the result
        $result = $this->db->getResults();
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getHouse($nickName)
    {
        $sql = "SELECT * FROM `sv_houses` WHERE `Owner`=:nickname";
        // prepare the query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':nickname', $nickName);
        // get the result
        $result = $this->db->getResults();
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // get user groups
    public function getUserGroups($username)
    {
        $sql = "SELECT `PanelGroups` FROM `sv_accounts` WHERE `NickName`=:nickname";
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':nickname', $username);
        // return result
        $result = $this->db->getResult();
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    // get user group name
    public function getUserGroupName($id)
    {
        $sql = "SELECT `group_name`, `group_keyword` FROM `panel_groups` WHERE `group_id`=:id";
        // prepare query
        $this->db->prepareQuery($sql);
        // bind params
        $this->db->bind(':id', $id);
        // return result
        return $this->db->getResult();
    }

    // update user email
    public function updateUserEmail($id, $email)
    {
        $sql = "UPDATE `sv_accounts` SET `Mail`=:email WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':email', $email);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // update user forum name
    public function updateForumName($id, $name)
    {
        $sql = "UPDATE `sv_accounts` SET `ForumName`=:forumName WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':forumName', $name);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // change user password
    public function updateUserPassword($id, $password)
    {
        $sql = "UPDATE `sv_accounts` SET `Password`=:password WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':password', $password);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // activate email login
    public function changeEmailLogin($id, $state)
    {
        $sql = "UPDATE `sv_accounts` SET `MailLogin`=:mailValue WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':mailValue', $state);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // enable google authenticator
    public function enableGAuth($id, $secretCode)
    {
        $sql = "UPDATE `sv_accounts` SET `GoogleCode`=:secretCode, `GoogleStatus`=:gStatus WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':secretCode', $secretCode);
        $this->db->bind(':gStatus', 1);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // disable google authenticator
    public function disableGAuth($id)
    {
        $sql = "UPDATE `sv_accounts` SET `GoogleCode`=:secretCode, `GoogleStatus`=:gStatus WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':secretCode', 'None');
        $this->db->bind(':gStatus', 0);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // get user fh
    public function getUserFH($id)
    {
        $sql = "SELECT * FROM `sv_faction_history` WHERE `player_id`=:id ORDER BY `date` DESC";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        return $this->db->getResults();
    }

    // suspend user
    public function suspendUser($data)
    {
        $sql = "INSERT INTO `panel_suspended_users` (`user_id`, `suspended_until`, `reason`, `suspended_by`) VALUES (:user_id, :suspended_until, :reason, :suspended_by)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':suspended_until', $data['suspended_until']);
        $this->db->bind(':reason', $data['reason']);
        $this->db->bind(':suspended_by', $data['suspended_by']);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // unsuspend user
    public function unsuspendUser($id)
    {
        $sql = "DELETE FROM `panel_suspended_users` WHERE `user_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    // check if user is suspended
    public function suspendedUser($id)
    {
        $sql = "SELECT * FROM `panel_suspended_users` WHERE `user_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $result = $this->db->getResult();
        if ($this->db->countRows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
}