<?php

namespace App;


/**
 * App\TipoPartida
 *
 * @property integer $id
 * @property string $clave
 * @property string $nombre
 * @property boolean $ticket
 * @property boolean $ticket_suma
 * @property boolean $pago
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TipoPartidaCorteConcepto[] $tiposPartidasCortesConceptos
 * @method static \Illuminate\Database\Query\Builder|\App\TipoPartida whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoPartida whereClave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoPartida whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoPartida whereTicket($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoPartida whereTicketSuma($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoPartida wherePago($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class TipoPartida extends LGGModel {

    protected $table = "tipos_partidas";
    public $timestamps = false;
    protected $fillable = [
        'clave', 'nombre', 'ticket', 'ticket_suma', 'pago'
    ];

    public static $rules = [
        'clave'       => 'required|string|max:25|unique:tipos_partidas',
        'nombre'      => 'required|string|max:50',
        'ticket'      => 'required|boolean',
        'ticket_suma' => 'required|boolean',
        'pago'        => 'required|boolean'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        TipoPartida::creating(function ($model) {
            return $model->isValid();
        });
        TipoPartida::updating(function ($model) {
            $model->updateRules = self::$rules;
            $model->updateRules['clave'] .= ',clave,' . $model->id;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene la relacion de los conceptos de corte para este tipo de partida
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function tiposPartidasCortesConceptos() {
        return $this->hasMany('App\TipoPartidaCorteConcepto');
    }
}
