<?php

namespace App;


class IcecatCategoryFeatureGroup extends LGGModel {

    protected $table = 'icecat_categories_feature_groups';
    public $timestamps = true;
    protected $fillable = [
        'icecat_id', 'icecat_category_id', 'icecat_feature_group_id'
    ];

    public static $rules = [
        'icecat_id'               => 'integer|required|unique:icecat_categories_feature_groups',
        'icecat_category_id'      => 'integer|required',
        'icecat_feature_group_id' => 'integer|required'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        IcecatCategoryFeatureGroup::creating(function ($icecat_feature) {
            return $icecat_feature->isValid();
        });
        IcecatCategoryFeatureGroup::updating(function ($icecat_feature) {
            $icecat_feature->updateRules = self::$rules;
            $icecat_feature->updateRules['icecat_id'] = "integer|required|unique:icecat_categories_feature_groups,icecat_id,{$icecat_feature->id}";

            return $icecat_feature->isValid('update');
        });
    }
}
