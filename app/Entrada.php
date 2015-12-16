<?php

namespace App;

use App\EstadoEntrada;
use App\Producto;
use App\ProductoMovimiento;
use App\Sucursal;
use Sagd\SafeTransactions;

/**
 * App\Entrada
 *
 * @property integer $id
 * @property string $factura_externa_numero
 * @property string $factura_fecha
 * @property string $moneda
 * @property float $tipo_cambio
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $estado_entrada_id
 * @property integer $proveedor_id
 * @property integer $razon_social_id
 * @property integer $empleado_id
 * @property-read \App\EstadoEntrada $estado
 * @property-read \App\Proveedor $proveedor
 * @property-read \App\RazonSocialEmisor $razonSocial
 * @property-read \App\Empleado $empleado
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EntradaDetalle[] $detalles
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereFacturaExternaNumero($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereFacturaFecha($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereMoneda($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereTipoCambio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereEstadoEntradaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereProveedorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereRazonSocialId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereEmpleadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereDeletedAt($value)
 * @property boolean $factura
 * @property integer $sucursal_id
 * @property-read \App\Sucursal $sucursal
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereFactura($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereSucursalId($value)
 */
class Entrada extends LGGModel {

    use SafeTransactions;

    //
    protected $table = "entradas";
    public $timestamps = true;
    protected $fillable = ['factura_externa_numero', 'factura_fecha', 'moneda',
        'tipo_cambio', 'factura', 'estado_entrada_id', 'proveedor_id',
        'razon_social_id', 'empleado_id', 'sucursal_id'];

    public static $rules = [
        'factura_externa_numero' => 'required|max:45',
        'factura_fecha'          => 'date',
        'moneda'                 => 'required|max:45',
        'tipo_cambio'            => 'required|numeric',
        'factura'                => 'boolean',
        'estado_entrada_id'      => 'required|integer',
        'proveedor_id'           => 'required|integer',
        'razon_social_id'        => 'required|integer',
        'empleado_id'            => 'required|integer',
        'sucursal_id'            => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Entrada::creating(function ($model) {
            $model->factura = is_null($model->factura) ? false : $model->factura;
            return $model->isValid();
        });
        Entrada::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Crear un detalle asociado a la entrada
     * @param array $detalle
     * @return EntradaDetalle | false
     */
    public function crearDetalle($detalle)
    {
        if (! is_null($detalle['upc'])) { unset($detalle['upc']); }

        $entradaDetalle = new EntradaDetalle();
        $entradaDetalle->fill($detalle);
        if ($this->detalles->contains('producto_id', $entradaDetalle->producto_id)) {
            $entradaDetalleOriginal = $this->detalles()->where('producto_id', $entradaDetalle->producto_id)->first();
            $entradaDetalleOriginal->cantidad += $entradaDetalle->cantidad;
            $entradaDetalleOriginal->recalcularImporte();
            return $entradaDetalleOriginal->save() ? $entradaDetalleOriginal : false;
        }
        return $this->detalles()->save($entradaDetalle);
    }

    /**
     * Quita un detalle asociado a la entrada
     * @param int $detalle_id
     * @return bool
     */
    public function quitarDetalle($detalle_id)
    {
        return (EntradaDetalle::destroy($detalle_id) > 0);
    }

    /**
     * Carga los detalles para actualizar existencias
     * @return bool
     */
    public function cargar()
    {
        $lambda = function() {
            if($this->noCargado()) {
                foreach ($this->detalles()->get() as $detalle) {
                    if (! $detalle->cargar()) {
                        return false;
                    }
                }
                $this->finalizarCarga();
                return true;
            } else {
                return false;
            }
        };
        return $this->safe_transaction($lambda);
    }

    /**
     * Verifica que el estado no se encuentre como Cargado
     * @return bool
     */
    public function noCargado()
    {
        return $this->estado->nombre != 'Cargado';
    }

    /**
     * Establece el Estado de la Salida a Cargado
     * @return bool
     */
    public function finalizarCarga()
    {
        $this->estado()->associate(EstadoEntrada::cargado());
        $this->save();
    }

    /**
     * Obtiene el Estado asociado con la Entrada
     * @return App\Estado
     */
    public function estado() {
        return $this->belongsTo('App\EstadoEntrada', 'estado_entrada_id');
    }


    /**
     * Obtiene el Proveedor asociado con la Entrada
     * @return App\Proveedor
     */
    public function proveedor() {
        return $this->belongsTo('App\Proveedor', 'proveedor_id');
    }


    /**
     * Obtiene la Razon Social asociada con la Entrada
     * @return App\RazonSocialEmisor
     */
    public function razonSocial() {
        return $this->belongsTo('App\RazonSocialEmisor', 'razon_social_id');
    }


    /**
     * Obtiene el Empleado asociado con la Entrada
     * @return App\Empleado
     */
    public function empleado() {
        return $this->belongsTo('App\Empleado', 'empleado_id');
    }

    /**
     * Obtiene la Sucursal asociada con la Entrada
     * @return App\Sucursal
     */
    public function sucursal() {
        return $this->belongsTo('App\Sucursal', 'sucursal_id');
    }

    /**
     * Obtiene los Detalles asociados con la Entrada
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function detalles() {
        return $this->hasMany('App\EntradaDetalle', 'entrada_id');
    }
}
