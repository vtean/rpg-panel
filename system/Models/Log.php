<?php
/**
 * @brief The model for logs page.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Log
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function playerLog($data)
    {
        $sql = "INSERT INTO `panel_logs_player` (`user_id`, `type`, `action`, `ip_address`) VALUES (:user_id, :log_type, :log_action, :ip_address)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $this->db->bind(':log_type', $data['type']);
        $this->db->bind(':log_action', $data['action']);
        $this->db->bind(':ip_address', getUserIp());
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function adminLog($data)
    {
        $sql = "INSERT INTO `panel_logs_admin` (`user_id`, `type`, `action`, `ip_address`) VALUES (:user_id, :log_type, :log_action, :ip_address)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $this->db->bind(':log_type', $data['type']);
        $this->db->bind(':log_action', $data['action']);
        $this->db->bind(':ip_address', getUserIp());
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function leaderLog($data)
    {
        $sql = "INSERT INTO `panel_logs_leader` (`user_id`, `type`, `action`, `ip_address`) VALUES (:user_id, :log_type, :log_action, :ip_address)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $this->db->bind(':log_type', $data['type']);
        $this->db->bind(':log_action', $data['action']);
        $this->db->bind(':ip_address', getUserIp());
        if ($this->db->executeStmt()) {
            return true;
        } else {
            return false;
        }
    }

    public function loginLog($id)
    {
        $sql = "INSERT INTO `panel_logs_login` (`user_id`, `login_ip`, `location`) VALUES (:user_id, :login_ip, :location)";
        $this->db->prepareQuery($sql);
        $this->db->bind(':user_id', $id);
        $this->db->bind(':login_ip', getUserIp());
        $this->db->bind(':location', getUserLocation(getUserIp()));
        $this->db->executeStmt();
    }

    public function getUserName($id)
    {
        $sql = "SELECT `NickName` FROM `sv_accounts` WHERE `ID`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        return $this->db->getResult();
    }

    public function panelAdminLogs()
    {
        $sql = "SELECT * FROM `panel_logs_admin`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                if ($result['user_id'] == 0) {
                    $result['user_name'] = 'Unknown';
                } else {
                    $result['user_name'] = $this->getUserName($result['user_id'])['NickName'];
                }
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function panelLeaderLogs()
    {
        $sql = "SELECT * FROM `panel_logs_leader`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                if ($result['user_id'] == 0) {
                    $result['user_name'] = 'Unknown';
                } else {
                    $result['user_name'] = $this->getUserName($result['user_id'])['NickName'];
                }
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function panelPlayerLogs()
    {
        $sql = "SELECT * FROM `panel_logs_player`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                if ($result['user_id'] == 0) {
                    $result['user_name'] = 'Unknown';
                } else {
                    $result['user_name'] = $this->getUserName($result['user_id'])['NickName'];
                }
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function panelLoginLogs()
    {
        $sql = "SELECT * FROM `panel_logs_login`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                if ($result['user_id'] == 0) {
                    $result['user_name'] = 'Unknown';
                } else {
                    $result['user_name'] = $this->getUserName($result['user_id'])['NickName'];
                }
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function pAdminLogs($id)
    {
        $sql = "SELECT * FROM `panel_logs_admin` WHERE `user_id`=:user_id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':user_id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                if ($result['user_id'] == 0) {
                    $result['user_name'] = 'Unknown';
                } else {
                    $result['user_name'] = $this->getUserName($result['user_id'])['NickName'];
                }
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function pLeaderLogs($id)
    {
        $sql = "SELECT * FROM `panel_logs_leader` WHERE `user_id`=:user_id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':user_id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                if ($result['user_id'] == 0) {
                    $result['user_name'] = 'Unknown';
                } else {
                    $result['user_name'] = $this->getUserName($result['user_id'])['NickName'];
                }
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function pPlayerLogs($id)
    {
        $sql = "SELECT * FROM `panel_logs_player` WHERE `user_id`=:user_id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':user_id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                if ($result['user_id'] == 0) {
                    $result['user_name'] = 'Unknown';
                } else {
                    $result['user_name'] = $this->getUserName($result['user_id'])['NickName'];
                }
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function pLoginLogs($id)
    {
        $sql = "SELECT * FROM `panel_logs_login` WHERE `user_id`=:user_id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':user_id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                if ($result['user_id'] == 0) {
                    $result['user_name'] = 'Unknown';
                } else {
                    $result['user_name'] = $this->getUserName($result['user_id'])['NickName'];
                }
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function allLogs()
    {
        $sql = "SELECT * FROM `sv_logs_all`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                if ($result['player_id'] == 0) {
                    $result['player'] = 'Unknown';
                } else {
                    $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                }
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function adminLogs()
    {
        $sql = "SELECT * FROM `sv_logs_admin`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['admin'] = $this->getUserName($result['admin_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function anticheatLogs()
    {
        $sql = "SELECT * FROM `sv_logs_anticheat`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function chatLogs()
    {
        $sql = "SELECT * FROM `sv_logs_chat`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function businessLogs()
    {
        $sql = "SELECT * FROM `sv_logs_biz`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function houseLogs()
    {
        $sql = "SELECT * FROM `sv_logs_house`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function carLogs()
    {
        $sql = "SELECT * FROM `sv_logs_car`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function moneyLogs()
    {
        $sql = "SELECT * FROM `sv_logs_money`";
        $this->db->prepareQuery($sql);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerAllLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_all` WHERE `player_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerAdminLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_admin` WHERE `admin_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['admin'] = $this->getUserName($result['admin_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerAnticheatLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_anticheat` WHERE `player_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerChatLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_chat` WHERE `player_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerBusinessLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_biz` WHERE `player_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerHouseLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_house` WHERE `player_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerCarLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_car` WHERE `player_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }

    public function playerMoneyLogs($id)
    {
        $sql = "SELECT * FROM `sv_logs_money` WHERE `player_id`=:id";
        $this->db->prepareQuery($sql);
        $this->db->bind(':id', $id);
        $results = $this->db->getResults();
        $finalResults = array();
        if (!empty($results)) {
            foreach ($results as $result) {
                $result['player'] = $this->getUserName($result['player_id'])['NickName'];
                array_push($finalResults, $result);
            }
        }
        return $finalResults;
    }
}