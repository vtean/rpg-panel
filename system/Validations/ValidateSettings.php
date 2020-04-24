<?php
/**
 * @brief Resignations validation.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

trait ValidateSettings
{
    public static function validateEmailChange($data, $userInfo)
    {
        $errors = [
            'email_error' => '',
            'confirm_pass_error' => ''
        ];

        if (empty($data['new_email'])) {
            $errors['email_error'] = "Please enter new email.";
        }

        if (empty($data['confirm_password'])) {
            $errors['confirm_pass_error'] = "Please enter your password.";
        } else if ($userInfo == false || $userInfo != false && !password_verify($data['confirm_password'], $userInfo['Password'])) {
            $errors['confirm_pass_error'] = "You entered wrong password.";
        }

        return $errors;
    }

    public static function validateForumNameChange($data)
    {
        $errors = [
            'forum_name_error' => ''
        ];

        if (empty($data['forum_nickname'])) {
            $errors['forum_name_error'] = "Please enter your forum name.";
        } else if (strlen($data['forum_nickname']) < 3) {
            $errors['forum_name_error'] = "Your name must have at least 3 characters.";
        }

        return $errors;
    }

    public static function validatePasswordChange($data, $userInfo)
    {
        $errors = [
            'current_pass_error' => '',
            'new_pass_error' => '',
            'new_pass_conf_error' => ''
        ];

        if (empty($data['current_password'])) {
            $errors['current_pass_error'] = "Please enter your password.";
        } else if ($userInfo == false || !password_verify($data['current_password'], $userInfo['Password'])) {
            $errors['current_pass_error'] = "You entered wrong password.";
        }

        if (empty($data['new_password'])) {
            $errors['new_pass_error'] = "Please enter your new password.";
        } else if (strlen($data['new_password']) < 6) {
            $errors['new_pass_error'] = "Your password must have at least 6 characters.";
        }

        if (empty($data['confirm_new_password'])) {
            $errors['new_pass_conf_error'] = "Please confirm your new password.";
        } else if (strcmp($data['new_password'], $data['confirm_new_password']) != 0) {
            $errors['new_pass_conf_error'] = "The two passwords do not match.";
        }

        return $errors;
    }

    public static function validateEmailCode($data, $emailCode)
    {
        $errors = [
            'secret_code_error' => ''
        ];

        if (empty($data['secret_code'])) {
            $errors['secret_code_error'] = "Please enter the code.";
        } else if (strlen($data['secret_code']) != 6) {
            $errors['secret_code_error'] = "Code must have exactly 6 digits.";
        } else if ($data['secret_code'] != $emailCode) {
            $errors['secret_code_error'] = "You entered a wrong code.";
        }

        return $errors;
    }

    public static function validateEmailCodeDisabling($data, $emailCode, $userInfo)
    {
        $errors = [
            'secret_code_check_error' => '',
            'confirm_user_pass_error' => ''
        ];

        if (empty($data['secret_code_check'])) {
            $errors['secret_code_check_error'] = "Please type the code.";
        } else if (strlen($data['secret_code_check']) != 6) {
            $errors['secret_code_check_error'] = "Code must have exactly 6 digits.";
        } else if ($data['secret_code_check'] != $emailCode) {
            $errors['secret_code_check_error'] = "You entered a wrong code.";
        }

        if (empty($data['confirm_user_pass'])) {
            $errors['confirm_user_pass_error'] = "Please type your password.";
        } else if ($userInfo == false || !password_verify($data['confirm_user_pass'], $userInfo['Password'])) {
            $errors['confirm_user_pass_error'] = "You entered a wrong password.";
        }

        return $errors;
    }

    public static function validateGAuthEnabling($data, $oneCode)
    {
        $errors = [
            'g_auth_code_error' => ''
        ];

        if (empty($data['g_auth_code'])) {
            $errors['g_auth_code_error'] = "Please enter the secret code.";
        } else if (strlen($data['g_auth_code']) != 6) {
            $errors['g_auth_code_error'] = "Code must has exactly 6 digits";
        } else if ($data['g_auth_code'] != $oneCode) {
            $errors['g_auth_code_error'] = "You entered a wrong code.";
        }

        return $errors;
    }

    public static function validateGAuthDisabling($data, $emailCode, $userInfo)
    {
        $errors = [
            'g_auth_code_check_error' => '',
            'confirm_user_pass_error' => ''
        ];

        if (empty($data['g_auth_code_check'])) {
            $errors['g_auth_code_check_error'] = "Please type the code.";
        } else if (strlen($data['g_auth_code_check']) != 6) {
            $errors['g_auth_code_check_error'] = "Code must have exactly 6 digits.";
        } else if ($data['g_auth_code_check'] != $emailCode) {
            $errors['g_auth_code_check_error'] = "You entered a wrong code.";
        }

        if (empty($data['confirm_auth_pass'])) {
            $errors['confirm_auth_pass_error'] = "Please type your password.";
        } else if ($userInfo == false || !password_verify($data['confirm_auth_pass'], $userInfo['Password'])) {
            $errors['confirm_auth_pass_error'] = "You entered a wrong password.";
        }

        return $errors;
    }
}