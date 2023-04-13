<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubscriberRequest;
use App\Models\Setting;
use App\Services\MailerliteService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
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
     * @return Application|Factory|View|RedirectResponse
     */
    public function index()
    {
        if (!Setting::has('mailerlite_api_token')) {
            return redirect()->route('mailerlite.token.create');
        }

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
                $deleteButton = "<a class='btn btn-sm btn-danger deleteUser' data-id='" . $row['id'] . "'><i class='fa-solid fa-trash'></i>delete</a>";

                return $deleteButton;

            })
            ->editColumn('email', function ($row) {
                return '<a href="' . route('subscribers.edit', $row['id']) . '">' . $row['email'] . '</a>';
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
     * @return JsonResponse
     */
    public function show($id)
    {
        $mailerLite = new MailerLite(['api_key' => Setting::value('mailerlite_api_token')]);

        try {
            $response = $mailerLite->subscribers->find($id);

            return response()->json(['data' => Arr::get($response, 'body.data')]);
        } catch (Exception $ex) {

            return response()->json(['message' => 'Resource not found.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Application|Factory|View
     */
    public function edit(string $id)
    {
        $mailerLite = new MailerLite(['api_key' => Setting::value('mailerlite_api_token')]);
        $subscriber = $mailerLite->subscribers->find($id);

        $sanitizedData = (new MailerliteService())->cleanRow(Arr::get($subscriber, 'body.data', []));

        return view('subscribers.edit')->with('subscriber', $sanitizedData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int      $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $mailerLite = new MailerLite(['api_key' => Setting::value('mailerlite_api_token')]);
        $data = collect([]);
        $data->put('fields', $request->only(['name', 'country']));

        $mailerLite->subscribers->update($id, $data->toArray());

        return redirect()->route('subscribers.index')->with('message', 'subscriber successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $mailerLite = new MailerLite(['api_key' => Setting::value('mailerlite_api_token')]);

        try {
            $mailerLite->subscribers->delete($id);

            return response()->json(['message' => 'Subscriber deleted Successfully']);
        } catch (Exception $ex) {

            return response()->json(['message' => 'Resource not found.'], 404);
        }
    }
}
