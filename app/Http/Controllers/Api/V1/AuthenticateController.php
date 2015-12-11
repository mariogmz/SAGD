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
        $this->middleware('jwt.auth', ['except' => ['authenticate', 'verify']]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = $this->attemptLogin($credentials)) {
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

    public function verify(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (empty($credentials)) {
            return response()->json([], 400);
        }
        $token = JWTAuth::attempt($credentials);
        if (empty($token)) {
            return response()->json([], 400);
        }
        \Log::error("ouiasdgfudsa");
        return response()->json([], 200);
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
            $user = $this->user;
            return $this->user->morphable
                ->with('sucursal', 'user')
                ->whereHas('user', function($query) use ($user) {
                    $query->where('email', $user->email);
                })
                ->first();
        }
    }

    private function setLastLoginToEmployee()
    {
        $this->empleado = $this->getEmpleado();
        $today = Carbon::now('America/Mexico_City');
        if( $this->empleado->update(['fecha_ultimo_ingreso' => $today]) ) {
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

    /**
     * Intentar crear el token basandose primero por el email y despues por el
     * nombre de usuario del Empleado.
     * @param array $credentials
     * @return string
     */
    private function attemptLogin($credentials)
    {
        if ($this->isEmail($credentials['email'])) {
            return $this->attemptLoginWithEmail($credentials);
        } else {
            return $this->attemptLoginWithUsuario($credentials);
        }
    }

    /**
     * Intenta hacer el login con las credenciales email y password
     * @param array $credentials
     * @return false|string
     */
    private function attemptLoginWithEmail($credentials)
    {
        $token = JWTAuth::attempt($credentials);
        return $token ?: $this->intentoDeLogin($credentials['email'], 0);
    }

    /**
     * Busca un usuario con el parametro de email. Si lo encuentra intenta el login
     * con ese email.
     * @param array $credentials
     * @return false|string
     */
    private function attemptLoginWithUsuario($credentials)
    {
        if ($this->empleado = Empleado::whereUsuario($credentials['email'])->first()) {
            if ($user = $this->empleado->user) {
                $credentials['email'] = $user->email;
                return $this->attemptLoginWithEmail($credentials);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Verifica si el parametro es un email valido o no
     * Emails validos incluyen:
     * correo@dominio.com
     * correo@dominio.com.mx
     *
     * Emails no validos:
     * correo@dominio.mx
     * correo@dominio.com.mx.zg
     * @param string
     * @return 0|1|FALSE
     */
    private function isEmail($email)
    {
        return preg_match('/[\w]+@[\w]+\.com(\.[a-z]{2,})?$/', $email);
    }
}
