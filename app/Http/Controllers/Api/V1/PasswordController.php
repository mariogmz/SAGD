<?php

namespace App\Http\Controllers\Api\V1;

use App\Empleado;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['postEmail', 'postReset']]);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEmail(Request $request)
    {
        $this->authorize($this);
        if (!$request->has('email')) {
            return response()->json([
                'message' => 'No se envio el correo',
                'error' => 'Email invalido'
                ], 422);
        }

        $this->validate($request, ['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return response()->json([
                    'message' => 'Correo con link para reestablecer contraseña enviado correctamente'
                    ], 200);
            case Password::INVALID_USER:
                return response()->json([
                    'message' => 'No se envio el correo',
                    'error' => 'Usuario invalido'
                    ], 400);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(Request $request)
    {
        $this->authorize($this);
        if (
            !$request->has('token') &&
            !$request->has('email') &&
            !$request->has('password') &&
            !$request->has('password_confirmation')
           ) {
            return response()->json([
                'message' => 'No se reestablecio la contraseña',
                'error' => 'Faltan parametros'
                ], 422);
        }
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return response()->json([
                    'message' => 'La contraseña fue reestablecida correctamente'
                    ], 200);

            default:
                return response()->json([
                    'message' => 'No se pudo reestablecer la contraseña',
                    'error' => ['email' => trans($response)]
                    ], 400);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = bcrypt($password);

        if ($user->morphable_type == Empleado::class) {
            $user->morphable->fecha_cambio_password = Carbon::now();
            $user->morphable->save();
        }

        $user->save();

        Auth::login($user);
    }
}
