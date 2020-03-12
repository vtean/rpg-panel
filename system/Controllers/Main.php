<?php
/**
 * @brief Main index controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Main extends MainController
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Home'
        ];
        $this->loadView('main', $data);
    }
}