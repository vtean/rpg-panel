<?php
/**
 * @brief Here you can create routes for your front.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

// Use Route::set(link, controller, defaultMethod) to create a new route
// Example: Route::set('about', 'aboutUs', 'index');

// main index
Route::set('', 'Main', 'index');

// auth
Route::set('login', 'Login', 'index');
Route::set('logout', 'Logout', 'index');