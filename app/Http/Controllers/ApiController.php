<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = [
            [
                'id' => 1,
                'title' => 'The Hunger',
                'author' => 'Whitley Strieber',
                'format' => 'paperback',
            ],
            [
                'id' => 2,
                'title' => 'A Pocket Style Guide',
                'author' => 'Various',
                'format' => 'spiral-bound',
            ],
            [
                'id' => 3,
                'title' => 'Confessing One Faith',
                'format' => 'paperback',
            ]
        ];

        // Trigger SQL.
        $u = User::get();

        Log::debug('Data:', ['data' => $data]);

        return response()->json($data, 200);
    }
}
