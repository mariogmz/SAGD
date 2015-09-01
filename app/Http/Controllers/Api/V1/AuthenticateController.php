<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{

    protected $user;

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
        $this->user = JWTAuth::toUser($token);
        $this->setLastLoginToEmployee();

        return response()->json(compact('token'));
    }

    public function getAuthenticatedEmpleado()
    {
        $this->user = $this->getUser();
        $empleado = $this->getEmpleado();
        return response()->json(compact('empleado'));
    }

    public function logout(Request $request)
    {
        $this->user = $this->getUser();
        if ( $this->user ) {
            JWTAuth::invalidate();
            return response()->json(['success' =>  'user logged out successfuly'], 200);
        }
    }

    private function getUser()
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }
        return $user;
    }

    private function getEmpleado()
    {
        if( get_class($this->user->morphable) === 'App\Empleado' ) {
            return $this->user->morphable;
        }
    }

    private function setLastLoginToEmployee()
    {
        $empleado = $this->getEmpleado();
        $empleado->fecha_ultimo_ingreso = \Carbon\Carbon::now('America/Mexico_City');
        if(! $empleado->save() ) {
            return response()->json(['error' => 'Could not set last login time for employee'], 500);
        }
    }
}
