<?php

namespace App;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * App\User
 *
 */
class User extends LGGModel implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password', 'morphable_id', 'morphable_type'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'updated_at',
        'created_at', 'deleted_at'];

    public static $rules = [
        'email' => 'required|email|max:60|unique:users,email',
        'morphable_id' => 'required|integer',
        'morphable_type' => 'required|string'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        User::creating(function ($user){
            return $user->isValid();
        });
        User::updating(function($user){
            $user->updateRules = self::$rules;
            $user->updateRules['email'] .= ','.$user->id;
            return $user->isValid('update');
        });
    }


    /**
    * Obtiene el modelo asociado con el User
    * @return App\Cliente | App\Empleado
    */
    public function morphable()
    {
        return $this->morphTo();
    }
}
