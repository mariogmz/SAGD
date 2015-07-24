<?php


class SucursalTest extends TestCase {

    public function testClaveDebeSerDe8CaracteresAlfa()
    {
        $sucursal = factory(App\Sucursal::class)->make();
        print_r($sucursal);
        $this->assertTrue($sucursal->isValid());
    }

    public function testClaveDebeSerUnica()
    {
        $sucursales = factory(App\Sucursal::class, 2)->make([
            'clave' => 'ABCDEFGT'
        ]);
        $this->assertFalse($sucursales[0]->isValid());
        $this->assertFalse($sucursales[1]->isValid());

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
            'proveedor_id' => ''
        ]);
        $this->assertFalse($sucursal->isValid());
    }

    public function testDomicilioAsociadoDebeExistir()
    {
        $this->markTestIncomplete('Not yet implemented...');
//        $sucursal = factory(App\Sucursal::class)->make([
//            'domicilio_id' => ''
//        ]);
//        $this->assertFalse($sucursal->isValid());
    }


}
