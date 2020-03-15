<?php
/**
 * @brief OwnerController controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class OwnerController extends Controller
{
    private $generalModel;

    public function __construct()
    {
        // load the model
        $this->generalModel = $this->loadModel('General');

        $fullAccess = $this->generalModel->checkFullAccess($_SESSION['user_name']);
        if (!$fullAccess) {
            // add session message
            flashMessage('danger', 'You are not allowed to access this page.');
            // redirect to main page
            redirect('/');
        }

    }
    public function index()
    {
        $data = [
            'pageTitle' => 'Home',
            'name' => $_SESSION['user_name']
        ];
        $this->loadView('owner', $data);
    }
}