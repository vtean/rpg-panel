<?php
/**
 * @brief The best useful functions go here.
 * @authors Lust & Indigo
 * @param $pageTitle
 * @version 0.1
 * @copyright (c) DreamVibe Community
 */

/* Get menu */
function getMenu()
{
    require_once ROOT_PATH . '/public/views/layouts/menu.php';
}

/* Get page header */
function getHeader($pageTitle)
{
    require_once ROOT_PATH . '/public/views/layouts/header.php';
}

/* Get page footer */
function getFooter()
{
    require_once ROOT_PATH . '/public/views/layouts/footer.php';
}