<?php

namespace App;


class IcecatCategoryFeature extends LGGModel {

    protected $table = 'icecat_categories_features';
    public $timestamps = true;
    protected $fillable = [
        'icecat_id', 'icecat_category_feature_group_id', 'icecat_category_id', 'icecat_feature_id'
    ];

    public static $rules = [
        'icecat_id'                        => 'integer|required|unique:icecat_categories_features',
        'icecat_category_feature_group_id' => 'integer|required',
        'icecat_category_id'               => 'integer|required',
        'icecat_feature_id'                => 'integer|required'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        IcecatCategoryFeature::creating(function ($icecat_category_feature) {
            return $icecat_category_feature->isValid();
        });
        IcecatCategoryFeature::updating(function ($icecat_category_feature) {
            $icecat_category_feature->updateRules = self::$rules;
            $icecat_category_feature->updateRules['icecat_id'] = "integer|required|unique:icecat_categories_features,icecat_id,{$icecat_category_feature->id}";

            return $icecat_category_feature->isValid('update');
        });
    }
}
