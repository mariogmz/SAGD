<?php

namespace App;


class IcecatCategoryFeature extends LGGModel {

    protected $table = 'icecat_features';
    public $timestamps = true;
    protected $fillable = [
        'icecat_id', 'type', 'name', 'description', 'measure'
    ];

    public static $rules = [
        'icecat_id'   => 'integer|required|unique:icecat_features',
        'type'        => 'string|max:45',
        'name'        => 'string|required|max:70',
        'description' => 'string|max:100',
        'measure'     => 'string|max:10'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        IcecatCategoryFeature::creating(function ($icecat_feature) {
            return $icecat_feature->isValid();
        });
        IcecatCategoryFeature::updating(function ($icecat_feature) {
            $icecat_feature->updateRules = self::$rules;
            $icecat_feature->updateRules['icecat_id'] = "integer|required|unique:icecat_features,icecat_id,{$icecat_feature->id}";

            return $icecat_feature->isValid('update');
        });
    }
}
