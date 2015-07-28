<?php

/**
 * @coversDefaultClass \App\Proveedor
 */
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

    /**
     * @coversNothing
     */
    public function testClaveDebeSerUnica(){
        $proveedor1 = factory(App\Proveedor::class)->create();
        $proveedor2 = factory(App\Proveedor::class)->make([
            'clave' => $proveedor1->clave
        ]);
        $this->assertFalse($proveedor2->isValid());

    }

    /**
     * @coversNothing
     */
    public function testProveedorValido()
    {
        $proveedor = factory(App\Proveedor::class)->make();
        $this->assertTrue($proveedor->isValid());
    }

    /**
     * @covers ::sucursales
     */
    public function testSucursales()
    {
        $proveedor = factory(App\Proveedor::class)->create();
        $sucursales = factory(App\Sucursal::class, 5)->create([
            'proveedor_id' => $proveedor->id
        ]);
        $sucursales_resultado = $proveedor->sucursales;
        for ($i = 0; $i < 5; $i ++)
        {
            $this->assertEquals($sucursales[$i], $sucursales_resultado[$i]);
        }
    }

    /**
     * @covers ::productos()
     */
    public function testProductos()
    {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $proveedor = $sucursal->proveedor;
        $producto->addProveedor($proveedor);
        $productos = $proveedor->productos;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $productos);
        $this->assertInstanceOf(App\Producto::class, $productos[0]);
    }
}
