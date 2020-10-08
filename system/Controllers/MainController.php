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
    private $generalModel;

    public function __construct()
    {
        parent::__construct();

        // load models
        $this->mainModel = $this->loadModel('Main');
        $this->generalModel = $this->loadModel('General');
    }

    public function index()
    {
        $houses = $this->mainModel->countHouses();
        $business = $this->mainModel->countBusiness();
        $vehicles = $this->mainModel->countVehicles();
        $regUsers = $this->mainModel->countRegUsers();
        $pageTitle = $_COOKIE["user_lang"] == "ro" ? 'Acasă' : 'Home';
        $latestFH = $this->mainModel->latestFactionHistory();

        $data = [
            'pageTitle' => $pageTitle,
            'houses' => $houses,
            'business' => $business,
            'vehicles' => $vehicles,
            'regUsers' => $regUsers,
            'latestFH' => $latestFH,
        ];

        $this->loadView('main', $data);
    }

    public function ro()
    {
        // set language to romanian
        $cookieName = "user_lang";
        $cookieValue = "ro";
        setcookie($cookieName, $cookieValue, time() + (86400 * 30), "/");

        // add flash message
        flashMessage('success', 'Limba a fost modificată cu succes în Română.');

        // redirect to the main page
        redirect('/');
    }

    public function en()
    {
        // set language to english
        $cookieName = "user_lang";
        $cookieValue = "en";
        setcookie($cookieName, $cookieValue, time() + (86400 * 30), "/");

        // add flash message
        flashMessage('success', 'Site language has been changed successfully to English.');

        // redirect to the main page
        redirect('/');
    }
}