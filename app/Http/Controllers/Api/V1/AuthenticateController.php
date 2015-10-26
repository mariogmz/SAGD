<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\User;
use App\Empleado;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{

    protected $user;
    protected $empleado;

    public function __construct(User $user, Empleado $empleado)
    {
        $this->user = $user;
        $this->empleado = $empleado;
        $this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                $this->intentoDeLogin($request->only('email'), 0);
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
            $noop = $this->user->morphable->user;
            return $this->user->morphable;
        }
    }

    private function setLastLoginToEmployee()
    {
        $this->empleado = $this->getEmpleado();
        $today = Carbon::now('America/Mexico_City');
        $this->empleado->fecha_ultimo_ingreso = $today;
        if( $this->empleado->save() ) {
            $this->intentoDeLogin($this->empleado->user->email, 1);
        } else {
            return response()->json(['error' => 'Could not set last login time for employee'], 500);
        }
    }

    /**
     * Establece un intento de login para el empleado (si fue empleado).
     *
     * @param string email
     * @param bool|int $exitoso
     * @return void
     */
    private function intentoDeLogin($email, $exitoso)
    {
        if( $this->empleado = $this->empleado->whereEmail($email) ){
            $this->empleado->logsAccesos()->create(['exitoso' => $exitoso]);
        }
    }
}
