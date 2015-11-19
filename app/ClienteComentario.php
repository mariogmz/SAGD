<?php

namespace App;


/**
 * App\ClienteComentario
 *
 * @property integer $id
 * @property string $comentario
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $cliente_id
 * @property integer $empleado_id
 * @property-read \App\Cliente $cliente
 * @property-read \App\Empleado $empleado
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteComentario whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteComentario whereComentario($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteComentario whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteComentario whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteComentario whereClienteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteComentario whereEmpleadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteComentario whereDeletedAt($value)
 */
class ClienteComentario extends LGGModel {

    //
    protected $table = "clientes_comentarios";
    public $timestamps = false;
    protected $fillable = ['comentario', 'cliente_id', 'empleado_id'];

    public static $rules = [
        'comentario'  => 'required|max:200',
        'cliente_id'  => 'required|integer',
        'empleado_id' => 'required|integer',
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        ClienteComentario::creating(function ($cc) {
            if (!$cc->isValid()) {
                return false;
            }

            return true;
        });
        ClienteComentario::updating(function ($cc) {
            $cc->updateRules = self::$rules;

            return $cc->isValid('update');
        });
    }


    /**
     * Obtiene el Cliente asociado con el Comentario
     * @return App\Cliente
     */
    public function cliente() {
        return $this->belongsTo('App\Cliente', 'cliente_id');
    }


    /**
     * Obtiene el Empleado asociado con el Comentario
     * @return App\Empleado
     */
    public function empleado() {
        return $this->belongsTo('App\Empleado', 'empleado_id');
    }
}
