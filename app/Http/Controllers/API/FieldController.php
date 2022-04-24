<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FieldRequest;
use App\Http\Resources\FieldResource;
use App\Http\Resources\SubscriberResource;
use App\Models\Field;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $subscriber
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($subscriber)
    {
        Subscriber::findOrFail($subscriber);
        return FieldResource::collection(Field::where('subscriber_id', $subscriber)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $subscriber
     * @param \App\Http\Requests\FieldRequest $request
     * @return \App\Http\Resources\SubscriberResource
     */
    public function store($subscriber, FieldRequest $request)
    {
        $subscriber = Subscriber::findOrFail($subscriber);

        $data = $request->validated();
        $data['subscriber_id'] = $subscriber->id;

        Field::create($data);

        return new SubscriberResource($subscriber);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $subscriber
     * @param \App\Http\Requests\FieldRequest $request
     * @param $field
     * @return \App\Http\Resources\SubscriberResource
     */
    public function update($subscriber, FieldRequest $request, Field $field)
    {
        $subscriber = Subscriber::findOrFail($subscriber);

        $data = $request->validated();
        $data['subscriber_id'] = $subscriber->id;

        $field->update($data);

        return new SubscriberResource($subscriber);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $subscriber
     * @param $field
     * @return \App\Http\Resources\SubscriberResource
     */
    public function destroy($subscriber, Field $field)
    {
        $subscriber = Subscriber::findOrFail($subscriber);
        $field->delete();

        return new SubscriberResource($subscriber);
    }
}
