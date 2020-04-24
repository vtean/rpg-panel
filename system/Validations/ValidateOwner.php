<?php
/**
 * @brief Owner page forms validation.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

trait ValidateOwner
{
    public static function validateMaintenance($data)
    {
        $errors = [
            'message_error' => ''
        ];

        if (empty($data['maintenance_message']) && $data['maintenance_status'] == 1) {
            $errors['message_error'] = "Maintenance message cannot be empty";
        }

        return $errors;
    }
}