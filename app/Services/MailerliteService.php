<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
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

    public function sanitizeData($data)
    {
        $sanitizedCollection = collect([]);
        foreach ($data as $datum) {
            $sanitizedCollection->push($this->cleanRow($datum));
        }

        return $sanitizedCollection;
    }

    public function cleanRow($rawRowData)
    {
        $rowCollection = collect([]);
        $rowCollection->put('id', Arr::get($rawRowData, 'id'));
        $rowCollection->put('email', Arr::get($rawRowData, 'email'));
        $rowCollection->put('name', Arr::get($rawRowData, 'fields.name'));
        $rowCollection->put('country', Arr::get($rawRowData, 'fields.country'));
        $rowCollection->put('subscribe_date', Carbon::parse(Arr::get($rawRowData, 'subscribed_at'))->toDateString());
        $rowCollection->put('subscribe_time', Carbon::parse(Arr::get($rawRowData, 'subscribed_at'))->toTimeString());

        return $rowCollection->toArray();
    }
}
