<?php
/**
 * @brief Groups controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/Validations/ValidateGroup.php';

class GroupsController extends Controller
{
    private $groupModel;
    private $userModel;
    private $privileges;

    use ValidateGroup;

    public function __construct()
    {
        // load group model
        $this->groupModel = $this->loadModel('Group');

        // load user model
        $this->userModel = $this->loadModel('User');

        // check user privileges
        $this->privileges = $this->checkPrivileges();

        if ($this->privileges['fullAccess'] == 0) {
            // add session message
            flashMessage('danger', 'Sorry babe, you cannot be here.');
            // redirect to main page
            redirect('/');
        }
    }

    public function index()
    {
        global $lang;

        // get badges
        $badges = $this->badges();

        $allGroups = $this->groupModel->getAllGroups();

        $data = [
            'pageTitle' => 'Panel Groups',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'groups' => $allGroups,
            'lang' => $lang,
            'badges' => $badges
        ];

        $this->loadView('groups_index', $data);
    }

    public function create()
    {
        global $lang;

        // get badges
        $badges = $this->badges();

        if (isset($_POST['create_group'])) {
            // sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // update post values
            $_POST['is_hidden'] = isset($_POST['is_hidden']) ? 1 : 0;
            $_POST['can_access_site'] = isset($_POST['can_access_site']) ? 1 : 0;
            $_POST['can_view_tickets'] = isset($_POST['can_view_tickets']) ? 1 : 0;
            $_POST['can_edit_tickets'] = isset($_POST['can_edit_tickets']) ? 1 : 0;
            $_POST['can_delete_tickets'] = isset($_POST['can_delete_tickets']) ? 1 : 0;
            $_POST['can_delete_treplies'] = isset($_POST['can_delete_treplies']) ? 1 : 0;
            $_POST['can_close_tickets'] = isset($_POST['can_close_tickets']) ? 1 : 0;
            $_POST['can_edit_ucomplaints'] = isset($_POST['can_edit_ucomplaints']) ? 1 : 0;
            $_POST['can_delete_ucomplaints'] = isset($_POST['can_delete_ucomplaints']) ? 1 : 0;
            $_POST['can_delete_ucreplies'] = isset($_POST['can_delete_ucreplies']) ? 1 : 0;
            $_POST['can_close_ucomplaints'] = isset($_POST['can_close_ucomplaints']) ? 1 : 0;
            $_POST['can_hide_ucomplaints'] = isset($_POST['can_hide_ucomplaints']) ? 1 : 0;
            $_POST['can_edit_fcomplaints'] = isset($_POST['can_edit_fcomplaints']) ? 1 : 0;
            $_POST['can_delete_fcomplaints'] = isset($_POST['can_delete_fcomplaints']) ? 1 : 0;
            $_POST['can_delete_fcreplies'] = isset($_POST['can_delete_fcreplies']) ? 1 : 0;
            $_POST['can_close_fcomplaints'] = isset($_POST['can_close_fcomplaints']) ? 1 : 0;
            $_POST['can_hide_fcomplaints'] = isset($_POST['can_hide_fcomplaints']) ? 1 : 0;
            $_POST['can_edit_acomplaints'] = isset($_POST['can_edit_acomplaints']) ? 1 : 0;
            $_POST['can_delete_acomplaints'] = isset($_POST['can_delete_acomplaints']) ? 1 : 0;
            $_POST['can_delete_acreplies'] = isset($_POST['can_delete_acreplies']) ? 1 : 0;
            $_POST['can_close_acomplaints'] = isset($_POST['can_close_acomplaints']) ? 1 : 0;
            $_POST['can_hide_acomplaints'] = isset($_POST['can_hide_acomplaints']) ? 1 : 0;
            $_POST['can_edit_hcomplaints'] = isset($_POST['can_edit_hcomplaints']) ? 1 : 0;
            $_POST['can_delete_hcomplaints'] = isset($_POST['can_delete_hcomplaints']) ? 1 : 0;
            $_POST['can_delete_hcreplies'] = isset($_POST['can_delete_hcreplies']) ? 1 : 0;
            $_POST['can_close_hcomplaints'] = isset($_POST['can_close_hcomplaints']) ? 1 : 0;
            $_POST['can_hide_hcomplaints'] = isset($_POST['can_hide_hcomplaints']) ? 1 : 0;
            $_POST['can_edit_lcomplaints'] = isset($_POST['can_edit_lcomplaints']) ? 1 : 0;
            $_POST['can_delete_lcomplaints'] = isset($_POST['can_delete_lcomplaints']) ? 1 : 0;
            $_POST['can_delete_lcreplies'] = isset($_POST['can_delete_lcreplies']) ? 1 : 0;
            $_POST['can_close_lcomplaints'] = isset($_POST['can_close_lcomplaints']) ? 1 : 0;
            $_POST['can_hide_lcomplaints'] = isset($_POST['can_hide_lcomplaints']) ? 1 : 0;
            $_POST['can_view_unbans'] = isset($_POST['can_view_unbans']) ? 1 : 0;
            $_POST['can_edit_unbans'] = isset($_POST['can_edit_unbans']) ? 1 : 0;
            $_POST['can_delete_unbans'] = isset($_POST['can_delete_unbans']) ? 1 : 0;
            $_POST['can_close_unbans'] = isset($_POST['can_close_unbans']) ? 1 : 0;
            $_POST['can_edit_lapps'] = isset($_POST['can_edit_lapps']) ? 1 : 0;
            $_POST['can_delete_lapps'] = isset($_POST['can_delete_lapps']) ? 1 : 0;
            $_POST['can_edit_happs'] = isset($_POST['can_edit_happs']) ? 1 : 0;
            $_POST['can_delete_happs'] = isset($_POST['can_delete_happs']) ? 1 : 0;

            // parse data
            $data = [
                'pageTitle' => 'Create Group',
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'group' => $_POST,
                'lang' => $lang,
                'badges' => $badges
            ];

            // check if group already exists
            $groupCheck = $this->groupModel->searchExistingGroup($_POST['group_name']);

            // handle errors
            $errors = ValidateGroup::validate($_POST, $groupCheck);

            // unset submit button
            unset($_POST['create_group']);

            // check if there are no errors
            if (count(array_filter($errors)) == 0) {
                unset($_POST['csrfToken']);
                // create group
                if ($this->groupModel->createGroup($_POST)) {
                    flashMessage('success', 'The group has been successfully created!');
                    redirect('/groups');
                } else {
                    die('Something went wrong.');
                }
            } else {
                // load view with errors
                $this->loadView('group_create', $data, $errors);
            }
        } else {
            $data = [
                'pageTitle' => 'Create Group',
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'group' => [
                    'group_name' => '',
                    'group_keyword' => '',
                    'is_hidden' => 0,
                    'can_access_site' => 0,
                    'can_view_tickets' => 0,
                    'can_edit_tickets' => 0,
                    'can_delete_tickets' => 0,
                    'can_delete_treplies' => 0,
                    'can_close_tickets' => 0,
                    'can_edit_ucomplaints' => 0,
                    'can_delete_ucomplaints' => 0,
                    'can_delete_ucreplies' => 0,
                    'can_close_ucomplaints' => 0,
                    'can_hide_ucomplaints' => 0,
                    'can_edit_fcomplaints' => 0,
                    'can_delete_fcomplaints' => 0,
                    'can_delete_fcreplies' => 0,
                    'can_close_fcomplaints' => 0,
                    'can_hide_fcomplaints' => 0,
                    'can_edit_acomplaints' => 0,
                    'can_delete_acomplaints' => 0,
                    'can_delete_acreplies' => 0,
                    'can_close_acomplaints' => 0,
                    'can_hide_acomplaints' => 0,
                    'can_edit_hcomplaints' => 0,
                    'can_delete_hcomplaints' => 0,
                    'can_delete_hcreplies' => 0,
                    'can_close_hcomplaints' => 0,
                    'can_hide_hcomplaints' => 0,
                    'can_edit_lcomplaints' => 0,
                    'can_delete_lcomplaints' => 0,
                    'can_delete_lcreplies' => 0,
                    'can_close_lcomplaints' => 0,
                    'can_hide_lcomplaints' => 0,
                    'can_view_unbans' => 0,
                    'can_edit_unbans' => 0,
                    'can_delete_unbans' => 0,
                    'can_close_unbans' => 0,
                    'can_edit_lapps' => 0,
                    'can_delete_lapps' => 0,
                    'can_edit_happs' => 0,
                    'can_delete_happs' => 0
                ],
                'lang' => $lang,
                'badges' => $badges
            ];

            // load view
            $this->loadView('group_create', $data);
        }
    }

    public function edit($id = 0)
    {
        global $lang;

        if ($id == 0) {
            flashMessage('danger', 'Nothing to see here.');
            redirect('/');
        } else {
            $group = $this->groupModel->getSingleGroup($id);

            // get badges
            $badges = $this->badges();

            $data = [
                'pageTitle' => $group['group_name'] . ' Group',
                'group' => $group,
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'lang' => $lang,
                'badges' => $badges
            ];

            $errors = [];

            // check if delete group button is set
            if (isset($_POST['delete_group'])) {
                if ($this->groupModel->deleteGroup($id)) {
                    flashMessage('success', 'Group has been successfully deleted!');
                    redirect('/groups');
                    unset($_POST);
                } else {
                    die('Something went wrong');
                }
            }

            // check if edit button is set
            if (isset($_POST['edit_group'])) {
                // sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // update post values
                $_POST['is_hidden'] = isset($_POST['is_hidden']) ? 1 : 0;
                $_POST['can_access_site'] = isset($_POST['can_access_site']) ? 1 : 0;
                $_POST['can_view_tickets'] = isset($_POST['can_view_tickets']) ? 1 : 0;
                $_POST['can_edit_tickets'] = isset($_POST['can_edit_tickets']) ? 1 : 0;
                $_POST['can_delete_tickets'] = isset($_POST['can_delete_tickets']) ? 1 : 0;
                $_POST['can_delete_treplies'] = isset($_POST['can_delete_treplies']) ? 1 : 0;
                $_POST['can_close_tickets'] = isset($_POST['can_close_tickets']) ? 1 : 0;
                $_POST['can_edit_ucomplaints'] = isset($_POST['can_edit_ucomplaints']) ? 1 : 0;
                $_POST['can_delete_ucomplaints'] = isset($_POST['can_delete_ucomplaints']) ? 1 : 0;
                $_POST['can_delete_ucreplies'] = isset($_POST['can_delete_ucreplies']) ? 1 : 0;
                $_POST['can_close_ucomplaints'] = isset($_POST['can_close_ucomplaints']) ? 1 : 0;
                $_POST['can_hide_ucomplaints'] = isset($_POST['can_hide_ucomplaints']) ? 1 : 0;
                $_POST['can_edit_fcomplaints'] = isset($_POST['can_edit_fcomplaints']) ? 1 : 0;
                $_POST['can_delete_fcomplaints'] = isset($_POST['can_delete_fcomplaints']) ? 1 : 0;
                $_POST['can_delete_fcreplies'] = isset($_POST['can_delete_fcreplies']) ? 1 : 0;
                $_POST['can_close_fcomplaints'] = isset($_POST['can_close_fcomplaints']) ? 1 : 0;
                $_POST['can_hide_fcomplaints'] = isset($_POST['can_hide_fcomplaints']) ? 1 : 0;
                $_POST['can_edit_acomplaints'] = isset($_POST['can_edit_acomplaints']) ? 1 : 0;
                $_POST['can_delete_acomplaints'] = isset($_POST['can_delete_acomplaints']) ? 1 : 0;
                $_POST['can_delete_acreplies'] = isset($_POST['can_delete_acreplies']) ? 1 : 0;
                $_POST['can_close_acomplaints'] = isset($_POST['can_close_acomplaints']) ? 1 : 0;
                $_POST['can_hide_acomplaints'] = isset($_POST['can_hide_acomplaints']) ? 1 : 0;
                $_POST['can_edit_hcomplaints'] = isset($_POST['can_edit_hcomplaints']) ? 1 : 0;
                $_POST['can_delete_hcomplaints'] = isset($_POST['can_delete_hcomplaints']) ? 1 : 0;
                $_POST['can_delete_hcreplies'] = isset($_POST['can_delete_hcreplies']) ? 1 : 0;
                $_POST['can_close_hcomplaints'] = isset($_POST['can_close_hcomplaints']) ? 1 : 0;
                $_POST['can_hide_hcomplaints'] = isset($_POST['can_hide_hcomplaints']) ? 1 : 0;
                $_POST['can_edit_lcomplaints'] = isset($_POST['can_edit_lcomplaints']) ? 1 : 0;
                $_POST['can_delete_lcomplaints'] = isset($_POST['can_delete_lcomplaints']) ? 1 : 0;
                $_POST['can_delete_lcreplies'] = isset($_POST['can_delete_lcreplies']) ? 1 : 0;
                $_POST['can_close_lcomplaints'] = isset($_POST['can_close_lcomplaints']) ? 1 : 0;
                $_POST['can_hide_lcomplaints'] = isset($_POST['can_hide_lcomplaints']) ? 1 : 0;
                $_POST['can_view_unbans'] = isset($_POST['can_view_unbans']) ? 1 : 0;
                $_POST['can_edit_unbans'] = isset($_POST['can_edit_unbans']) ? 1 : 0;
                $_POST['can_delete_unbans'] = isset($_POST['can_delete_unbans']) ? 1 : 0;
                $_POST['can_close_unbans'] = isset($_POST['can_close_unbans']) ? 1 : 0;
                $_POST['can_edit_lapps'] = isset($_POST['can_edit_lapps']) ? 1 : 0;
                $_POST['can_delete_lapps'] = isset($_POST['can_delete_lapps']) ? 1 : 0;
                $_POST['can_edit_happs'] = isset($_POST['can_edit_happs']) ? 1 : 0;
                $_POST['can_delete_happs'] = isset($_POST['can_delete_happs']) ? 1 : 0;

                // check if group already exists
                $groupCheck = $this->groupModel->searchExistingGroup($_POST['group_name']);

                // handle errors
                $errors = ValidateGroup::validate($_POST, $groupCheck);

                // unset submit button
                unset($_POST['edit_group']);

                // check if there are no errors
                if (count(array_filter($errors)) == 0) {
                    unset($_POST['csrfToken']);
                    if ($this->groupModel->editGroup($_POST, $id)) {
                        flashMessage('success', 'Group has been successfully edited!');
                        redirect('/groups');
                    } else {
                        die('Something went wrong');
                    }
                }
            }

            // load view
            $this->loadView('group_edit', $data, $errors);
        }
    }

    public function assign($name = '')
    {
        global $lang;

        // get badges
        $badges = $this->badges();

        if (empty($name)) {
            echo 'Page not found';
        } else {
            $user = $this->userModel->searchExistingUser($name);

            if ($user) {
                $allGroups = $this->groupModel->getAllGroups();
                $userGroups = implode($this->userModel->getUserGroups($name));
                $pageTitle = $_COOKIE["user_lang"] == "ro" ? 'Atribuire Grupuri' : 'Assign Groups';

                // unserialize user groups
                $userGroupsArr = unserialize($userGroups);

                $data = [
                    'pageTitle' => $pageTitle,
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader'],
                    'lang' => $lang,
                    'user' => $user,
                    'groups' => $allGroups,
                    'userGroups' => $userGroupsArr,
                    'badges' => $badges
                ];

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // sanitize post data
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                    // prepare groups to be stored
                    $serializedGroups = serialize($_POST['userGroups']);

                    // assign groups to user
                    $this->groupModel->assignGroups($serializedGroups, $user['NickName']);

                    // add flash message
                    flashMessage('success', 'Groups have been successfully updated.');

                    // redirect
                    redirect('/groups');
                } else {
                    // load view
                    $this->loadView('groups_assign', $data);
                }
            } else {
                echo 'User not found.';
            }
        }
    }
}