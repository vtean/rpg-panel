<?php
/**
 * @brief Prepare all the goodies to be loaded.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

// set timezone
date_default_timezone_set('Europe/Bucharest');

// initiate the session
session_start();

// load the main config
require_once 'config.php';

// load useful functions
require_once ROOT_PATH . '/system/Helpers/useful_functions.php';

// load csrf token
require_once ROOT_PATH . '/system/Session/Csrf.php';

// load language configuration
require_once ROOT_PATH . '/system/Cookies/Language.php';

// connect to the database
require_once ROOT_PATH . '/system/Db/Connect.php';

// load database queries
require_once ROOT_PATH . '/system/Db/Db.php';

// load two factor auth
require_once ROOT_PATH . '/system/API/GoogleAuthenticator.php';

// load samp query
require_once ROOT_PATH . '/system/API/SampQuery.class.php';

// load the URL handler
require_once ROOT_PATH . '/system/Url/UrlHandler.php';

// load route
require_once ROOT_PATH . '/system/Routes/Route.php';

// load routes
require_once ROOT_PATH . '/system/Routes/Routes.php';

// load the main controller
require_once ROOT_PATH . '/system/Controllers/Controller.php';

// load the core
require_once ROOT_PATH . '/system/Load/Core.php';
$initCore = new Core();