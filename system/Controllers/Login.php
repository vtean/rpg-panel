<?php
/**
 * @brief Login controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Login extends MainController
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Login'
        ];
        $this->loadView('login', $data);
    }


}