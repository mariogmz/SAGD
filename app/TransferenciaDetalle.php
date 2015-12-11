<?php

namespace App;


/**
 * App\TransferenciaDetalle
 *
 * @property integer $id
 * @property integer $cantidad
 * @property integer $existencia_origen_antes
 * @property integer $existencia_origen_despues
 * @property integer $existencia_destino_antes
 * @property integer $existencia_destino_despues
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $transferencia_id
 * @property integer $producto_id
 * @property integer $producto_movimiento_id
 * @property-read \App\Transferencia $transferencia
 * @property-read \App\Producto $producto
 * @property-read \App\ProductoMovimiento $productoMovimiento
 * @method static \Illuminate\Database\Query\Builder|\App\TransferenciaDetalle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransferenciaDetalle whereCantidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransferenciaDetalle whereExistenciaOrigenAntes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransferenciaDetalle whereExistenciaOrigenDespues($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransferenciaDetalle whereExistenciaDestinoAntes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransferenciaDetalle whereExistenciaDestinoDespues($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransferenciaDetalle whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransferenciaDetalle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransferenciaDetalle whereTransferenciaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransferenciaDetalle whereProductoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransferenciaDetalle whereProductoMovimientoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\TransferenciaDetalle whereDeletedAt($value)
 */
class TransferenciaDetalle extends LGGModel {

    //
    protected $table = "transferencias_detalles";
    public $timestamps = true;
    protected $fillable = ['cantidad', 'cantidad_escaneada', 'existencia_origen_antes',
        'existencia_origen_despues', 'existencia_destino_antes', 'existencia_destino_despues',
        'transferencia_id', 'producto_id', 'producto_movimiento_id'];

    public static $rules = [
        'cantidad'                   => 'required|integer|min:0',
        'cantidad_escaneada'         => 'integer|min:0',
        'existencia_origen_antes'    => 'integer|min:0',
        'existencia_origen_despues'  => 'integer|min:0',
        'existencia_destino_antes'   => 'integer|min:0',
        'existencia_destino_despues' => 'integer|min:0',
        'transferencia_id'           => 'required|integer',
        'producto_id'                => 'required|integer',
        'producto_movimiento_id'     => 'integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        TransferenciaDetalle::creating(function ($model) {
            $model->cantidad_escaneada || $model->cantidad_escaneada = 0;
            return $model->isValid();
        });
        TransferenciaDetalle::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene la Transferencia asociada con el Detalle
     * @return App\Transferencia
     */
    public function transferencia() {
        return $this->belongsTo('App\Transferencia', 'transferencia_id');
    }


    /**
     * Obtiene el Producto asociado con el Detalle
     * @return App\Producto
     */
    public function producto() {
        return $this->belongsTo('App\Producto', 'producto_id');
    }


    /**
     * Obtiene el ProductoMovimiento asociado con el Detalle
     * @return App\ProductoMovimiento
     */
    public function productoMovimiento() {
        return $this->belongsTo('App\ProductoMovimiento', 'producto_movimiento_id');
    }
}
