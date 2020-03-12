<?php
/**
 * @brief The main controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class MainController
{
    // load model
    public function loadModel($modelName)
    {
        // make the first letter to be uppercase if not
        $modelName = ucfirst($modelName);

        // check if model exists
        if (file_exists(ROOT_PATH . '/system/Models/' . $modelName . '.php')) {
            // require the model file
            require_once ROOT_PATH . '/system/Models/' . $modelName . '.php';

            // initiate the model
            return new $modelName();
        } else {
            die('Model ' . $modelName . ' cannot be found');
        }
    }

    // load view
    public function loadView($viewName, $data = [], $errors = [])
    {
        // check if view exists
        if (file_exists(ROOT_PATH . '/public/views/' . $viewName . '.php')) {
            // load the view file
            require_once ROOT_PATH . '/public/views/' . $viewName . '.php';
        } else {
            die('View ' . $viewName . ' does not exist');
        }
    }
}