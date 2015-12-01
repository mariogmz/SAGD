<?php

/**
 * @coversDefaultClass \App\Ficha
 */
class FichaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testProductoIdRequerido() {
        $ficha = factory(App\Ficha::class)->make();
        unset($ficha->producto_id);
        $this->assertFalse($ficha->isValid());
    }

    /**
     * @coversNothing
     */
    public function testProductoIdEntero() {
        $ficha = factory(App\Ficha::class)->make();
        $producto_id = $ficha->producto_id;
        $ficha->producto_id = 'texto';
        $this->assertFalse($ficha->isValid());
        $ficha->producto_id = $producto_id;
        $this->assertTrue($ficha->isValid());
    }

    /**
     * @coversNothing
     */
    public function testProductoIdUnico() {
        $ficha1 = factory(App\Ficha::class)->create();
        $ficha2 = factory(App\Ficha::class)->make([
            'producto_id' => $ficha1->producto_id
        ]);
        $this->assertFalse($ficha2->isValid());
        $this->assertFalse($ficha2->save());
    }

    /**
     * @coversNothing
     */
    public function testModeloEsActualizable() {
        $ficha = factory(App\Ficha::class)->create();
        $ficha->titulo = 'Titulo';
        $this->assertTrue($ficha->save());
    }

    /**
     * @coversNothing
     */
    public function testCalidadEsOpcional() {
        $ficha = factory(App\Ficha::class)->make();
        unset($ficha->calidad);
        $this->assertTrue($ficha->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTituloEsRequerido() {
        $ficha = factory(App\Ficha::class)->make();
        unset($ficha->titulo);
        $this->assertFalse($ficha->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTituloEsMaximo50Caracteres() {
        $ficha = factory(App\Ficha::class, 'titulolargo')->make();
        $this->assertFalse($ficha->isValid());
        $ficha->titulo = 'TITULO';
        $this->assertTrue($ficha->isValid());
    }


    /**
     * @coversNothing
     */
    public function testRevisadaEsBooleano() {
        $ficha = factory(App\Ficha::class)->make([
            'revisada' => 'revisada'
        ]);
        $this->assertFalse($ficha->isValid());
        $ficha->revisada = 1;
        $this->assertTrue($ficha->isValid());
        $ficha->revisada = false;
        $this->assertTrue($ficha->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRevisadaEsOpcional() {
        $ficha = factory(App\Ficha::class)->make();
        unset($ficha->revisada);
        $this->assertTrue($ficha->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRevisadaEsPorDefaultFalso() {
        $ficha = factory(App\Ficha::class)->make();
        unset($ficha->revisada);
        $this->assertTrue($ficha->save());
        $ficha = $ficha->fresh();
        $this->assertFalse(boolval($ficha->revisada));
    }

    /**
     * @coversNothing
     */
    public function testCalidadDebeSerUnValorDeLaLista(){
        $ficha = factory(App\Ficha::class)->make([
            'calidad' => 'OTRO'
        ]);
        $this->assertFalse($ficha->isValid());
        $ficha->calidad = 'INTERNO';
        $this->assertFalse($ficha->isValid());
        $ficha->calidad = 'FABRICANTE';
        $this->assertFalse($ficha->isValid());
        $ficha->calidad = 'ICECAT';
        $this->assertFalse($ficha->isValid());
        $ficha->calidad = 'NOEDITOR';
        $this->assertFalse($ficha->isValid());
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto() {
        $producto = factory(App\Producto::class)->create();
        $ficha = factory(App\Ficha::class)->create([
            'producto_id' => $producto->id
        ]);
        $result = $ficha->producto;
        $this->assertInstanceOf('App\Producto', $result);
        $this->assertEquals($producto->id, $result->id);
    }
}
