<?php

namespace App\Exceptions;

use App\Models\State;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [//
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => str_replace(['App', '\\', 'Models'], '', $exception->getModel()).' not found',
            ], 404);
        }

        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (InvalidFieldException $e, $request) {
            $fields = config('subscriber.fields.allowed');
            $last = array_pop($fields);

            return response()->json([
                'status' => 'ERROR',
                'error' => 'Invalid field passed',
                'help' => 'Fields must have a value and a type of either '.implode(', ', $fields)." or {$last}",
            ], 404);
        });

        $this->renderable(function (InvalidStateException $e, $request) {
            $states = State::all()->pluck('name')->toArray();
            $last = array_pop($states);

            return response([
                'status' => 'ERROR',
                'error' => 'Invalid State used',
                'help' => 'You can only use '.implode(", ", $states)." or {$last}",
            ], 404);
        });

        $this->renderable(function (InvalidSearchTermException $e, $request) {
            $searchTerms = config('subscriber.search_terms.allowed');
            $last = array_pop($searchTerms);

            return response()->json([
                'status' => 'ERROR',
                'error' => 'Invalid search term',
                'help' => 'You can only search by '.implode(', ', $searchTerms)." or {$last}",
            ], 404);
        });
    }
}
