<?php


class SucursalTest extends TestCase {

    public function testClaveDebeSerDe8CaracteresAlfa()
    {
        $sucursal = factory(App\Sucursal::class)->make();
        $this->assertTrue($sucursal->isValid());
    }

    public function testClaveDebeSerUnica()
    {
        $sucursales_validas = factory(App\Sucursal::class, 5)->make();
        $sucursales_invalidas = factory(App\Sucursal::class, 'mismaclave', 5)->make();
        for ($i = 0; $i < 5; $i ++)
        {
            $this->assertTrue($sucursales_validas[$i]->save());
            if (!$i)
            {
                $sucursales_invalidas[$i]->save();
            } else
            {
                $this->assertFalse($sucursales_invalidas[$i]->save());
            }
        }
    }

    public function testNombreDebeExistir()
    {
        $sucursal = factory(App\Sucursal::class)->make([
            'nombre' => ''
        ]);
        $this->assertFalse($sucursal->isValid());
    }

    public function testHorariosDebeExistir()
    {
        $sucursal = factory(App\Sucursal::class)->make([
            'horarios' => ''
        ]);
        $this->assertFalse($sucursal->isValid());
    }

    public function testProveedorAsociadoDebeExistir()
    {
        $sucursal = factory(App\Sucursal::class)->make([
            'proveedor_id' => null
        ]);
        $this->assertFalse($sucursal->isValid());
    }

    public function testDomicilioAsociadoDebeExistir()
    {
        $sucursal = factory(App\Sucursal::class)->make([
            'domicilio_id' => null
        ]);
        $this->assertFalse($sucursal->isValid());
    }


}
