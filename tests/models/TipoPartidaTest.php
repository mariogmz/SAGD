<?php

/**
 * @coversDefaultClass \App\TipoPartida
 */
class TipoPartidaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testClaveEsRequerida(){
        $tipo_partida = factory(App\TipoPartida::class)->make([
            'clave' => null
        ]);
        $this->assertFalse($tipo_partida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveNoMayorDe25Caracteres(){
        $tipo_partida = factory(App\TipoPartida::class, 'clavelarga')->make();
        $this->assertFalse($tipo_partida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveUnica(){
        $tipo_partida1 = factory(App\TipoPartida::class)->create();
        $tipo_partida2 = factory(App\TipoPartida::class)->make([
            'clave' => $tipo_partida1->clave
        ]);
        $this->assertFalse($tipo_partida2->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsRequerido(){
        $tipo_partida = factory(App\TipoPartida::class)->make([
            'nombre' => null
        ]);
        $this->assertFalse($tipo_partida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoMayorDe50Caracteres(){
        $tipo_partida = factory(App\TipoPartida::class, 'nombrelargo')->make();
        $this->assertFalse($tipo_partida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTicketEsRequerido(){
        $tipo_partida = factory(App\TipoPartida::class)->make([
            'ticket' => null
        ]);
        $this->assertFalse($tipo_partida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTicketEsBooleano(){
        $tipo_partida = factory(App\TipoPartida::class)->make([
            'ticket' => 'smeagol'
        ]);
        $this->assertFalse($tipo_partida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTicketSumaEsRequerido(){
        $tipo_partida = factory(App\TipoPartida::class)->make([
            'ticket_suma' => null
        ]);
        $this->assertFalse($tipo_partida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTicketSumaEsBooleano(){
        $tipo_partida = factory(App\TipoPartida::class)->make([
            'ticket_suma' => 'smeagol'
        ]);
        $this->assertFalse($tipo_partida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPagoEsRequerido(){
        $tipo_partida = factory(App\TipoPartida::class)->make([
            'nombre' => null
        ]);
        $this->assertFalse($tipo_partida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPagoEsBooleano(){
        $tipo_partida = factory(App\TipoPartida::class)->make([
            'pago' => 'smeagol'
        ]);
        $this->assertFalse($tipo_partida->isValid());
    }

    /**
     * @covers ::tiposPartidasCortesConceptos
     */
    public function testTiposPartidasCortesConceptos(){
        $parent = factory(App\TipoPartida::class)->create();
        factory(App\TipoPartidaCorteConcepto::class)->create([
            'tipo_partida_id' => $parent->id
        ]);
        $children = $parent->tiposPartidasCortesConceptos;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\TipoPartidaCorteConcepto',$children[0]);
        $this->assertCount(1, $children);
    }
}
