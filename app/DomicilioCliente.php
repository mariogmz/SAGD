<?php

namespace App;


/**
 * App\DomicilioCliente
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $domicilio_id
 * @property integer $cliente_id
 * @method static \Illuminate\Database\Query\Builder|\App\DomicilioCliente whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DomicilioCliente whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DomicilioCliente whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DomicilioCliente whereDomicilioId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DomicilioCliente whereClienteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\DomicilioCliente whereDeletedAt($value)
 */
class DomicilioCliente extends LGGModel {

    //
    protected $table = "domicilios_clientes";
    public $timestamps = false;
    protected $fillable = [];

    public static $rules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        DomicilioCliente::creating(function ($model) {
            if (!$model->isValid()) {
                return false;
            }

            return true;
        });
    }
}
