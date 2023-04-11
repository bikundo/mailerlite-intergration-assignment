<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use MailerLite\MailerLite;

class MailerLiteController extends Controller
{
    public function home()
    {
        if (Setting::has('mailer_lite_api_token')) {
            return redirect()->route('mailerlite.index');
        }

        return redirect()->route('mailerlite.token.create');
    }

    public function createApiToken()
    {

        return view('mailerlite.token-form');
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function validateApiKey(Request $request)
    : RedirectResponse {
        $mailerLiteApiToken = $request->input('api_token');
        $mailerLite = new MailerLite($mailerLiteApiToken);

        try {
            $mailerLite->subscribers->get();
            // Save the valid key in the database
            Setting::set('mailer_lite_api_token', $mailerLiteApiToken);

            return redirect()->back()->with('success', 'API key saved successfully!');
        } catch (Exception $e) {
            // The API key is invalid
            return redirect()->back()->with('error', 'Invalid API key!');
        }
    }
}
