<?php

namespace App;

class Margen extends LGGModel
{
    //
    protected $table = "margenes";
    public $timestamps = false;
    protected $fillable = ['nombre', 'valor', 'valor_webservice_p1', 'valor_webservice_p8'];

    public static $rules = [
        'nombre' => 'required|max:45',
        'valor' => 'numeric|min:0.0|max:1.0',
        'valor_webservice_p1' => 'numeric|min:0.0|max:1.0',
        'valor_webservice_p8' => 'numeric|min:0.0|max:1.0'
    ];

    /**
     * Define the model hooks
     */
    public static function boot() {
        Margen::creating(function($margen){
            $margen->valor || $margen->valor = 0.0;
            $margen['valor_webservice_p1'] || $margen['valor_webservice_p1'] = 0.0;
            $margen['valor_webservice_p8'] || $margen['valor_webservice_p8'] = 0.0;
            if ( !$margen->isValid() ){
                return false;
            }
            return true;
        });
    }

    public function subfamilias()
    {
        return $this->hasMany('App\Subfamilia');
    }

    /**
     * @covers Margen::subfamilias()
     */
    public function testSubfamilias()
    {
        $subfamilia = factory(App\Subfamilia::class)->create();
        $margen = $subfamilia->margen;
        $subfamilia = $margen->subfamilias[0];
        $this->assertInstanceOf(App\Subfamilia::class, $subfamilia);
    }
}
