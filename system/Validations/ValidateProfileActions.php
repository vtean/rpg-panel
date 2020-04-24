<?php
/**
 * @brief Profile actions validation.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

trait ValidateProfileActions
{
    public static function validateSuspend($data)
    {
        $errors = [
            'days_error' => '',
            'reason_error' => ''
        ];

        if (empty($data['suspend_time'])) {
            $errors['days_error'] = "Suspend time cannot be empty.";
        } else if ($data['suspend_time'] > 999) {
            $errors['days_error'] = "You entered too many days.";
        }

        if (empty($data['suspend_reason'])) {
            $errors['reason_error'] = "Reason cannot pe empty.";
        } else if (strlen($data['suspend_reason']) < 3) {
            $errors['reason_error'] = "Reason must have at least 3 characters.";
        }

        return $errors;
    }
}