<?php
/**
 * @brief MainController index controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class MainController extends Controller
{
    private $mainModel;
    private $privileges;

    public function __construct()
    {
        // load the model
        $this->mainModel = $this->loadModel('Main');

        // store user privileges
        $this->privileges = $this->checkPrivileges();
    }
    public function index()
    {
        $houses = $this->mainModel->getHouses();
        $business = $this->mainModel->getBusiness();
        $vehicles = $this->mainModel->getVehicles();
        $regUsers= $this->mainModel->getRegUsers();
        $data = [
            'pageTitle' => 'Home',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'houses' => $houses,
            'business' => $business,
            'vehicles' => $vehicles,
            'regUsers' => $regUsers
        ];
        $this->loadView('main', $data);
    }
}