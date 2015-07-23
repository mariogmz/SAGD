<?php

class MarcaTest extends TestCase
{

  protected $marca;

  /**
   * @covers Marca::()
   */
  public function testClaveVaciaNoEsValido() {
    $marca = factory(App\Marca::class)->make(['clave' => '']);
    $this->assertFalse($marca->isValid());
    $this->assertFalse($marca->save());
  }

  /**
   * @covers Marca::()
   */
  public function testNombreVacioNoEsValido()
  {
    $marca = factory(App\Marca::class)->make(['nombre' => '']);
    $this->assertFalse($marca->isValid());
    $this->assertFalse($marca->save());
  }

  /**
   * @covers Marca::()
   */
  public function testClaveNoPuedeTenerMasDeTresDigitos()
  {
      $marca = factory(App\Marca::class)->make(['clave' => 'AAAA']);
      $this->assertFalse($marca->isValid());
      $this->assertFalse($marca->save());
  }

  /**
   * @covers Marca::()
   */
  public function testNoPuedeTenerMasDe45Digitos()
  {
      $marca = factory(App\Marca::class, 'longname')->make();
      $this->assertFalse($marca->isValid());
      $this->assertFalse($marca->save());
  }

  /**
   * @covers Marca::()
   */
  public function testClaveDebeSerGuardadaEnMayusculas()
  {
      $marca = factory(App\Marca::class)->make(['clave' => 'aaa']);
      $marca->save();
      $this->assertSame('AAA', $marca->clave);
  }
}
