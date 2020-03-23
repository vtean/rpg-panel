<?php
/**
 * @brief LoginController input validation
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

trait ValidateLogin
{
    public static function validateInput($userData, $userCheck)
    {
        $errors = [
            'user_name_error' => '',
            'user_password_error' => ''
        ];

        // check if the username field is empty
        if (empty($userData['user_name'])) {
            $errors['user_name_error'] = "Please type your username.";
            // check if an user with this username exists in the database
        } else if ($userCheck == false) {
            $errors['user_name_error'] = "Sorry, we could not find any account with this username.";
        }

        // check if the password if empty
        if (empty($userData['user_password'])) {
            $errors['user_password_error'] = "Type your password to be able to login.";
            // check if typed password matches the account's one
        } else if ($userCheck != false && $userData['user_password'] != $userCheck['Password']) {
            $errors['user_password_error'] = "You entered a wrong password.";
        }

        return $errors;
    }

    public static function validateSecret($secret, $verify)
    {
        $errors = [
            'secret_error' => ''
        ];

        if (empty($secret)) {
            $errors['secret_error'] = "Please type your secret code.";
        } else if (strlen($secret) < 6 || strlen($secret) > 6) {
            $errors['secret_error'] = "The entered code must have exactly 6 digits.";
        } else if (!$verify) {
            $errors['secret_error'] = "Incorrect secret code.";
        }

        return $errors;
    }

    public static function validateSecretEmail($secret, $verify)
    {
        $errors = [
            'secret_error' => ''
        ];

        if (empty($secret)) {
            $errors['secret_error'] = "Please type your email code.";
        } else if (strlen($secret) < 6 || strlen($secret) > 6) {
            $errors['secret_error'] = "The entered code must have exactly 6 digits.";
        } else if (!$verify) {
            $errors['secret_error'] = "Incorrect email code.";
        }

        return $errors;
    }
}