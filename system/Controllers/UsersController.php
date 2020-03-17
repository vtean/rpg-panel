<?php
/**
 * @brief UsersController controller
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class UsersController extends Controller
{
    private $userModel;
    private $privileges;

    public function __construct()
    {
        // load the model
        $this->userModel = $this->loadModel('User');

        // store use privileges
        $this->privileges = $this->checkPrivileges();
    }

    public function index()
    {
        echo 'aloha bitch';
    }

    public function profile($nickname = '')
    {
        if (empty($nickname)) {
            echo 'nothing to see here';
        } else {
            if ($this->userModel->searchExistingUser($nickname) != false) {
                $userInfo = $this->userModel->searchExistingUser($nickname);
                $job = $this->userModel->getJob($userInfo['Job']);
                $family = $this->userModel->getFamily($userInfo['pFamily']);
                $faction = $this->userModel->getFaction($userInfo['Member']);
                $factionRank = $this->userModel->getFactionRank($userInfo['Member'], $userInfo['Rank']);
                $getVehicle = $this->userModel->getVehicle($userInfo['NickName']);
                $getModelName = $this->userModel->getModelName($userInfo['NickName']);
            } else {
                // add session message
                flashMessage('info', 'User not found.');
                // redirect logged in user to the main page
                redirect('/');
            }
            $data = [
                'pageTitle' => $userInfo['NickName'] . "'s Profile",
                'user' => $userInfo,
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'job' => $job,
                'family' => $family,
                'faction' => $faction,
                'factionRank' => $factionRank,
                'getVehicle' => $getVehicle,
                'getModelName' => $getModelName
            ];
            // load the profile view
            $this->loadView('profile', $data);
        }
    }
}