<?php

/**
 * @coversDefaultClass \App\User
 */
class UserTest extends TestCase {


    /**
     * @coversNothing
     */
    public function testModeloUserExiste() {
        $user = factory(App\User::class)->make();
        $this->assertInstanceOf(App\User::class, $user);
        $this->assertTrue($user->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $user = factory(App\User::class)->create();
        $user->morphable_type = 'Empleado';
        $this->assertTrue($user->isValid('update'));
        $this->assertTrue($user->save());
        $this->assertSame("Empleado", $user->morphable_type);
    }

    /**
     * @coversNothing
     */
    public function testMorphableIdEsObligatorio()
    {
        $user = factory(App\User::class)->make(['morphable_id' => null]);
        $this->assertFalse($user->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMorphableTypeEsObligatorio()
    {
        $user = factory(App\User::class)->make(['morphable_type' => null]);
        $this->assertFalse($user->isValid());
    }

    /**
     * @covers ::morphable
     * @group relaciones
     */
    public function testMorphableToCliente()
    {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $user = factory(App\User::class)->make([
            'morphable_id' => $cliente->id,
            'morphable_type' => get_class($cliente)
        ]);
        $this->assertTrue($user->save());
        $this->assertInstanceOf(App\Cliente::class, $user->morphable);
    }

    /**
     * @covers ::morphable
     * @group relaciones
     */
    public function testMorphableToEmpleado()
    {
        $empleado = factory(App\Empleado::class)->create();
        $user = factory(App\User::class)->make([
            'morphable_id' => $empleado->id,
            'morphable_type' => get_class($empleado)
        ]);
        $this->assertTrue($user->save());
        $this->assertInstanceOf(App\Empleado::class, $user->morphable);
    }
}
