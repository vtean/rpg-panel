<?php
/**
 * @brief Families controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class FamiliesController extends Controller
{
    private $familyModel;
    private $privileges;

    public function __construct()
    {
        // load model
        $this->familyModel = $this->loadModel('Family');

        // store privileges
        $this->privileges = $this->checkPrivileges();
    }

    public function index()
    {
        global $lang;
        $badges = $this->badges();
        $families = $this->familyModel->getFamilies();

        $data = [
            'pageTitle' => 'Families',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'lang' => $lang,
            'badges' => $badges,
            'families' => $families
        ];

        // load view
        $this->loadView('families_index', $data);
    }
}