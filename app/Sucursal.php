<?php

namespace App;

use App\Precio;
use App\Producto;
use Sagd\SafeTransactions;

/**
 * App\Sucursal
 *
 * @property integer $id
 * @property string $clave
 * @property string $nombre
 * @property string $horarios
 * @property string $ubicacion
 * @property integer $proveedor_id
 * @property integer $domicilio_id
 * @property-read \App\Proveedor $proveedor
 * @property-read \App\Domicilio $domicilio
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Producto[] $productos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Empleado[] $empleados
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Rma[] $rmas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Salida[] $salidas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RazonSocialEmisor[] $razonesSocialesEmisores
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EntradaDetalle[] $entradasDetalles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transferencia[] $transferenciasOrigen
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transferencia[] $transferenciasDestino
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Apartado[] $apartados
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Caja[] $cajas
 * @method static \Illuminate\Database\Query\Builder|\App\Sucursal whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sucursal whereClave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sucursal whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sucursal whereHorarios($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sucursal whereUbicacion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sucursal whereProveedorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sucursal whereDomicilioId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Sucursal extends LGGModel {

    use SafeTransactions;

    protected $table = 'sucursales';
    public $timestamps = false;

    protected $fillable = ['clave', 'nombre', 'horarios', 'ubicacion', 'proveedor_id', 'domicilio_id'];
    public static $rules = [
        'clave'        => 'required|string|size:8|alpha|unique:sucursales',
        'nombre'       => 'required|string|max:45',
        'ubicacion'    => 'string|max:45',
        'horarios'     => 'required|string|max:100',
        'proveedor_id' => 'required|integer',
        'domicilio_id' => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Sucursal::creating(function ($sucursal) {
            $sucursal->clave = strtoupper($sucursal->clave);
            if (!$sucursal->isValid()) {
                return false;
            }

            return true;
        });
        Sucursal::updating(function ($sucursal) {
            $sucursal->updateRules = self::$rules;
            $sucursal->updateRules['clave'] .= ',clave,' . $sucursal->id;

            return $sucursal->isValid('update');
        });
    }

    /**
     * Save the model to the database.
     *
     * @param  int  $base
     * @return bool
     */
    public function guardar($base)
    {
        $lambda = function () use ($base) {
            if ($this->save()) {
                $sucursal_base = Sucursal::find($base);
                $productos = $this->obtenerProductosAsociadosConSucursal($sucursal_base);
                return $this->asignarPrecios($productos, $sucursal_base);
            } else {
                return false;
            }
        };
        return $this->safe_transaction($lambda);
    }

    /**
     * @param Sucursal $sucursal
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function obtenerProductosAsociadosConSucursal(Sucursal $sucursal)
    {
        return Producto::whereHas('productosSucursales', function($query) use ($sucursal) {
            $query->where('sucursal_id', $sucursal->id);
        })->get();
    }

    /**
     * @param Illuminate\Database\Eloquent\Collection $productos
     * @param Sucursal $sucursal
     * @return bool
     */
    private function asignarPrecios(\Illuminate\Database\Eloquent\Collection $productos, Sucursal $sucursal)
    {
        foreach ($productos as $producto) {
            $producto->addSucursal($this);
            $precio = $this->generarNuevoPrecio($producto, $sucursal);
            if ( $this->agregarPrecioParaProducto($producto, $precio) ) {
                continue;
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * @param Producto $producto
     * @param Sucursal $sucursal
     * @return Precio
     */
    private function generarNuevoPrecio(Producto $producto, Sucursal $sucursal)
    {
        $columns = ['costo' => 0, 'precio_1' => 0, 'precio_2' => 0, 'precio_3' => 0, 'precio_4' => 0, 'precio_5' => 0, 'precio_6' => 0, 'precio_7' => 0, 'precio_8' => 0, 'precio_9' => 0, 'precio_10' => 0];
        $precio_base = $producto->precios()->where('sucursal_id', $sucursal->id)->first()->toArray();
        $values = array_intersect_key($precio_base, $columns);
        return new Precio($values);
    }

    /**
     * @param Producto $producto
     * @param Precio $precio
     * @return bool
     */
    private function agregarPrecioParaProducto(Producto $producto, Precio $precio)
    {
        $producto_sucursal = $producto->productosSucursales()->where('sucursal_id', $this->id)->first();
        if ( $precio->productoSucursal()->associate($producto_sucursal)->save() ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Obtiene el proveedor asociado a la sucursal
     * @return App\Proveedor
     */
    public function proveedor() {
        return $this->belongsTo('App\Proveedor');
    }

    /**
     * Obtiene el domicilio asociado a la sucursal
     * @return App\Domicilio
     */
    public function domicilio() {
        return $this->belongsTo('App\Domicilio');
    }

    /**
     * Obtener los Productos relacionados con la Sucursal
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function productos() {
        return $this->belongsToMany('App\Producto', 'productos_sucursales',
            'sucursal_id', 'producto_id');
    }

    /**
     * Obtiene los empleados asociados a la sucursal
     * @return array
     */
    public function empleados() {
        return $this->hasMany('App\Empleado');
    }

    /**
     * Obtener los RMAs generados en la sucursal
     * @return array
     */
    public function rmas() {
        return $this->hasMany('App\Rma');
    }


    /**
     * Obtiene las Salidas asociadas con la Sucursal
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function salidas() {
        return $this->hasMany('App\Salida', 'sucursal_id');
    }


    /**
     * Obtiene la Razon Social Emisora asociada con la Sucursal
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function razonesSocialesEmisores() {
        return $this->hasMany('App\RazonSocialEmisor', 'sucursal_id');
    }


    /**
     * Obtiene las Entradas Detalles asociadas con la Sucursal
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function entradasDetalles() {
        return $this->hasMany('App\EntradaDetalle', 'sucursal_id');
    }


    /**
     * Obtiene las Transferencias asociadas con la Sucursal como origen
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function transferenciasOrigen() {
        return $this->hasMany('App\Transferencia', 'sucursal_origen_id');
    }


    /**
     * Obtiene las Transferencias asociadas con la Sucursal como destino
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function transferenciasDestino() {
        return $this->hasMany('App\Transferencia', 'sucursal_destino_id');
    }


    /**
     * Obtiene los Apartados asociados con la Sucursal
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function apartados() {
        return $this->hasMany('App\Apartado', 'sucursal_id');
    }

    /**
     * Obtiene las cajas asociadas a la sucursal
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function cajas() {
        return $this->hasMany('App\Caja');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productosSucursales() {
        return $this->hasMany('App\ProductoSucursal');
    }

    /**
     * @param \App\Producto
     * @return \App\Precio
     */
    public function precio($producto) {
        return $this->productosSucursales
            ->where('producto_id', $producto->id)
            ->first()->precio;
    }

    /**
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function precios() {
        return $this->hasManyThrough('App\Precio', 'App\ProductoSucursal',
            'sucursal_id', 'producto_sucursal_id');
    }

    /**
     * Obtiene los productos_movimientos de todos los productos relacionados con la Sucursal
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function movimientos(Producto $producto = null) {
        if( is_null($producto) ) {
            return $this->hasManyThrough('App\ProductoMovimiento', 'App\ProductoSucursal',
                'sucursal_id', 'producto_sucursal_id');
        } else {
            return $this->productosSucursales()->where('producto_id', $producto->id)->first()->movimientos;
        }
    }
}
