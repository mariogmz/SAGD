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
 * @property-read \App\Domicilio $domicilio
 * @property-read \App\Cliente $cliente
 */
class DomicilioCliente extends LGGModel {

    protected $table = "domicilios_clientes";
    public $timestamps = false;
    protected $fillable = ['domicilio_id','cliente_id'];

    public static $rules = [
        'domicilio_id' => 'required|integer|unique_with:domicilios_clientes, cliente_id',
        'cliente_id' => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        DomicilioCliente::creating(function (DomicilioCliente $dc) {
            return $dc->isValid();
        });

        DomicilioCliente::updating(function(DomicilioCliente $dc){
            $dc->updateRules = self::$rules;
            $dc->updateRules['domicilio_id'] = 'required|integer|unique_with:domicilios_clientes, cliente_id,' . $dc->id;
            return $dc->isValid('update');
        });
    }

    /**
     * Obtiene el Domicilio asociado a esta relación
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domicilio(){
        return $this->belongsTo('App\Domicilio');
    }

    /**
     * Obtiene el Cliente asociado a esta relación
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente(){
        return $this->belongsTo('App\Cliente');
    }

}
