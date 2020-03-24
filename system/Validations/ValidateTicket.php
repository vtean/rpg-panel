<?php
/**
 * @brief Ticket creating validation.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

trait ValidateTicket
{
    public static function validate($data)
    {
        $errors = [
            'ticket_body_error' => '',
            'ticket_category_error' => ''
        ];

        // check if ticket name field is empty
        if (empty($data['body'])) {
            $errors['ticket_body_error'] = "Please enter the ticket body.";
        } else if (strlen($data['body']) < 50) {
            $errors['ticket_body_error'] = "The ticket body must have at least 50 characters.";
        }

        if (empty($data['category_id'])) {
            $errors['ticket_category_error'] = "Please choose the ticket category.";
        }

        return $errors;
    }
}