<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApiTokenRequest;
use App\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MailerLiteTokenController extends Controller
{
    public function index()
    : RedirectResponse
    {
        if (Setting::has('mailerlite_api_token')) {
            return redirect()->route('subscribers.index');
        }

        return redirect()->route('mailerlite.token.create');
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {

        return view('mailerlite.token-form');
    }

    /**
     * @param  StoreApiTokenRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(StoreApiTokenRequest $request)
    : RedirectResponse {
        $mailerLiteApiToken = $request->input('api_token');

        // Save the valid token in the database
        Setting::set('mailerlite_api_token', $mailerLiteApiToken);

        return redirect()->back()->with('success', 'API key saved successfully!');

    }
}
