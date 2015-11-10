<?php

namespace App;


/**
 * App\IcecatSupplier
 *
 */
class IcecatSupplier extends LGGModel {

    protected $table = 'icecat_suppliers';
    public $timestamps = true;
    protected $fillable = [
        'icecat_id', 'name', 'logo_url'
    ];

    public static $rules = [
        'icecat_id' => 'integer|required|unique:icecat_suppliers',
        'name'      => 'string|required|max:50',
        'logo_url'  => 'url|max:100'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        IcecatSupplier::creating(function ($icecat_supplier) {
            return $icecat_supplier->isValid();
        });
        IcecatSupplier::updating(function ($icecat_supplier) {
            $icecat_supplier->updateRules = self::$rules;
            $icecat_supplier->updateRules['icecat_id'] .= ',icecat_id,' . $icecat_supplier->icecat_id;

            return $icecat_supplier->isValid('update');
        });
    }
}
