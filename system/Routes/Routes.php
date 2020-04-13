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
Route::set('security', 'SecurityController', 'security');

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

// change lang to romanian
Route::set('ro', 'MainController', 'ro');

// change lang to english
Route::set('en', 'MainController', 'en');

// tickets page
Route::set('tickets', 'TicketsController', 'index');

// complaints page
Route::set('complaints', 'ComplaintsController', 'index');

// unban requests page
Route::set('unbans', 'UnbansController', 'index');

// applications page
Route::set('apps', 'ApplicationsController', 'index');

// staff page
Route::set('staff', 'StatisticsController', 'staff');

// factions page
Route::set('factions', 'FactionsController', 'index');