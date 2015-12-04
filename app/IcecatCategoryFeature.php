<?php

namespace App;


/**
 * App\IcecatCategoryFeature
 *
 * @property integer $id
 * @property integer $icecat_id
 * @property integer $icecat_category_feature_group_id
 * @property integer $icecat_category_id
 * @property integer $icecat_feature_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\IcecatFeature $feature
 * @property-read \App\IcecatCategory $category
 * @property-read \App\IcecatCategoryFeatureGroup $categoryFeatureGroup
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategoryFeature whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategoryFeature whereIcecatId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategoryFeature whereIcecatCategoryFeatureGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategoryFeature whereIcecatCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategoryFeature whereIcecatFeatureId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategoryFeature whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategoryFeature whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategoryFeature whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class IcecatCategoryFeature extends LGGModel {

    protected $table = 'icecat_categories_features';
    public $timestamps = true;
    protected $fillable = [
        'icecat_id', 'icecat_category_feature_group_id', 'icecat_category_id', 'icecat_feature_id'
    ];

    public static $rules = [
        'icecat_id'                        => 'integer|required|unique:icecat_categories_features',
        'icecat_category_feature_group_id' => 'integer|required|unique_with:icecat_categories_features,icecat_category_id,icecat_feature_id',
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
            $icecat_category_feature->updateRules['icecat_category_feature_group_id'] = "integer|required|unique_with:icecat_categories_features,icecat_category_id,icecat_feature_id,{$icecat_category_feature->id}";


            return $icecat_category_feature->isValid('update');
        });
    }

    /**
     * Obtiene el feature asociado a este category_feature
     * @return \App\IcecatFeature
     */
    public function feature() {
        return $this->belongsTo('App\IcecatFeature', 'icecat_feature_id', 'icecat_id');
    }

    /**
     * Obtiene el category asociado a este category_feature
     * @return \App\IcecatCategory
     */
    public function category() {
        return $this->belongsTo('App\IcecatCategory', 'icecat_category_id', 'icecat_id');
    }

    /**
     * Obtiene el category_feature_group asociado a este category_feature
     * @return \App\IcecatCategoryFeatureGroup
     */
    public function categoryFeatureGroup() {
        return $this->belongsTo('App\IcecatCategoryFeatureGroup', 'icecat_category_feature_group_id', 'icecat_id');
    }
}
