<?php

namespace App;


/**
 * App\EstadoFactura
 *
 * @property integer $id
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Factura[] $facturas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\NotaCredito[] $notasCreditos
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoFactura whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoFactura whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoFactura whereDeletedAt($value)
 */
class EstadoFactura extends LGGModel {

    //
    protected $table = "estados_facturas";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|max:45'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        EstadoFactura::creating(function ($model) {
            return $model->isValid();
        });
        EstadoFactura::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene las Facturas asociadas con el Estado
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function facturas() {
        return $this->hasMany('App\Factura', 'factura_status_id');
    }


    /**
     * Obtiene las Notas de Credito asociadas con el Estado
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function notasCreditos() {
        return $this->hasMany('App\NotaCredito', 'factura_status_id');
    }
}
