<?php

use App\Proveedor;

class ProveedorTest extends TestCase {

    public function testClaveNoDebeTenerMasDe4Digitos()
    {
        $proveedor = factory(Proveedor::class)->make(['clave' => 'AAAAB']);
        $this->assertFalse($proveedor->isValid());

    }

    public function testClaveDebeSerUpperCase()
    {
        $proveedor = factory(Proveedor::class, 'uppercaseKey')->make();
        $this->assertTrue($proveedor->isValid());
    }

    public function testPaginaWebDebeSerUnaUrlValida()
    {
        $proveedor = factory(Proveedor::class)->make([
            'pagina_web' => 'http:/paginaproveedor.io'
        ]);
        $this->assertFalse($proveedor->isValid());

    }

    public function testProveedorDebeTenerDatosBasicos()
    {
        $proveedor = factory(Proveedor::class)->make([
            'clave' => '',
        ]);
        $this->assertFalse($proveedor->isValid());
        $proveedor->razon_social = '';
        $this->assertFalse($proveedor->isValid());
        $proveedor->externo = '';
        $this->assertFalse($proveedor->isValid());
    }
}
