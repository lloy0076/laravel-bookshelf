<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PingController extends Controller
{
    /**
     * @var string
     */
    protected $phrase = 'pong';

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json($this->phrase, 200);
        }

        return response($this->phrase, 200);
    }
}
