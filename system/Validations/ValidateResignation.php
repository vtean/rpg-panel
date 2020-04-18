<?php
/**
 * @brief Resignations validation.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

trait ValidateResignation
{
    public static function validatePost($data)
    {
        $errors = [
            'body_error' => ''
        ];

        if (empty($data['body'])) {
            $errors['body_error'] = "Description cannot be empty.";
        } else if (strlen($data['body']) < 20) {
            $errors['body_error'] = "Description must have at least 20 characters.";
        }

        return $errors;
    }

    public static function validatePostReply($data)
    {
        $errors = [
            'reply_error' => ''
        ];

        if (empty($data['body'])) {
            $errors['reply_error'] = "Reply cannot be empty.";
        } else if (strlen($data['body']) < 3) {
            $errors['reply_error'] = "Reply must have at least 3 characters.";
        }

        return $errors;
    }
}