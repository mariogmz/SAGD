<?php

namespace App;


/**
 * App\PaginaWebDistribuidor
 *
 * @property integer $id
 * @property boolean $activo
 * @property string $fecha_vencimiento
 * @property string $url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $cliente_id
 * @property-read \App\Cliente $cliente
 * @method static \Illuminate\Database\Query\Builder|\App\PaginaWebDistribuidor whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaginaWebDistribuidor whereActivo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaginaWebDistribuidor whereFechaVencimiento($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaginaWebDistribuidor whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaginaWebDistribuidor whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaginaWebDistribuidor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaginaWebDistribuidor whereClienteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class PaginaWebDistribuidor extends LGGModel {

    //
    protected $table = "paginas_web_distribuidores";
    public $timestamps = false;
    protected $fillable = ['activo', 'fecha_vencimiento', 'url', 'cliente_id'];

    public static $rules = [
        'activo'            => 'required|boolean',
        'fecha_vencimiento' => 'required|date',
        'url'               => 'max:100',
        'cliente_id'        => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        PaginaWebDistribuidor::creating(function ($pwd) {
            if (!$pwd->isValid()) {
                return false;
            }

            return true;
        });
        PaginaWebDistribuidor::updating(function ($pwd) {
            $pwd->updateRules = self::$rules;

            return $pwd->isValid('update');
        });
    }


    /**
     * Obtiene el Cliente asociado con la PaginaWebDistribuidor
     * @return App\Cliente
     */
    public function cliente() {
        return $this->belongsTo('App\Cliente', 'cliente_id');
    }
}
