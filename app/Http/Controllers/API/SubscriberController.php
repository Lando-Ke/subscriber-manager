<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriberResource;
use App\Models\Subscriber;
use App\Services\SubscriberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response([
            'subscribers' => SubscriberResource::collection(Subscriber::with('state')->paginate(25)),
            'status' => 'SUCCESS'
        ], 206);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\SubscriberService $subscriberService
     * @return \App\Http\Resources\SubscriberResource|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request, SubscriberService $subscriberService)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email_address' => 'required|unique:subscribers',
            'state' => 'required',
            'fields' => 'array|min:1'
        ]);

        if ($validator->fails()) {
            return response(['status' => 'ERROR', 'error' => $validator->errors()]);
        }

        return $subscriberService->createSubscriber($request);
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
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subscriber $subscriber
     * @param \App\Services\SubscriberService $subscriberService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscriber $subscriber, SubscriberService $subscriberService)
    {
        return $subscriberService->updateSubscriber($request, $subscriber);
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
