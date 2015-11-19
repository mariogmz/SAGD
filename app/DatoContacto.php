<?php

namespace App;

use App\Events\PostEmpleadoCreado;
use App\Events\DatoContactoActualizado;

/**
 * App\DatoContacto
 *
 * @property integer $id
 * @property integer $empleado_id
 * @property string $direccion
 * @property string $telefono
 * @property string $email
 * @property string $skype
 * @property string $fotografia_url
 * @property-read \App\Empleado $empleado
 * @method static \Illuminate\Database\Query\Builder|\App\DatoContacto whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DatoContacto whereEmpleadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DatoContacto whereDireccion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DatoContacto whereTelefono($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DatoContacto whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DatoContacto whereSkype($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DatoContacto whereFotografiaUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\DatoContacto whereDeletedAt($value)
 */
class DatoContacto extends LGGModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'datos_contactos';

    public $timestamps = false;
    protected $fillable = ['direccion', 'telefono', 'email', 'skype', 'fotografia_url', 'empleado_id'];
    public static $rules = [
        'direccion'      => 'string|max:100',
        'telefono'       => 'string|max:20',
        'email'          => 'email|unique:datos_contactos',
        'skype'          => 'string',
        'fotografia_url' => 'url',
        'empleado_id'    => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        DatoContacto::creating(function ($dato_contacto) {
            if (!$dato_contacto->isValid()) {
                return false;
            }

            return true;
        });
        DatoContacto::updating(function ($dato_contacto) {
            $dato_contacto->updateRules = self::$rules;
            $dato_contacto->updateRules['email'] .= ',email,' . $dato_contacto->id;

            return $dato_contacto->isValid('update');
        });
        DatoContacto::created(function ($dato_contacto) {
            event(new PostEmpleadoCreado($dato_contacto));
        });
        DatoContacto::updated(function ($dato_contacto) {
            event(new DatoContactoActualizado($dato_contacto));
        });
    }

    /**
     * Obtiene el empleado asociado al dato de contacto
     * @return App\Empleado
     */
    public function empleado() {
        return $this->belongsTo('App\Empleado');
    }

}
