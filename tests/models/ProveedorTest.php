<?php


class ProveedorTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testClaveNoDebeTenerMasDe4Digitos()
    {
        $proveedor = factory(App\Proveedor::class)->make(['clave' => 'AAAAB']);
        $this->assertFalse($proveedor->isValid());

    }

    /**
     * @coversNothing
     */
    public function testClaveDebeSerUpperCase()
    {
        $proveedor = factory(App\Proveedor::class, 'uppercaseKey')->make();
        $this->assertTrue($proveedor->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPaginaWebDebeSerUnaUrlValida()
    {
        $proveedor = factory(App\Proveedor::class)->make([
            'pagina_web' => 'http:/paginaproveedor.io'
        ]);
        $this->assertFalse($proveedor->isValid());

    }

    /**
     * @coversNothing
     */
    public function testProveedorDebeTenerDatosBasicos()
    {
        $proveedor = factory(App\Proveedor::class)->make([
            'clave' => '',
        ]);
        $this->assertFalse($proveedor->isValid());
        $proveedor->razon_social = '';
        $this->assertFalse($proveedor->isValid());
        $proveedor->externo = '';
        $this->assertFalse($proveedor->isValid());
    }
}
