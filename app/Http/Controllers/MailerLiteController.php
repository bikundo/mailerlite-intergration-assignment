<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApiTokenRequest;
use App\Models\Setting;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use MailerLite\MailerLite;

class MailerLiteController extends Controller
{
    public function home()
    : RedirectResponse
    {
        if (Setting::has('mailerlite_api_token')) {
            return redirect()->route('mailerlite.index');
        }

        return redirect()->route('mailerlite.token.create');
    }

    /**
     * @return Application|Factory|View
     */
    public function createApiToken()
    {

        return view('mailerlite.token-form');
    }

    /**
     * @param  StoreApiTokenRequest  $request
     *
     * @return RedirectResponse
     */
    public function storeApiToken(StoreApiTokenRequest $request)
    : RedirectResponse {
        $mailerLiteApiToken = $request->input('api_token');

        // Save the valid key in the database
        Setting::set('mailerlite_api_token', $mailerLiteApiToken);

        return redirect()->back()->with('success', 'API key saved successfully!');

    }
}
