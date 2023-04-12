<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubscriberRequest;
use App\Models\Setting;
use App\Services\MailerliteService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use MailerLite\MailerLite;
use Yajra\DataTables\Facades\DataTables;

class SubscriberController extends Controller
{
    /**
     * Display a listing of all subscribers on the API.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('subscribers.index');
    }

    public function datatables(Request $request)
    {
        $limit = $request->get('length', 10);
        $mailerLite = new MailerLite(['api_key' => Setting::value('mailerlite_api_token')]);
        $subscribers = $mailerLite->subscribers->get(['limit' => $limit]);

        $sanitizedData = (new MailerliteService())->sanitizeData(Arr::get($subscribers, 'body.data', []));

        return DataTables::collection($sanitizedData)
            ->addColumn('actions', function ($row) {

                // Delete Button
                $deleteButton = "<a class='btn btn-sm btn-danger deleteUser' data-id='" . $row['email'] . "'><i class='fa-solid fa-trash'></i>delete</a>";

                return $deleteButton;

            })
            ->editColumn('email', function ($row) {
                return '<a href="#">' . $row['email'] . '</a>';
            })
            ->rawColumns(['actions', 'email'])
            ->toJson();
    }

    /**
     * Show the form for creating a new subscriber.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('subscribers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSubscriberRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(CreateSubscriberRequest $request)
    {
        $mailerLite = new MailerLite(['api_key' => Setting::value('mailerlite_api_token')]);
        $data = collect([]);
        $data->put('email', $request->email);
        $data->put('fields', $request->only(['name', 'country']));

        $response = $mailerLite->subscribers->create($data->toArray());
        $statusCode = $response['status_code'];
        if ($statusCode === 201) {
            return redirect()->back()->with('message', 'subscriber successfully saved!');

        }

        return redirect()->back()->with('message', 'subscriber already exists!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int      $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $email
     *
     * @return string
     */
    public function destroy($email)
    {
        $mailerLite = new MailerLite(['api_key' => Setting::value('mailerlite_api_token')]);

        try {
            $mailerLite->subscribers->delete($email);

            return 'Subscriber deleted Successfully';
        } catch (Exception $ex) {

            return 'Resource not found.';
        }
    }
}
