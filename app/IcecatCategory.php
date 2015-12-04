<?php

namespace App;


/**
 * App\IcecatCategory
 *
 * @property integer $id
 * @property integer $icecat_id
 * @property string $name
 * @property string $description
 * @property string $keyword
 * @property integer $icecat_parent_category_id
 * @property integer $subfamilia_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Subfamilia $subfamilia
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\IcecatCategoryFeature[] $categoriesFeatures
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\IcecatCategoryFeatureGroup[] $categoriesFeatureGroups
 * @property-read \App\IcecatCategory $parentCategory
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\IcecatCategory[] $childrenCategories
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategory whereIcecatId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategory whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategory whereKeyword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategory whereIcecatParentCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategory whereSubfamiliaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class IcecatCategory extends LGGModel {

    protected $table = 'icecat_categories';
    public $timestamps = true;
    protected $fillable = [
        'icecat_id', 'name', 'description', 'keyword', 'subfamilia_id'
    ];

    public static $rules = [
        'icecat_id'                 => 'integer|required|unique:icecat_categories',
        'name'                      => 'string|required|max:100',
        'description'               => 'string|max:300',
        'keyword'                   => 'string|max:100',
        'icecat_parent_category_id' => 'integer',
        'subfamilia_id'             => 'integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        IcecatCategory::creating(function ($icecat_category) {
            return $icecat_category->isValid();
        });
        IcecatCategory::updating(function ($icecat_category) {
            $icecat_category->updateRules = self::$rules;
            $icecat_category->updateRules['icecat_id'] = "integer|required|unique:icecat_categories,icecat_id,{$icecat_category->id}";

            return $icecat_category->isValid('update');
        });
    }

    /**
     * Obtiene la subfamilia a la que pertenece la categoría de Icecat
     * @return \App\Subfamilia
     */
    public function subfamilia() {
        return $this->belongsTo('App\Subfamilia');
    }

    /**
     * Obtiene las asociaciones de icecat_categories_features para este category
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function categoriesFeatures() {
        return $this->hasMany('App\IcecatCategoryFeature', 'icecat_category_id', 'icecat_id');
    }

    /**
     * Obtiene los categories_feature_groups asociados a este category
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function categoriesFeatureGroups() {
        return $this->hasMany('App\IcecatCategoryFeatureGroup', 'icecat_category_id', 'icecat_id');
    }

    /**
     * Obtiene el category padre asociado a este category
     * @return \App\IcecatCategory
     */
    public function parentCategory() {
        return $this->belongsTo('App\IcecatCategory', 'icecat_parent_category_id', 'icecat_id');
    }

    /**
     * Obtiene los categories hijos de este category
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function childrenCategories() {
        return $this->hasMany('App\IcecatCategory', 'icecat_parent_category_id', 'icecat_id');
    }

}
