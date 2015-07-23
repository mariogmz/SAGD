<?php

class MarcaTest extends TestCase
{

  protected $marca;

  /**
   *
   */
  public function testClaveVaciaNoEsValido() {
    $marca = new \App\Marca;
    $marca->clave = "";
    $marca->nombre = "ASUS";
    $this->assertFalse($marca->isValid());
  }

  /**
   * @covers class::()
   */
  public function testNombreVacioNoEsValido()
  {
    $marca = factory(App\Marca::class)->make(['nombre' => '']);
    $this->assertFalse($marca->isValid());
  }
}
