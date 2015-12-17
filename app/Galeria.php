<?php

namespace App;


use Codesleeve\Stapler\ORM\EloquentTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;

class Galeria extends LGGModel implements StaplerableInterface {

    use EloquentTrait;

    protected $table = 'galerias';
    public $timestamps = true;
    protected $fillable = ['ficha_id', 'principal', 'imagen'];

    public static $rules = [
        'ficha_id'  => 'required|integer|unique_with:galerias,principal',
        'principal' => 'boolean'
    ];
    public $updateRules = [];

    /**
     * Galeria constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = []) {
        $this->hasAttachedFile('imagen', [
            'styles' => [
                'big'    => '500x500',
                'medium' => '300x300',
                'small'  => '200x200',
                'thumb'  => '100x100',
            ]
        ]);

        parent::__construct($attributes);
    }

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        static::bootStapler();
        Galeria::creating(function (Galeria $galeria) {
            if (!$galeria->isValid()) {
                return false;
            }

            return true;
        });
        Galeria::updating(function (Galeria $galeria) {
            $galeria->updateRules = self::$rules;
            $galeria->updateRules['ficha_id'] = 'required|integer|unique_with:galerias,principal,' . $galeria->id;

            return $galeria->isValid('update');
        });

    }

    /**
     * Obtiene la ficha asociada a esta imagen
     */
    public function ficha() {
        return $this->belongsTo('App\Ficha');
    }
}
