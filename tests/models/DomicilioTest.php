<?php

use App\Domicilio;

class DomicilioTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testDomicilioEsValido()
    {
        $domicilio = factory(Domicilio::class)->make();
        $this->assertTrue($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCalleEsRequerida()
    {
        $domicilio = factory(Domicilio::class)->make([
            'calle' => ''
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testLocalidadEsRequerida()
    {
        $domicilio = factory(Domicilio::class)->make([
            'localidad' => ''
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCodigoPostalAsociadoEsRequerido()
    {
        $domicilio = factory(Domicilio::class)->make([
            'codigo_postal_id' => null
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTelefonoAsociadoEsRequerido()
    {
        $domicilio = factory(Domicilio::class)->make([
            'telefono_id' => null
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    /**
     * @covers ::codigoPostal
     */
    public function testCodigoPostal()
    {
        $codigo_postal = factory(App\CodigoPostal::class)->create();
        $domicilio = factory(App\Domicilio::class)->create([
            'codigo_postal_id' => $codigo_postal->id
        ]);
        $codigo_postal_resultado = $domicilio->codigoPostal;
        $this->assertEquals($codigo_postal, $codigo_postal_resultado);
    }

    /**
     * @covers ::telefono
     */
    public function testTelefono()
    {
        $telefono = factory(App\Telefono::class)->create();
        $domicilio = factory(App\Domicilio::class)->create([
            'telefono_id' => $telefono->id
        ]);
        $telefono_resultado = $domicilio->telefono;
        $this->assertEquals($telefono, $telefono_resultado);
    }

    /**
     * @covers ::sucursales
     */
    public function testSucursales()
    {
        $domicilio = factory(App\Domicilio::class)->create();
        $sucursales = factory(App\Sucursal::class, 5)->create([
            'domicilio_id' => $domicilio->id
        ]);
        $sucursales_resultado = $domicilio->sucursales;
        for ($i = 0; $i < 5; $i ++)
        {
            $this->assertEquals($sucursales_resultado[$i], $sucursales[$i]);
        }
    }
}
