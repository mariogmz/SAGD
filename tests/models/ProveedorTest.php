<?php

use App\Sucursal;

class ProveedorTest extends TestCase {

    public function testClaveNoDebeTenerMasDe4Digitos()
    {
        $proveedor = factory(Sucursal::class)->make(['clave' => 'AAAAB']);
        $this->assertFalse($proveedor->isValid());

    }

    public function testClaveDebeSerUpperCase()
    {
        $proveedor = factory(Sucursal::class, 'uppercaseKey')->make();
        $this->assertTrue($proveedor->isValid());
    }

    public function testPaginaWebDebeSerUnaUrlValida()
    {
        $proveedor = factory(Sucursal::class)->make([
            'pagina_web' => 'http:/paginaproveedor.io'
        ]);
        $this->assertFalse($proveedor->isValid());

    }

    public function testProveedorDebeTenerDatosBasicos()
    {
        $proveedor = factory(Sucursal::class)->make([
            'clave' => '',
        ]);
        $this->assertFalse($proveedor->isValid());
        $proveedor->razon_social = '';
        $this->assertFalse($proveedor->isValid());
        $proveedor->externo = '';
        $this->assertFalse($proveedor->isValid());
    }
}
