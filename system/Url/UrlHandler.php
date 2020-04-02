<?php
/**
 * @brief Handle all the incoming URLs.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class UrlHandler
{
    public function requestUrl()
    {
        if (isset($_GET['url'])) {
            // remove slashes from the beginning and ending of the url
            $url = trim($_GET['url'], '/');

            // sanitize the url
            $url = filter_var($url, FILTER_SANITIZE_URL);

            // create an array from the url
            $url = explode('/', $url);
        } else if (!isset($_GET['url'])) {
            $url = [
                '0' => ''
            ];
        }

        return $url;
    }
}