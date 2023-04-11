<?php

namespace App\Services;

use Exception;
use MailerLite\MailerLite;

class MailerliteService
{

    public function validateToken($mailerLiteApiToken)
    {
        $mailerLite = new MailerLite(['api_key' => $mailerLiteApiToken]);
        try {
            $mailerLite->subscribers->get();

            return true;
        } catch (Exception $e) {
            return false;
        }

    }
}
