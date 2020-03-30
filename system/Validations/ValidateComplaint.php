<?php
/**
 * @brief Complaint creating validation.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

trait ValidateComplaint
{
    public static function validate($complaintData, $userCheck)
    {
        $errors = [
            'username_error' => '',
            'description_error' => '',
            'proof_error' => '',
        ];

        // check if user field is empty
        if (empty($complaintData['against_name'])) {
            $errors['username_error'] = "Please type player's username.";
        }
        else if (strlen($complaintData['against_name']) < 3) {
            $errors['username_error'] = "Username must have at least 3 characters.";
        } else if ($userCheck == false) {
            $errors['username_error'] = "Sorry, we couldn't find any account with this username";
        } else if ((strcasecmp($userCheck['ID'], $_SESSION['user_id']) == 0) && isset($_POST['create_complaint'])) {
            $errors['username_error'] = "You cannot create a complaint against yourself.";
        }

        // check if complaint description field is empty
        if (empty($complaintData['complaint_desc'])) {
            $errors['description_error'] = "Complaint description cannot be empty.";
        } else if (strlen($complaintData['complaint_desc']) < 5) {
            $errors['description_error'] = "Description must have at least 5 characters.";
        }

        // check if complaint proof is empty
        if (empty($complaintData['complaint_proof'])) {
            $errors['proof_error'] = "You can't post a complaint without proof.";
        } else if (strlen($complaintData['complaint_proof']) < 5) {
            $errors['proof_error'] = "Your link must have at least 5 characters.";
        }

        return $errors;
    }

    public static function validateReply($data)
    {
        $errors = [
            'reply_error' => ''
        ];

        // check if complaint reply is empty
        if (empty($data['body'])) {
            $errors['reply_error'] = "Your reply cannot be empty.";
        } else if (strlen($data['body']) < 5) {
            $errors['reply_error'] = "Reply must have at least 5 characters.";
        }

        return $errors;
    }
}