<?php

namespace App\Services;

use App\Exceptions\InvalidFieldException;
use App\Exceptions\InvalidSearchTermException;
use App\Exceptions\InvalidStateException;
use App\Http\Resources\SubscriberCollection;
use App\Http\Resources\SubscriberResource;
use App\Models\State;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class SubscriberService
{
    public function search($searchBy, $query) {
        if (! in_array($searchBy, config('subscriber.search_terms.allowed'))) {
            throw  new InvalidSearchTermException();
        }

        if ($searchBy == 'state') {
            $state = $this->validateState($query);
            $results = Subscriber::where('state_id', $state->id)->paginate();
        } else {
            $results = Subscriber::where($searchBy, 'like', '%'. $query . '%')->paginate();
        }

        if ($results->isEmpty()) {
            return response([
                'message' => "Sorry! No results matching {$searchBy} is {$query} were found",
                'status' => 'SUCCESS',
            ], 200);
        }

        return response([
            'results' => new SubscriberCollection($results),
            'status' => 'SUCCESS',
        ], 200);
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
}
