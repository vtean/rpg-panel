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
        global $lang;

        $houses = $this->mainModel->getHouses();
        $business = $this->mainModel->getBusiness();
        $vehicles = $this->mainModel->getVehicles();
        $regUsers= $this->mainModel->getRegUsers();
        $pageTitle = $_SESSION['user_lang'] == 'ro' ? 'Acasă' : 'Home';

        $data = [
            'pageTitle' => $pageTitle,
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'houses' => $houses,
            'business' => $business,
            'vehicles' => $vehicles,
            'regUsers' => $regUsers,
            'lang' => $lang
        ];

        $this->loadView('main', $data);
    }

    public function ro()
    {
        // set language to romanian
        $_SESSION['user_lang'] = 'ro';

        // add flash message
        flashMessage('success', 'Limba a fost modificată cu succes în Română');

        // redirect to the main page
        redirect('/');
    }

    public function en()
    {
        // set language to english
        $_SESSION['user_lang'] = 'en';

        // add flash message
        flashMessage('success', 'Site language has been changed successfully to English');

        // redirect to the main page
        redirect('/');
    }
}