<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            ]);

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => env('PASSWORD_GRANT_CLIENT_ID'),
            'client_secret' => env('PASSWORD_GRANT_CLIENT_SECRET'),
            'username' => $request->username,
            'password' => $request->password
        ]);

        $requestToken = Request::create(env('APP_URL') . '/oauth/token','post');

        //hitting the request
        $response = Route::dispatch($requestToken);
        return $response;
    }

    public function destroy(Request $request)
    {
         $request->user()->token()->revoke();
         return response()->noContent();
    }
}
