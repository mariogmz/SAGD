<?php

namespace App;


/**
 * App\IcecatSupplier
 *
 * @property integer $id
 * @property integer $icecat_id
 * @property string $name
 * @property string $logo_url
 * @property integer $marca_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Marca $marca
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatSupplier whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatSupplier whereIcecatId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatSupplier whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatSupplier whereLogoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatSupplier whereMarcaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatSupplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatSupplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IcecatSupplier whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class IcecatSupplier extends LGGModel {

    protected $table = 'icecat_suppliers';
    public $timestamps = true;
    protected $fillable = [
        'icecat_id', 'name', 'logo_url','marca_id'
    ];

    public static $rules = [
        'icecat_id' => 'integer|required|unique:icecat_suppliers',
        'name'      => 'string|required|max:50|unique:icecat_suppliers',
        'logo_url'  => 'url|max:100',
        'marca_id'  => 'integer'
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
            $icecat_supplier->updateRules['icecat_id'] .= ',icecat_id,' . $icecat_supplier->id;
            $icecat_supplier->updateRules['name'] .= ',name,' . $icecat_supplier->id;

            return $icecat_supplier->isValid('update');
        });
    }

    /**
     * Obtiene la marca a la cual pertenece el supplier de Icecat
     * @return \App\Marca
     */
    public function marca(){
        return $this->belongsTo('App\Marca');
    }
}
