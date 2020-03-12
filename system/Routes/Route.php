<?php
/**
 * @brief Creates an array with valid routes (created in the Routes.php file).
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class Route
{
    public static $validRoutes = array();

    public static function set($link, $controller, $defaultMethod)
    {
        // insert the link into valid routes array
        self::$validRoutes[$link] = [
            'controller' => $controller,
            'method' => $defaultMethod
        ];
    }
}