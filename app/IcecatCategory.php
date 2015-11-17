<?php

namespace App;


/**
 * App\IcecatCategory
 *
 */
class IcecatCategory extends LGGModel {

    protected $table = 'icecat_categories';
    public $timestamps = true;
    protected $fillable = [
        'icecat_id', 'name', 'description', 'keyword'
    ];

    public static $rules = [
        'icecat_id'                 => 'integer|required|unique:icecat_categories',
        'name'                      => 'string|required|max:100',
        'description'               => 'string|max:300',
        'keyword'                   => 'string|max:100',
        'icecat_parent_category_id' => 'integer'
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
}
