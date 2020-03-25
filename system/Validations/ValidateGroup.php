<?php
/**
 * @brief Group creating validation.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

trait ValidateGroup
{
    public static function validate($groupData, $groupCheck)
    {
        $errors = [
            'group_name_error' => ''
        ];

        // check if group name field is ok
        if (empty($groupData['group_name'])) {
            $errors['group_name_error'] = "Please enter the group name.";
        } else if (strlen($groupData['group_name']) < 3) {
            $errors['group_name_error'] = "The group name must have at least 3 characters.";
        } else if ($groupCheck != false && (strcasecmp($groupCheck['group_name'], $groupData['group_name']) == 0) && isset($groupData['create_group'])) {
            $errors['group_name_error'] = "A group with this name already exists.";
        }

        // check if group keyword field is ok
        if (empty($groupData['group_keyword'])) {
            $errors['group_keyword_error'] = "Please enter the group keyword.";
        } else if (strlen($groupData['group_keyword']) < 3) {
            $errors['group_keyword_error'] = "The group keyword must have at least 3 characters.";
        }

        return $errors;
    }
}