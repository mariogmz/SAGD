<?php

/**
 * @coversDefaultClass \App\sagd\Calculadora
 */
class CalculadoraTraitTest extends TestCase {

    public function testValoresInciales() {
        $calculadora = $this->getObjectForTrait('Sagd\Calculadora');
        $this->assertAttributeEquals(0, 'factor_margen', $calculadora);
        $this->assertAttributeEquals(0.70, 'factor_diferencia_margen', $calculadora);
        $this->assertAttributeEmpty('utilidad_base', $calculadora);
        $this->assertAttributeEmpty('costo', $calculadora);
        $this->assertAttributeEmpty('margen_id', $calculadora);

        return $calculadora;
    }

    /**
     * @covers ::calcularPrecios
     */
    public function testCalcularPreciosConMargen() {
        $margen = factory(App\Margen::class)->create([
            'valor'               => 0.030,
            'valor_webservice_p1' => 0.110,
            'valor_webservice_p8' => 0.020
        ]);
        $calculadora = $this->getObjectForTrait('Sagd\Calculadora');
        $resultados = $calculadora->calcularPrecios(5940.00, 5444.03, $margen->id);

        $this->assertEquals($resultados['precios']['precio_1'], 5940.00, 'Precio 1 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_2'], 5881.64, 'Precio 2 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_3'], 5823.27, 'Precio 3 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_4'], 5764.91, 'Precio 4 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_5'], 5706.54, 'Precio 5 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_6'], 5648.16, 'Precio 6 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_7'], 5627.77, 'Precio 7 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_8'], 5607.35, 'Precio 8 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_9'], 5586.94, 'Precio 9 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_10'], 5566.52, 'Precio 10 no es el esperado');

        $this->assertEquals($resultados['utilidades']['utilidad_1'], 9.11, 'Utilidad 1 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_2'], 8.04, 'Utilidad 2 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_3'], 6.97, 'Utilidad 3 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_4'], 5.89, 'Utilidad 4 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_5'], 4.82, 'Utilidad 5 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_6'], 3.75, 'Utilidad 6 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_7'], 3.38, 'Utilidad 7 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_8'], 3.00, 'Utilidad 8 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_9'], 2.63, 'Utilidad 9 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_10'], 2.25, 'Utilidad 10 no es la esperada');
    }

    /**
     * @covers ::calcularPrecios
     */
    public function testCalcularPreciosSinMargen() {
        $calculadora = $this->getObjectForTrait('Sagd\Calculadora');
        $resultados = $calculadora->calcularPrecios(5940.00, 5444.03);

        $this->assertEquals($resultados['precios']['precio_1'], 5940.00, 'Precio 1 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_2'], 5861.10, 'Precio 2 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_3'], 5845.31, 'Precio 3 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_4'], 5829.31, 'Precio 4 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_5'], 5813.75, 'Precio 5 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_6'], 5719.07, 'Precio 6 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_7'], 5687.51, 'Precio 7 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_8'], 5655.94, 'Precio 8 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_9'], 5640.16, 'Precio 9 no es el esperado');
        $this->assertEquals($resultados['precios']['precio_10'], 5624.38, 'Precio 10 no es el esperado');

        $this->assertEquals($resultados['utilidades']['utilidad_1'], 9.11, 'Utilidad 1 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_2'], 7.66, 'Utilidad 2 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_3'], 7.37, 'Utilidad 3 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_4'], 7.08, 'Utilidad 4 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_5'], 6.79, 'Utilidad 5 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_6'], 5.05, 'Utilidad 6 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_7'], 4.47, 'Utilidad 7 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_8'], 3.89, 'Utilidad 8 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_9'], 3.60, 'Utilidad 9 no es la esperada');
        $this->assertEquals($resultados['utilidades']['utilidad_10'], 3.31, 'Utilidad 10 no es la esperada');
    }
}
