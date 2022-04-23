<?php

namespace App\Services;

use App\Exceptions\InvalidFieldException;
use App\Exceptions\InvalidSearchTermException;
use App\Exceptions\InvalidStateException;
use App\Http\Resources\SubscriberResource;
use App\Models\State;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class SubscriberService
{
    protected $customFieldsService;

    public function __construct(CustomFieldsService $customFieldsService)
    {
        $this->customFieldsService = $customFieldsService;
    }

    public function createSubscriber($request)
    {
        $state = $this->validateState($request->state);

        if ($this->isResponse($state)) {
            return $state;
        }

        $customFields = $this->customFieldsService->setCustomFields($request->fields);

        $subscriber = Subscriber::create([
            'name' => $request->name,
            'email_address' => $request->email_address,
            'state_id' => $state->id,
        ]);

        if (!empty($customFields)) {
            $subscriber->setManyMeta($customFields);
        }

        return response(['subscriber' => new SubscriberResource($subscriber), 'status' => 'SUCCESS'], 201);
    }

    public function updateSubscriber(Request $request, Subscriber $subscriber)
    {
        $subscriber->update($request->only('name', 'email_address'));

        if (isset($request->state)) {

            $state = $this->validateState($request->state);
            $subscriber->update(['state_id' => $state->id]);
        }

        if (isset($request->fields)) {

            $fields = $this->customFieldsService->setCustomFields($request->fields);

            $this->updateCustomFields($subscriber, $fields);
        }

        return response(['subscriber' => new SubscriberResource($subscriber), 'status' => 'SUCCESS'], 200);
    }

    public function search($searchBy, $query) {
        if (! in_array($searchBy, config('subscriber.search_terms.allowed'))) {
            throw  new InvalidSearchTermException();
        }

        if ($searchBy == 'state') {
            $state = $this->validateState($query);
            $results = Subscriber::where('state_id', $state->id)->get();
        } else {
            $results = Subscriber::where($searchBy, 'like', '%'. $query . '%')->get();
        }

        if ($results->isEmpty()) {
            return response([
                'message' => "Sorry! No results matching {$searchBy} is {$query} were found",
                'status' => 'SUCCESS',
            ], 200);
        }

        return response([
            'results' => SubscriberResource::collection($results),
            'status' => 'SUCCESS',
        ], 200);
    }


    private function updateCustomFields($subscriber, $customFields)
    {
        $fieldsToUpdate = [];
        $fieldsToCreate = [];

        foreach ($customFields as $key => $value) {
            if ($subscriber->hasMeta($key)) {
                $fieldsToUpdate[$key] = $value;
            } else {
                $fieldsToCreate[$key] = $value;
            }
        }

        $subscriber->syncMeta($fieldsToUpdate);
        $subscriber->setManyMeta($fieldsToCreate);
    }

    private function validateState($inputState)
    {
        try {
            $state = State::where('name', $inputState)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new InvalidStateException();
        }

        return $state;
    }

    private function isResponse($object)
    {
        return is_object($object) && isset($object->headers);
    }
}
