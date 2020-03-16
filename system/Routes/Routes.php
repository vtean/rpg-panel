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
Route::set('', 'MainController', 'index');

// auth
Route::set('login', 'LoginController', 'index');
Route::set('logout', 'LogoutController', 'index');

// owner page
Route::set('owner', 'OwnerController', 'index');

// admin page
Route::set('admin', 'AdminController', 'index');

// leader page
Route::set('leader', 'LeaderController', 'index');

// user page
Route::set('users', 'UsersController', 'index');

// statistics pages
Route::set('online', 'StatisticsController', 'online');

// groups page
Route::set('groups', 'GroupsController', 'index');