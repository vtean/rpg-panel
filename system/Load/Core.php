<?php
/**
 * @brief Prepare controllers and models for loading.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Core extends UrlHandler
{
    protected $activeController;
    protected $activeMethod;
    protected $params = array();

    public function __construct()
    {
        $this->check();
    }

    public function check()
    {
        $url = $this->requestUrl();
        $routesArr = Route::$validRoutes;

        // check if the url is a page
        if (array_key_exists($url[0], $routesArr)) {
            // check if the controller for this url exists
            $controllerName = ucfirst($routesArr[$url[0]]['controller']);
            $methodName = $routesArr[$url[0]]['method'];

            // set the active method to the default one (set in the Route.php)
            $this->activeMethod = $methodName;

            if (file_exists(ROOT_PATH . '/system/Controllers/' . $controllerName . '.php')) {
                // load the controller
                require_once ROOT_PATH . '/system/Controllers/' . $controllerName . '.php';

                // instantiate the controller
                $controllerName = new $controllerName;

                // set the active controller
                $this->activeController = $controllerName;

                // check if the method is set in the url
                if (isset($url[1])) {
                    // check if the method exists in the controller
                    if (method_exists($this->activeController, $url[1])) {
                        // change the active method
                        $this->activeMethod = $url[1];

                        // check if params are set
                        if (isset($url[2])) {
                            // unset link and method for the params to be added
                            unset($url[0], $url[1]);

                            // add params
                            $this->params = $url ? array_values($url) : [];
                        }

                        // call a callback with params
                        call_user_func_array([$this->activeController, $this->activeMethod], $this->params);
                    } else {
                        echo 'Method ' . $url[1] . ' not found';
                    }
                } else {
                    // call a callback with params if the active method exists in the controller
                    if (method_exists($this->activeController, $this->activeMethod)) {
                        call_user_func_array([$this->activeController, $this->activeMethod], $this->params);
                    } else {
                        echo 'Method ' . $this->activeMethod . ' not found';
                    }
                }
            } else {
                echo 'Controller ' . $controllerName . ' cannot be found';
            }
        } else {
           getError('404', 'Page Not Found!');
        }
    }
}