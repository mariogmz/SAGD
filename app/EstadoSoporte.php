<?php

namespace App;


/**
 * App\EstadoSoporte
 *
 * @property integer $id
 * @property string $clave
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ServicioSoporte[] $serviciosSoportes
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoSoporte whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoSoporte whereClave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoSoporte whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoSoporte whereDeletedAt($value)
 */
class EstadoSoporte extends LGGModel {

    //
    protected $table = "estados_soporte";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre'];

    public static $rules = [
        'clave'  => 'required|string|size:6|unique:estados_soporte',
        'nombre' => 'required|string|max:150'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        EstadoSoporte::creating(function ($model) {
            if (!$model->isValid()) {
                return false;
            }

            return true;
        });
        EstadoSoporte::updating(function ($estado_soporte) {
            $estado_soporte->updateRules = self::$rules;
            $estado_soporte->updateRules['clave'] .= ',clave,' . $estado_soporte->id;

            return $estado_soporte->isValid('update');
        });
    }

    /**
     * Obtiene los soportes asociados al estatus de soporte
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function serviciosSoportes() {
        return $this->hasMany('App\ServicioSoporte');
    }
}
