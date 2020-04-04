<?php
/**
 * @brief Application creating validation.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

trait ValidateApplication
{
    public static function validate($postData)
    {
        $errors = [
            'body_erorr' => ''
        ];

        if (empty($postData['body'])) {
            $errors['body_erorr'] = "Application body cannot be empty.";
        } else if (strlen($postData['body']) < 300) {
            $errors['body_erorr'] = "Your application must have at least 300 characters.";
        }

        return $errors;
    }
}