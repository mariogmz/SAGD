<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PDF;
use Sagd\SafeTransactions;

/**
 * App\Pretransferencia
 *
 * @property integer $id
 * @property integer $cantidad
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $producto_id
 * @property integer $sucursal_origen_id
 * @property integer $sucursal_destino_id
 * @property integer $empleado_id
 * @property integer $estado_pretransferencia_id
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Producto $producto
 * @property-read \App\Sucursal $origen
 * @property-read \App\Sucursal $destino
 * @property-read \App\Empleado $empleado
 * @property-read \App\EstadoPretransferencia $estado
 * @method static \Illuminate\Database\Query\Builder|\App\Pretransferencia whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Pretransferencia whereCantidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Pretransferencia whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Pretransferencia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Pretransferencia whereProductoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Pretransferencia whereSucursalOrigenId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Pretransferencia whereSucursalDestinoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Pretransferencia whereEmpleadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Pretransferencia whereEstadoPretransferenciaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Pretransferencia whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Pretransferencia extends LGGModel
{
    use SafeTransactions;

    protected $table = 'pretransferencias';
    public $timestamps = true;
    protected $fillable = ['producto_id', 'sucursal_origen_id',
        'sucursal_destino_id', 'empleado_id', 'cantidad', 'estado_pretransferencia_id'];

    public static $rules = [
        'producto_id'                   => 'required|int|',
        'sucursal_origen_id'            => 'required|int|',
        'sucursal_destino_id'           => 'required|int|',
        'empleado_id'                   => 'required|int|',
        'estado_pretransferencia_id'    => 'required|int|',
        'cantidad'                      => 'required|int|min:0'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        parent::boot();
        Pretransferencia::creating(function($model) {
            $model->estado_pretransferencia_id || $model->estado_pretransferencia_id = EstadoPretransferencia::sinTransferir();
            return $model->isValid();
        });
        Pretransferencia::updating(function($model) {
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }

    /**
     * Genera un PDF en base a origen y destino
     * @param array $ids
     * @return Pdf
     */
    public function pdf($ids)
    {
        $datos = $this->generarDatos($ids);
        // return view('pdf.pretransferencia', ['pretransferencias' => $datos]);
        $pdf = PDF::loadView('pdf.pretransferencia', ['pretransferencias' => $datos])->setPaper('letter');
        return $pdf->stream();
    }

    /**
     * Genera los datos para la impresion de la pretransferencia
     * @param array $ids
     * @return Collection
     */
    private function generarDatos($ids)
    {
        return $this->with('origen', 'destino', 'producto', 'empleado')
            ->whereIn('id', $ids)
            ->get();
    }

    public function transferir($origen, $destino)
    {
        $lambda = function() use($origen, $destino) {
            $pretransferencias = $this
                ->where('sucursal_origen_id', $origen)->where('sucursal_destino_id', $destino)->get();
            foreach ($pretransferencias as $pretranferencia) {
                $pretranferencia->estado_pretransferencia_id = EstadoPretransferencia::transferido();
                $saved = $pretranferencia->save();
                if(!$saved) { return false; }
            }
            return true;
        };
        return $this->safe_transaction($lambda);
    }

    /**
    * Obtiene el Producto asociado con la Pretransferencia
    * @return App\Producto
    */
    public function producto()
    {
        return $this->belongsTo('App\Producto', 'producto_id');
    }


    /**
    * Obtiene la Sucursal de origen asociada con la Pretransferencia
    * @return App\Sucursal
    */
    public function origen()
    {
        return $this->belongsTo('App\Sucursal', 'sucursal_origen_id');
    }


    /**
    * Obtiene la Sucursal de destino asociada con la Pretransferencia
    * @return App\Sucursal
    */
    public function destino()
    {
        return $this->belongsTo('App\Sucursal', 'sucursal_destino_id');
    }


    /**
    * Obtiene el Empleado que realizo la Pretransferencia
    * @return App\Empleado
    */
    public function empleado()
    {
        return $this->belongsTo('App\Empleado', 'empleado_id');
    }


    /**
    * Obtiene el estado asociado con la pretransferencia
    * @return App\EstadoPretransferencia
    */
    public function estado()
    {
        return $this->belongsTo('App\EstadoPretransferencia', 'estado_pretransferencia_id');
    }
}
