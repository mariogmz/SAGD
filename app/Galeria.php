<?php

namespace App;


use Codesleeve\Stapler\ORM\EloquentTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;

/**
 * App\Galeria
 *
 * @property integer $id
 * @property integer $ficha_id
 * @property boolean $principal
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $imagen_file_name
 * @property integer $imagen_file_size
 * @property string $imagen_content_type
 * @property string $imagen_updated_at
 * @property-read \App\Ficha $ficha
 * @method static \Illuminate\Database\Query\Builder|\App\Galeria whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Galeria whereFichaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Galeria wherePrincipal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Galeria whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Galeria whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Galeria whereImagenFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Galeria whereImagenFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Galeria whereImagenContentType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Galeria whereImagenUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
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
