<?php
/**
 * @brief The main controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Controller
{
    private $bigBossModel;
    private $suspendInfo;
    private $maintenanceInfo;
    protected $privileges;

    public function __construct()
    {
        // load model
        $this->bigBossModel = $this->loadModel('General');

        // store user privileges
        $this->privileges = $this->checkPrivileges();

        // check for suspend
        $this->suspendInfo = $this->checkSuspend();

        if ($this->suspendInfo != false) {
            $suspendedUser = $this->bigBossModel->getSuspendedUser($_SESSION['user_id']);
            if (!empty($suspendedUser)) {
                $unsuspendDate = date('Y-m-d H:i:s', $suspendedUser['suspended_until']);
                $suspendedByName = $this->bigBossModel->getUserNickname($suspendedUser['suspended_by']);

                $suspendData = [
                    'pageTitle' => 'Suspended',
                    'suspendedUser' => $suspendedUser,
                    'unsuspendDate' => $unsuspendDate,
                    'suspendedByName' => $suspendedByName
                ];

                // load page
                $this->loadPage('suspended', $suspendData);
                exit;
            }
        }

        // maintenance check
        $this->maintenanceInfo = $this->checkMaintenance();

        if ($this->maintenanceInfo == true && (!isLoggedIn() || $this->privileges['fullAccess'] == false)) {
            $maintenanceMessage = html_entity_decode($this->bigBossModel->getSettingValue('maintenance_message'));

            $maintenanceData = [
                'pageTitle' => 'Panel Maintenance',
                'maintenanceMessage' => $maintenanceMessage
            ];

            // load page
            $this->loadPage('maintenance', $maintenanceData);
            exit;
        }
    }

    // load model
    public function loadModel($modelName)
    {
        // make the first letter to be uppercase if not
        $modelName = ucfirst($modelName);

        // check if model exists
        if (file_exists(ROOT_PATH . '/system/Models/' . $modelName . '.php')) {
            // require the model file
            require_once ROOT_PATH . '/system/Models/' . $modelName . '.php';

            // initiate the model
            return new $modelName();
        } else {
            die('Model ' . $modelName . ' cannot be found');
        }
    }

    // load view
    public function loadView($viewName, $data = [], $errors = [])
    {
        // check if view exists
        if (file_exists(ROOT_PATH . '/public/views/' . $viewName . '.php')) {
            // add privileges to the array
            $data['privileges'] = $this->privileges;
            // add language to the array
            $data['lang'] = siteLang();
            // add badges to the array
            $data['badges'] = $this->badges();
            // load header
            getHeader($data);
            // load flash message
            flashMessage();
            // load the view file
            require_once ROOT_PATH . '/public/views/' . $viewName . '.php';
            // load footer
            getFooter();
        } else {
            die('View ' . $viewName . ' does not exist');
        }
    }

    // load page
    public function loadPage($pageName, $data = [])
    {
        // check if page exists
        if (file_exists(ROOT_PATH . '/public/views/' . $pageName . '.php')) {
            // load file
            require_once ROOT_PATH . '/public/views/' . $pageName . '.php';
        } else {
            die('File ' . $pageName . ' does not exist');
        }
    }

    // error handling
    public function error($code, $msg)
    {
        // check if view exists
        if (file_exists(ROOT_PATH . '/public/views/exception.php')) {
            // load the exception file
            require_once ROOT_PATH . '/public/views/exception.php';
        }
    }

    // get badges
    public function badges()
    {
        $ticketBadge = $this->bigBossModel->countTickets('Open');
        $complaintBadge = $this->bigBossModel->countComplaints('Open');
        $unbanBadge = $this->bigBossModel->countUnbans('Open');

        return [
            'ticketBadge' => $ticketBadge,
            'complaintBadge' => $complaintBadge,
            'unbanBadge' => $unbanBadge
        ];
    }

    // check for suspend
    protected function checkSuspend()
    {
        // check if user is logged in
        if (isLoggedIn()) {
            $suspendedUser = $this->bigBossModel->getSuspendedUser($_SESSION['user_id']);

            if (!empty($suspendedUser)) {
                if (time() > $suspendedUser['suspended_until'] && $suspendedUser['suspended_until'] != 0) {
                    $this->bigBossModel->unsuspendUser($_SESSION['user_id']);
                    return false;
                } else {
                    return $suspendedUser['suspended_until'];
                }
            }
        } else {
            return false;
        }
    }

    // check for maintenance
    protected function checkMaintenance()
    {
        if ($_SERVER['REQUEST_URI'] != '/panel/login' && $_SERVER['REQUEST_URI'] != '/login') {
            $maintenanceStatus = $this->bigBossModel->getSettingValue('maintenance_status');
            if ($maintenanceStatus == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // check privileges
    protected function checkPrivileges()
    {
        $fullAccess = isLoggedIn() ? $this->bigBossModel->checkFullAccess($_SESSION['user_name']) : 0;
        $isAdmin = isLoggedIn() ? $this->bigBossModel->checkAdmin($_SESSION['user_name']) : 0;
        $isLeader = isLoggedIn() ? $this->bigBossModel->checkLeader($_SESSION['user_name']) : 0;

        $userGroupsGlobal = isLoggedIn() ? $this->bigBossModel->getUserGroups($_SESSION['user_id']) : array();

        $canAccessSite = array();
        $canViewTickets = array();
        $canEditTickets = array();
        $canDeleteTickets = array();
        $canDeleteTReplies = array();
        $canCloseTickets = array();
        $canEditUComplaints = array();
        $canDeleteUComplaints = array();
        $canDeleteUCReplies = array();
        $canCloseUComplaints = array();
        $canHideUComplaints = array();
        $canEditFComplaints = array();
        $canDeleteFComplaints = array();
        $canDeleteFCReplies = array();
        $canCloseFComplaints = array();
        $canHideFComplaints = array();
        $canEditAComplaints = array();
        $canDeleteAComplaints = array();
        $canDeleteACReplies = array();
        $canCloseAComplaints = array();
        $canHideAComplaints = array();
        $canEditHComplaints = array();
        $canDeleteHComplaints = array();
        $canDeleteHCReplies = array();
        $canCloseHComplaints = array();
        $canHideHComplaints = array();
        $canEditLComplaints = array();
        $canDeleteLComplaints = array();
        $canDeleteLCReplies = array();
        $canCloseLComplaints = array();
        $canHideLComplaints = array();
        $canViewUnbans = array();
        $canEditUnbans = array();
        $canDeleteUnbans = array();
        $canCloseUnbans = array();
        $canEditLApps = array();
        $canDeleteLApps = array();
        $canEditHApps = array();
        $canDeleteHApps = array();

        if (isLoggedIn() && !empty($userGroupsGlobal)) {
            foreach ($userGroupsGlobal as $uGroup) {
                $canAccessSiteVal = $uGroup['can_access_site'] == 1 ? 1 : 0;
                array_push($canAccessSite, $canAccessSiteVal);

                $canViewTicketsVal = $uGroup['can_view_tickets'] == 1 ? 1 : 0;
                array_push($canViewTickets, $canViewTicketsVal);

                $canEditTicketsVal = $uGroup['can_edit_tickets'] == 1 ? 1 : 0;
                array_push($canEditTickets, $canEditTicketsVal);

                $canDeleteTicketsVal = $uGroup['can_delete_tickets'] == 1 ? 1 : 0;
                array_push($canDeleteTickets, $canDeleteTicketsVal);

                $canDeleteTRepliesVal = $uGroup['can_delete_treplies'] == 1 ? 1 : 0;
                array_push($canDeleteTReplies, $canDeleteTRepliesVal);

                $canCloseTicketsVal = $uGroup['can_close_tickets'] == 1 ? 1 : 0;
                array_push($canCloseTickets, $canCloseTicketsVal);

                $canEditUComplaintsVal = $uGroup['can_edit_ucomplaints'] == 1 ? 1 : 0;
                array_push($canEditUComplaints, $canEditUComplaintsVal);

                $canDeleteUComplaintsVal = $uGroup['can_delete_ucomplaints'] == 1 ? 1 : 0;
                array_push($canDeleteUComplaints, $canDeleteUComplaintsVal);

                $canDeleteUCRepliesVal = $uGroup['can_delete_ucreplies'] == 1 ? 1 : 0;
                array_push($canDeleteUCReplies, $canDeleteUCRepliesVal);

                $canCloseUComplaintsVal = $uGroup['can_close_ucomplaints'] == 1 ? 1 : 0;
                array_push($canCloseUComplaints, $canCloseUComplaintsVal);

                $canHideUComplaintsVal = $uGroup['can_hide_ucomplaints'] == 1 ? 1 : 0;
                array_push($canHideUComplaints, $canHideUComplaintsVal);

                $canEditFComplaintsVal = $uGroup['can_edit_fcomplaints'] == 1 ? 1 : 0;
                array_push($canEditFComplaints, $canEditFComplaintsVal);

                $canDeleteFComplaintsVal = $uGroup['can_delete_fcomplaints'] == 1 ? 1 : 0;
                array_push($canDeleteFComplaints, $canDeleteFComplaintsVal);

                $canDeleteFCRepliesVal = $uGroup['can_delete_fcreplies'] == 1 ? 1 : 0;
                array_push($canDeleteFCReplies, $canDeleteFCRepliesVal);

                $canCloseFComplaintsVal = $uGroup['can_close_fcomplaints'] == 1 ? 1 : 0;
                array_push($canCloseFComplaints, $canCloseFComplaintsVal);

                $canHideFComplaintsVal = $uGroup['can_hide_fcomplaints'] == 1 ? 1 : 0;
                array_push($canHideFComplaints, $canHideFComplaintsVal);

                $canEditAComplaintsVal = $uGroup['can_edit_acomplaints'] == 1 ? 1 : 0;
                array_push($canEditAComplaints, $canEditAComplaintsVal);

                $canDeleteAComplaintsVal = $uGroup['can_delete_acomplaints'] == 1 ? 1 : 0;
                array_push($canDeleteAComplaints, $canDeleteAComplaintsVal);

                $canDeleteACRepliesVal = $uGroup['can_delete_acreplies'] == 1 ? 1 : 0;
                array_push($canDeleteACReplies, $canDeleteACRepliesVal);

                $canCloseAComplaintsVal = $uGroup['can_close_acomplaints'] == 1 ? 1 : 0;
                array_push($canCloseAComplaints, $canCloseAComplaintsVal);

                $canHideAComplaintsVal = $uGroup['can_hide_acomplaints'] == 1 ? 1 : 0;
                array_push($canHideAComplaints, $canHideAComplaintsVal);

                $canEditHComplaintsVal = $uGroup['can_edit_hcomplaints'] == 1 ? 1 : 0;
                array_push($canEditHComplaints, $canEditHComplaintsVal);

                $canDeleteHComplaintsVal = $uGroup['can_delete_hcomplaints'] == 1 ? 1 : 0;
                array_push($canDeleteHComplaints, $canDeleteHComplaintsVal);

                $canDeleteHCRepliesVal = $uGroup['can_delete_hcreplies'] == 1 ? 1 : 0;
                array_push($canDeleteHCReplies, $canDeleteHCRepliesVal);

                $canCloseHComplaintsVal = $uGroup['can_close_hcomplaints'] == 1 ? 1 : 0;
                array_push($canCloseHComplaints, $canCloseHComplaintsVal);

                $canHideHComplaintsVal = $uGroup['can_hide_hcomplaints'] == 1 ? 1 : 0;
                array_push($canHideHComplaints, $canHideHComplaintsVal);

                $canEditLComplaintsVal = $uGroup['can_edit_lcomplaints'] == 1 ? 1 : 0;
                array_push($canEditLComplaints, $canEditLComplaintsVal);

                $canDeleteLComplaintsVal = $uGroup['can_delete_lcomplaints'] == 1 ? 1 : 0;
                array_push($canDeleteLComplaints, $canDeleteLComplaintsVal);

                $canDeleteLCRepliesVal = $uGroup['can_delete_lcreplies'] == 1 ? 1 : 0;
                array_push($canDeleteLCReplies, $canDeleteLCRepliesVal);

                $canCloseLComplaintsVal = $uGroup['can_close_lcomplaints'] == 1 ? 1 : 0;
                array_push($canCloseLComplaints, $canCloseLComplaintsVal);

                $canHideLComplaintsVal = $uGroup['can_hide_lcomplaints'] == 1 ? 1 : 0;
                array_push($canHideLComplaints, $canHideLComplaintsVal);

                $canViewUnbansVal = $uGroup['can_view_unbans'] == 1 ? 1 : 0;
                array_push($canViewUnbans, $canViewUnbansVal);

                $canEditUnbansVal = $uGroup['can_edit_unbans'] == 1 ? 1 : 0;
                array_push($canEditUnbans, $canEditUnbansVal);

                $canDeleteUnbansVal = $uGroup['can_delete_unbans'] == 1 ? 1 : 0;
                array_push($canDeleteUnbans, $canDeleteUnbansVal);

                $canCloseUnbansVal = $uGroup['can_close_unbans'] == 1 ? 1 : 0;
                array_push($canCloseUnbans, $canCloseUnbansVal);

                $canEditLAppsVal = $uGroup['can_edit_lapps'] == 1 ? 1 : 0;
                array_push($canEditLApps, $canEditLAppsVal);

                $canDeleteLAppsVal = $uGroup['can_delete_lapps'] == 1 ? 1 : 0;
                array_push($canDeleteLApps, $canDeleteLAppsVal);

                $canEditHAppsVal = $uGroup['can_edit_happs'] == 1 ? 1 : 0;
                array_push($canEditHApps, $canEditHAppsVal);

                $canDeleteHAppsVal = $uGroup['can_delete_happs'] == 1 ? 1 : 0;
                array_push($canDeleteHApps, $canDeleteHAppsVal);
            }
        }

        $canAccessSite = in_array(1, $canAccessSite) ? 1 : 0;
        $canViewTickets = in_array(1, $canViewTickets) ? 1 : 0;
        $canEditTickets = in_array(1, $canEditTickets) ? 1 : 0;
        $canDeleteTickets = in_array(1, $canDeleteTickets) ? 1 : 0;
        $canDeleteTReplies = in_array(1, $canDeleteTReplies) ? 1 : 0;
        $canCloseTickets = in_array(1, $canCloseTickets) ? 1 : 0;

        $canEditUComplaints = in_array(1, $canEditUComplaints) ? 1 : 0;
        $canDeleteUComplaints = in_array(1, $canDeleteUComplaints) ? 1 : 0;
        $canDeleteUCReplies = in_array(1, $canDeleteUCReplies) ? 1 : 0;
        $canCloseUComplaints = in_array(1, $canCloseUComplaints) ? 1 : 0;
        $canHideUComplaints = in_array(1, $canHideUComplaints) ? 1 : 0;

        $canEditFComplaints = in_array(1, $canEditFComplaints) ? 1 : 0;
        $canDeleteFComplaints = in_array(1, $canDeleteFComplaints) ? 1 : 0;
        $canDeleteFCReplies = in_array(1, $canDeleteFCReplies) ? 1 : 0;
        $canCloseFComplaints = in_array(1, $canCloseFComplaints) ? 1 : 0;
        $canHideFComplaints = in_array(1, $canHideFComplaints) ? 1 : 0;

        $canEditAComplaints = in_array(1, $canEditAComplaints) ? 1 : 0;
        $canDeleteAComplaints = in_array(1, $canDeleteAComplaints) ? 1 : 0;
        $canDeleteACReplies = in_array(1, $canDeleteACReplies) ? 1 : 0;
        $canCloseAComplaints = in_array(1, $canCloseAComplaints) ? 1 : 0;
        $canHideAComplaints = in_array(1, $canHideAComplaints) ? 1 : 0;

        $canEditHComplaints = in_array(1, $canEditHComplaints) ? 1 : 0;
        $canDeleteHComplaints = in_array(1, $canDeleteHComplaints) ? 1 : 0;
        $canDeleteHCReplies = in_array(1, $canDeleteHCReplies) ? 1 : 0;
        $canCloseHComplaints = in_array(1, $canCloseHComplaints) ? 1 : 0;
        $canHideHComplaints = in_array(1, $canHideHComplaints) ? 1 : 0;

        $canEditLComplaints = in_array(1, $canEditLComplaints) ? 1 : 0;
        $canDeleteLComplaints = in_array(1, $canDeleteLComplaints) ? 1 : 0;
        $canDeleteLCReplies = in_array(1, $canDeleteLCReplies) ? 1 : 0;
        $canCloseLComplaints = in_array(1, $canCloseLComplaints) ? 1 : 0;
        $canHideLComplaints = in_array(1, $canHideLComplaints) ? 1 : 0;

        $canViewUnbans = in_array(1, $canViewUnbans) ? 1 : 0;
        $canEditUnbans = in_array(1, $canEditUnbans) ? 1 : 0;
        $canDeleteUnbans = in_array(1, $canDeleteUnbans) ? 1 : 0;
        $canCloseUnbans = in_array(1, $canCloseUnbans) ? 1 : 0;

        $canEditLApps = in_array(1, $canEditLApps) ? 1 : 0;
        $canDeleteLApps = in_array(1, $canDeleteLApps) ? 1 : 0;

        $canEditHApps = in_array(1, $canEditHApps) ? 1 : 0;
        $canDeleteHApps = in_array(1, $canDeleteHApps) ? 1 : 0;

        return [
            'fullAccess' => $fullAccess,
            'isAdmin' => $isAdmin,
            'isLeader' => $isLeader,
            'canAccessSite' => $canAccessSite,

            'canViewTickets' => $canViewTickets,
            'canEditTickets' => $canEditTickets,
            'canDeleteTickets' => $canDeleteTickets,
            'canDeleteTReplies' => $canDeleteTReplies,
            'canCloseTickets' => $canCloseTickets,

            'canEditUComplaints' => $canEditUComplaints,
            'canDeleteUComplaints' => $canDeleteUComplaints,
            'canDeleteUCReplies' => $canDeleteUCReplies,
            'canCloseUComplaints' => $canCloseUComplaints,
            'canHideUComplaints' => $canHideUComplaints,

            'canEditFComplaints' => $canEditFComplaints,
            'canDeleteFComplaints' => $canDeleteFComplaints,
            'canDeleteFCReplies' => $canDeleteFCReplies,
            'canCloseFComplaints' => $canCloseFComplaints,
            'canHideFComplaints' => $canHideFComplaints,

            'canEditAComplaints' => $canEditAComplaints,
            'canDeleteAComplaints' => $canDeleteAComplaints,
            'canDeleteACReplies' => $canDeleteACReplies,
            'canCloseAComplaints' => $canCloseAComplaints,
            'canHideAComplaints' => $canHideAComplaints,

            'canEditHComplaints' => $canEditHComplaints,
            'canDeleteHComplaints' => $canDeleteHComplaints,
            'canDeleteHCReplies' => $canDeleteHCReplies,
            'canCloseHComplaints' => $canCloseHComplaints,
            'canHideHComplaints' => $canHideHComplaints,

            'canEditLComplaints' => $canEditLComplaints,
            'canDeleteLComplaints' => $canDeleteLComplaints,
            'canDeleteLCReplies' => $canDeleteLCReplies,
            'canCloseLComplaints' => $canCloseLComplaints,
            'canHideLComplaints' => $canHideLComplaints,

            'canViewUnbans' => $canViewUnbans,
            'canEditUnbans' => $canEditUnbans,
            'canDeleteUnbans' => $canDeleteUnbans,
            'canCloseUnbans' => $canCloseUnbans,

            'canEditLApps' => $canEditLApps,
            'canDeleteLApps' => $canDeleteLApps,

            'canEditHApps' => $canEditHApps,
            'canDeleteHApps' => $canDeleteHApps
        ];
    }
}