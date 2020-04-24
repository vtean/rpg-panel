<?php
/**
 * @brief Questions validation.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

trait ValidateFApplication
{
    public static function validateInput($data)
    {
        $errors = [
            'question_error' => ''
        ];

        if (empty($data['question_body'])) {
            $errors['question_error'] = "Question cannot pe empty.";
        } else if (strlen($data['question_body']) < 5) {
            $errors['question_error'] = "Question must have at least 5 characters.";
        }

        return $errors;
    }

    public static function validateApp($data)
    {
        $errors = array();

        for ($i = 1; $i <= $data['questionsNumber']; $i++) {
            $errors['answer' . $i . '_error'] = '';
        }

        for ($i = 1; $i <= $data['questionsNumber']; $i++) {
            if (empty($data['answer' . $i])) {
                $errors['answer' . $i . '_error'] = "This field cannot be empty.";
            } else if (strlen($data['answer' . $i]) < 2) {
                $errors['answer' . $i . '_error'] = "Your answer must have at least 2 characters.";
            }
        }

        return $errors;
    }
}