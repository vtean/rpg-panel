<?php
/**
 * @brief MainController index controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class MainController extends Controller
{
    private $generalModel;
    private $mainModel;

    public function __construct()
    {
        // load the model
        $this->generalModel = $this->loadModel('General');
        $this->mainModel = $this->loadModel('Main');
    }
    public function index()
    {
        $fullAccess = isLoggedIn() ? $this->generalModel->checkFullAccess($_SESSION['user_name']) : 0;
        $isAdmin = isLoggedIn() ? $this->generalModel->checkAdmin($_SESSION['user_name']) : 0;
        $isLeader = isLoggedIn() ? $this->generalModel->checkLeader($_SESSION['user_name']) : 0;

        $houses = $this->mainModel->getHouses();
        $business = $this->mainModel->getBusiness();
        $vehicles = $this->mainModel->getVehicles();
        $regUsers= $this->mainModel->getRegUsers();
        $data = [
            'pageTitle' => 'Home',
            'fullAccess' => $fullAccess,
            'isAdmin' => $isAdmin,
            'isLeader' => $isLeader,
            'houses' => $houses,
            'business' => $business,
            'vehicles' => $vehicles,
            'regUsers' => $regUsers
        ];
        $this->loadView('main', $data);
    }
}