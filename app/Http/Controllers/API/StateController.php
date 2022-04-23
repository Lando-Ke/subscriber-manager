<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\StateResource;
use Illuminate\Support\Facades\Validator;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            'states' => StateResource::collection(State::with('subscribers')->paginate(25)),
            'status' => 'SUCCESS'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\State $state
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, State $state)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name'      => 'required|max:255|unique:states',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $state = State::create($data);

        return response([ 'state' => new StateResource($state), 'status' => 'SUCCESS'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\State $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        return response(['state' => new StateResource($state), 'status' => 'SUCCESS'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\State $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        $state->update($request->all());

        return response([ 'state' => new StateResource($state), 'status' => 'SUCCESS'], 200);
    }
}
