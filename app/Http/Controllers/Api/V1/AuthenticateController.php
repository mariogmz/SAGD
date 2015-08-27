<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = JWTAuth::toUser($token);
        $this->setLastLoginToEmployee($user);

        return response()->json(compact('token'));
    }

    public function logout(Request $request)
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }
        if ( $user ) {
            JWTAuth::invalidate();
            return response()->json(['success' =>  'user logged out successfuly'], 200);
        }
    }

    private function setLastLoginToEmployee($user)
    {
        if( get_class($user->morphable) === 'App\Empleado' ) {
            $user->morphable->fecha_ultimo_ingreso = \Carbon\Carbon::now('America/Mexico_City');
            if(! $user->morphable->save() ) {
                return response()->json(['error' => 'Could not set last login time for employee'], 500);
            }
        }
    }
}
