<?php

/**
 * @coversDefaultClass \App\sagd\CalculadoraPrecios
 */
class CalculadoraPreciosTraitTest extends TestCase {

    public function testValoresInciales() {
        $calculadora = $this->getObjectForTrait('Sagd\CalculadoraPrecios');
        $this->assertAttributeEquals(0, 'factor_margen', $calculadora);
        $this->assertAttributeEquals(0.70, 'factor_diferencia_margen', $calculadora);
        $this->assertAttributeEmpty('utilidad_base', $calculadora);
        $this->assertAttributeEmpty('costo', $calculadora);
        $this->assertAttributeEmpty('margen_id', $calculadora);

        return $calculadora;
    }

    /**
     * @covers ::calcularPrecios
     * @covers ::calcularInterno
     * @covers ::calcularUtilidadesConMargen
     * @covers ::obtenerPrecios
     * @covers ::redondeos
     */
    public function testCalcularPreciosInternoConMargen() {
        $margen = factory(App\Margen::class)->make([
            'valor'               => 0.030,
            'valor_webservice_p1' => 0.110,
            'valor_webservice_p8' => 0.020
        ]);
        $this->assertTrue($margen->save());
        $calculadora = $this->getObjectForTrait('Sagd\CalculadoraPrecios');
        $resultados = $calculadora->calcularPrecios(5940.00, 5444.03, false, $margen->id);

        $this->assertSame($resultados['utilidades']['utilidad_1'], 9.11, 'Utilidad 1 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_2'], 8.04, 'Utilidad 2 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_3'], 6.97, 'Utilidad 3 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_4'], 5.89, 'Utilidad 4 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_5'], 4.82, 'Utilidad 5 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_6'], 3.75, 'Utilidad 6 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_7'], 3.38, 'Utilidad 7 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_8'], 3.00, 'Utilidad 8 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_9'], 2.63, 'Utilidad 9 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_10'], 2.25, 'Utilidad 10 no es la esperada');

        $this->assertSame($resultados['precios']['precio_1'], 5939.98, 'Precio 1 no es el esperado');
        $this->assertSame($resultados['precios']['precio_2'], 5881.62, 'Precio 2 no es el esperado');
        $this->assertSame($resultados['precios']['precio_3'], 5823.26, 'Precio 3 no es el esperado');
        $this->assertSame($resultados['precios']['precio_4'], 5764.90, 'Precio 4 no es el esperado');
        $this->assertSame($resultados['precios']['precio_5'], 5706.54, 'Precio 5 no es el esperado');
        $this->assertSame($resultados['precios']['precio_6'], 5648.18, 'Precio 6 no es el esperado');
        $this->assertSame($resultados['precios']['precio_7'], 5627.77, 'Precio 7 no es el esperado');
        $this->assertSame($resultados['precios']['precio_8'], 5607.35, 'Precio 8 no es el esperado');
        $this->assertSame($resultados['precios']['precio_9'], 5586.94, 'Precio 9 no es el esperado');
        $this->assertSame($resultados['precios']['precio_10'], 5566.52, 'Precio 10 no es el esperado');

    }

    /**
     * @covers ::calcularPrecios
     * @covers ::calcularInterno
     * @covers ::calcularUtilidadesSinMargen
     * @covers ::obtenerPrecios
     * @covers ::redondeos
     */
    public function testCalcularPreciosInternoSinMargen() {
        $calculadora = $this->getObjectForTrait('Sagd\CalculadoraPrecios');
        $resultados = $calculadora->calcularPrecios(5940.00, 5444.03);

        $this->assertSame($resultados['utilidades']['utilidad_1'], 9.11, 'Utilidad 1 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_2'], 7.66, 'Utilidad 2 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_3'], 7.37, 'Utilidad 3 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_4'], 7.08, 'Utilidad 4 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_5'], 6.79, 'Utilidad 5 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_6'], 5.05, 'Utilidad 6 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_7'], 4.47, 'Utilidad 7 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_8'], 3.89, 'Utilidad 8 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_9'], 3.60, 'Utilidad 9 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_10'], 3.31, 'Utilidad 10 no es la esperada');

        $this->assertSame($resultados['precios']['precio_1'], 5939.98, 'Precio 1 no es el esperado');
        $this->assertSame($resultados['precios']['precio_2'], 5861.08, 'Precio 2 no es el esperado');
        $this->assertSame($resultados['precios']['precio_3'], 5845.30, 'Precio 3 no es el esperado');
        $this->assertSame($resultados['precios']['precio_4'], 5829.52, 'Precio 4 no es el esperado');
        $this->assertSame($resultados['precios']['precio_5'], 5813.74, 'Precio 5 no es el esperado');
        $this->assertSame($resultados['precios']['precio_6'], 5719.06, 'Precio 6 no es el esperado');
        $this->assertSame($resultados['precios']['precio_7'], 5687.50, 'Precio 7 no es el esperado');
        $this->assertSame($resultados['precios']['precio_8'], 5655.94, 'Precio 8 no es el esperado');
        $this->assertSame($resultados['precios']['precio_9'], 5640.16, 'Precio 9 no es el esperado');
        $this->assertSame($resultados['precios']['precio_10'], 5624.38, 'Precio 10 no es el esperado');
    }

    /**
     * @covers ::calcularPrecios
     * @covers ::calcularExterno
     * @covers ::calcularUtilidadesConMargen
     * @covers ::obtenerPrecios
     * @covers ::redondeos
     */
    public function testCalcularPreciosExternoConMargen() {
        $margen = factory(App\Margen::class)->make([
            'valor'               => 0.030,
            'valor_webservice_p1' => 0.110,
            'valor_webservice_p8' => 0.020
        ]);
        $this->assertTrue($margen->save());
        $calculadora = $this->getObjectForTrait('Sagd\CalculadoraPrecios');
        $resultados = $calculadora->calcularPrecios(3930.19, 3540.71, true, $margen->id);

        $this->assertSame($resultados['utilidades']['utilidad_1'], 11.00, 'Utilidad 1 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_2'], 9.30, 'Utilidad 2 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_3'], 7.60, 'Utilidad 3 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_4'], 5.90, 'Utilidad 4 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_5'], 4.20, 'Utilidad 5 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_6'], 2.50, 'Utilidad 6 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_7'], 2.25, 'Utilidad 7 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_8'], 2.00, 'Utilidad 8 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_9'], 1.75, 'Utilidad 9 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_10'], 1.50, 'Utilidad 10 no es la esperada');

        $this->assertSame($resultados['precios']['precio_1'], 3930.19, 'Precio 1 no es el esperado');
        $this->assertSame($resultados['precios']['precio_2'], 3870.00, 'Precio 2 no es el esperado');
        $this->assertSame($resultados['precios']['precio_3'], 3809.80, 'Precio 3 no es el esperado');
        $this->assertSame($resultados['precios']['precio_4'], 3749.61, 'Precio 4 no es el esperado');
        $this->assertSame($resultados['precios']['precio_5'], 3689.42, 'Precio 5 no es el esperado');
        $this->assertSame($resultados['precios']['precio_6'], 3629.23, 'Precio 6 no es el esperado');
        $this->assertSame($resultados['precios']['precio_7'], 3620.38, 'Precio 7 no es el esperado');
        $this->assertSame($resultados['precios']['precio_8'], 3611.52, 'Precio 8 no es el esperado');
        $this->assertSame($resultados['precios']['precio_9'], 3602.67, 'Precio 9 no es el esperado');
        $this->assertSame($resultados['precios']['precio_10'], 3593.82, 'Precio 10 no es el esperado');

    }

    /**
     * @covers ::calcularPrecios
     * @covers ::calcularExterno
     * @covers ::calcularUtilidadesSinMargen
     * @covers ::obtenerPrecios
     * @covers ::redondeos
     */
    public function testCalcularPreciosExternoSinMargen() {
        $calculadora = $this->getObjectForTrait('Sagd\CalculadoraPrecios');
        $resultados = $calculadora->calcularPrecios(3930.19, 3540.71, true);

        $this->assertSame($resultados['utilidades']['utilidad_1'], 11.00, 'Utilidad 1 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_2'], 9.25, 'Utilidad 2 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_3'], 8.90, 'Utilidad 3 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_4'], 8.55, 'Utilidad 4 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_5'], 8.20, 'Utilidad 5 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_6'], 6.10, 'Utilidad 6 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_7'], 5.40, 'Utilidad 7 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_8'], 4.70, 'Utilidad 8 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_9'], 4.35, 'Utilidad 9 no es la esperada');
        $this->assertSame($resultados['utilidades']['utilidad_10'], 4.00, 'Utilidad 10 no es la esperada');

        $this->assertSame($resultados['precios']['precio_1'], 3930.19, 'Precio 1 no es el esperado');
        $this->assertSame($resultados['precios']['precio_2'], 3868.23, 'Precio 2 no es el esperado');
        $this->assertSame($resultados['precios']['precio_3'], 3855.83, 'Precio 3 no es el esperado');
        $this->assertSame($resultados['precios']['precio_4'], 3843.44, 'Precio 4 no es el esperado');
        $this->assertSame($resultados['precios']['precio_5'], 3831.05, 'Precio 5 no es el esperado');
        $this->assertSame($resultados['precios']['precio_6'], 3756.69, 'Precio 6 no es el esperado');
        $this->assertSame($resultados['precios']['precio_7'], 3731.91, 'Precio 7 no es el esperado');
        $this->assertSame($resultados['precios']['precio_8'], 3707.12, 'Precio 8 no es el esperado');
        $this->assertSame($resultados['precios']['precio_9'], 3694.73, 'Precio 9 no es el esperado');
        $this->assertSame($resultados['precios']['precio_10'], 3682.34, 'Precio 10 no es el esperado');
    }
}
