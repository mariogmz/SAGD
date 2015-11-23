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
        'icecat_category_id'      => 'integer|required|unique_with:icecat_categories_feature_groups,icecat_feature_group_id',
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
            $icecat_feature->updateRules['icecat_category_id'] = "integer|required|unique_with:icecat_categories_feature_groups,icecat_feature_group_id,{$icecat_feature->id}";

            return $icecat_feature->isValid('update');
        });
    }

    /**
     * Obtiene los categories_features relacionados con este category_feature_group
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function categoriesFeatures() {
        return $this->hasMany('App\IcecatCategoryFeature', 'icecat_category_feature_group_id', 'icecat_id');
    }

    /**
     * Obtiene el category asociado a este category_feature_group
     * @return \App\IcecatCategory
     */
    public function category() {
        return $this->belongsTo('App\IcecatCategory', 'icecat_category_id', 'icecat_id');
    }

    /**
     * Obtiene el feature_group asociado a este category_feature_group
     * @return \App\IcecatFeature
     */
    public function featureGroup() {
        return $this->belongsTo('App\IcecatFeatureGroup', 'icecat_feature_group_id', 'icecat_id');
    }
}
