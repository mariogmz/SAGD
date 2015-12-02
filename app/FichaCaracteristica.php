<?php

namespace App;


class FichaCaracteristica extends LGGModel {

    protected $table = "fichas_caracteristicas";
    public $timestamps = true;
    protected $fillable = ['ficha_id', 'category_feature_id', 'valor', 'valor_presentacion'];
    protected $touches = ['ficha'];

    public static $rules = [
        'ficha_id'            => 'integer|required|unique_with:fichas_caracteristicas,category_feature_id',
        'category_feature_id' => 'integer|required',
        'valor'               => 'string|required|max:60',
        'valor_presentacion'  => 'string|max:60'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        FichaCaracteristica::creating(function ($ficha_caracteristica) {
            return $ficha_caracteristica->isValid();
        });
        FichaCaracteristica::updating(function ($ficha_caracteristica) {
            $ficha_caracteristica->updateRules = self::$rules;
            $ficha_caracteristica->updateRules['ficha_id'] = "integer|required|unique_with:fichas_caracteristicas,category_feature_id,{$ficha_caracteristica->id}";

            return $ficha_caracteristica->isValid('update');
        });
    }

    /**
     * Obtiene la ficha asociada para esta característica
     * @return \App\Ficha
     */
    public function ficha() {
        return $this->belongsTo('App\Ficha');
    }

    /**
     * Obtiene el producto para el cual está definida esta ficha
     * @return \App\Producto
     */
    public function producto() {
        return $this->ficha->producto();
    }

    /**
     * Obtiene el IcecatCategoryFeature asociado a esta característica
     * @return \App\IcecatCategoryFeature
     */
    public function categoryFeature() {
        return $this->belongsTo('App\IcecatCategoryFeature');
    }

    /**
     * Obtiene el IcecatCategory asociado a esta característica
     * @return \App\IcecatCategory
     */
    public function category() {
        return $this->categoryFeature->category();
    }

    /**
     * Obtiene el IcecatFeature asociado a esta característica
     * @return \App\IcecatCategory
     */
    public function feature() {
        return $this->categoryFeature->feature();
    }

    /**
     * Obtinene el IcecatFeatureGroup asociado a esta característica
     * @return \App\IcecatFeatureGroup
     */
    public function featureGroup() {
        return $this->categoryFeature->categoryFeatureGroup->featureGroup();
    }

}
