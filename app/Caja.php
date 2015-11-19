<?php

namespace App;


/**
 * App\Caja
 *
 * @property integer $id
 * @property string $nombre
 * @property string $mac_addr
 * @property string $token
 * @property integer $iteracion
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $sucursal_id
 * @property-read \App\Sucursal $sucursal
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Corte[] $cortes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\GastoExtra[] $gastosExtras
 * @method static \Illuminate\Database\Query\Builder|\App\Caja whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Caja whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Caja whereMacAddr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Caja whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Caja whereIteracion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Caja whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Caja whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Caja whereSucursalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Caja whereDeletedAt($value)
 */
class Caja extends LGGModel {

    protected $table = "cajas";
    public $timestamps = false;
    protected $fillable = ['nombre', 'mac_addr', 'token', 'iteracion', 'sucursal_id'];

    public static $rules = [
        'nombre'      => 'required|string|max:45',
        'mac_addr'    => 'required|string|max:45',
        'token'       => 'required|string|size:6',
        'iteracion'   => 'required|integer',
        'sucursal_id' => 'required|integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Caja::creating(function ($model) {
            return $model->isValid();
        });
        Caja::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene la sucursal a la cual está asignada la caja
     * @return App\Sucursal
     */
    public function sucursal() {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Obtiene los cortes asociados a esta caja
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function cortes() {
        return $this->hasMany('App\Corte');
    }

    /**
     * Obtiene los gastos extras asociados a la caja
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function gastosExtras() {
        return $this->hasMany('App\GastoExtra');
    }
}
