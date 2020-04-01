<?php
/**
 * @brief Unban request creating validation.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

trait ValidateUnban
{
    public static function validate($postData)
    {
        $errors = [
            'message_error' => ''
        ];

        if (empty($postData['description'])) {
            $errors['message_error'] = 'Description cannot be empty.';
        } else if (strlen($postData['description']) < 5) {
            $errors['message_error'] = 'Description must have at least 5 characters.';
        }

        return $errors;
    }
}