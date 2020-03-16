<?php
/**
 * @brief LogoutController user
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class LogoutController {
    public function index() {
        // unset session variables
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_skin']);
        // destroy the session
        session_destroy();
        // redirect to the main page
        redirect('/');
    }
}