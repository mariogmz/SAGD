<?php

namespace App;


/**
 * App\IcecatFeature
 *
 * @property integer $id
 * @property integer $icecat_id
 * @property string $type
 * @property string $name
 * @property string $description
 * @property string $measure
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\IcecatCategoryFeature[] $categoriesFeatures
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatFeature whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatFeature whereIcecatId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatFeature whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatFeature whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatFeature whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatFeature whereMeasure($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatFeature whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatFeature whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatFeature whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class IcecatFeature extends LGGModel {

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
        IcecatFeature::creating(function ($icecat_feature) {
            return $icecat_feature->isValid();
        });
        IcecatFeature::updating(function ($icecat_feature) {
            $icecat_feature->updateRules = self::$rules;
            $icecat_feature->updateRules['icecat_id'] = "integer|required|unique:icecat_features,icecat_id,{$icecat_feature->id}";

            return $icecat_feature->isValid('update');
        });
    }

    /**
     * Obtiene los IcecatCategoryFeature asociados a este feature
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function categoriesFeatures() {
        return $this->hasMany('App\IcecatCategoryFeature', 'icecat_feature_id', 'icecat_id');
    }

}
