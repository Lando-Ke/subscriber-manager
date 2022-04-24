<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberRequest;
use App\Http\Resources\SubscriberCollection;
use App\Http\Resources\SubscriberResource;
use App\Models\Subscriber;
use App\Services\SubscriberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response([
            'subscribers' => new SubscriberCollection(Subscriber::with('fields')->orderBy('created_at', 'DESC')->paginate(50)),
            'status' => 'SUCCESS',
        ], 206);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\SubscriberRequest $request
     * @return \App\Http\Resources\SubscriberResource|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(SubscriberRequest $request)
    {

        $subscriber = Subscriber::create($request->validated());

        return new SubscriberResource($subscriber);
    }

    /**
     * Display the specified resource.
     *
     * @param $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        return response(['subscriber' => new SubscriberResource($subscriber), 'status' => 'SUCCESS'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\SubscriberRequest $request
     * @param \App\Models\Subscriber $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(SubscriberRequest $request, Subscriber $subscriber)
    {

        $subscriber->update($request->validated());
        return response(['subscriber' => new SubscriberResource($subscriber), 'status' => 'SUCCESS'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Subscriber $subscriber
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return response()->json(null, 204);
    }

    public function search($searchBy, $query, SubscriberService $subscriberService)
    {
        return $subscriberService->search($searchBy, $query);
    }
}
