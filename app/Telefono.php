<?php

namespace App;


class Telefono extends LGGModel {

    protected $table = 'telefonos';
    public $timestamps = false;

    protected $fillable = ['numero', 'tipo'];
    public static $rules = [
        'numero'       => ['required', 'unique:telefonos', 'regex:/[0-9]{7,11}/'],
        'tipo'         => 'required|max:45',
        'domicilio_id' => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        Telefono::creating(function ($telefono) {
            if (!$telefono->isValid()) {
                return false;
            }

            return true;
        });
        Telefono::updating(function ($telefono) {
            $telefono->updateRules = self::$rules;
            $telefono->updateRules['numero'] = [
                'required',
                'unique:telefonos,numero,' . $telefono->id,
                'regex:/[0-9]{7,11}/'
            ];

            return $telefono->isValid('update');
        });
    }

    /**
     * Obtiene el domicilio a la que está asociado el teléfono
     * @return App\Domicilio
     */
    public function domicilio() {
        return $this->belongsTo('App\Domicilio');
    }
}
