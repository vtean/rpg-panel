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
    private $ticketModel;

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
            // load the view file
            require_once ROOT_PATH . '/public/views/' . $viewName . '.php';
        } else {
            die('View ' . $viewName . ' does not exist');
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
        $this->ticketModel = $this->loadModel('Ticket');
        $ticketBadge = $this->ticketModel->countTickets();

        return [
          'ticketBadge' => $ticketBadge
        ];
    }

    // check privileges
    protected function checkPrivileges()
    {
        // load the model
        $this->bigBossModel = $this->loadModel('General');

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