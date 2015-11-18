<?php

use App\Salida;
use App\SalidaDetalle;
use App\ProductoMovimiento;
use App\Existencia;
use Carbon\Carbon;

use Illuminate\Foundation\Testing\DatabaseTransactions;


/**
 * @coversDefaultClass \App\Salida
 */
class SalidaTest extends TestCase {

    use DatabaseTransactions;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $salida = factory(App\Salida::class)->make();
        $this->assertTrue($salida->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $salida = factory(App\Salida::class, 'full')->create();
        $salida->motivo = 'MC Hammer';
        $this->assertTrue($salida->isValid('update'));
        $this->assertTrue($salida->save());
        $this->assertSame('MC Hammer', $salida->motivo);
    }

    /**
     * @coversNothing
     */
    public function testFechaSalidaEsOpcional()
    {
        $salida = factory(App\Salida::class)->make();
        $this->assertTrue($salida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaSalidaEsTimestamp()
    {
        $salida = factory(App\Salida::class)->make(['fecha_salida' => 'aaa']);
        $this->assertFalse($salida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMotivoEsObligatorio()
    {
        $salida = factory(App\Salida::class)->make(['motivo' => null]);
        $this->assertFalse($salida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMotivoNoPuedeSerLargo()
    {
        $salida = factory(App\Salida::class, 'longmotivo')->make();
        $this->assertFalse($salida->isValid());
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleado()
    {
        $salida = factory(App\Salida::class, 'full')->make();
        $this->assertInstanceOf(App\Empleado::class, $salida->empleado);
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleadoAssociate()
    {
        $salida = factory(App\Salida::class, 'full')->make(['empleado_id' => null]);
        $empleado = factory(App\Empleado::class)->create();
        $salida->empleado()->associate($empleado);
        $this->assertSame(1, count($salida->empleado));
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal()
    {
        $salida = factory(App\Salida::class, 'full')->make();
        $this->assertInstanceOf(App\Sucursal::class, $salida->sucursal);
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursalAssociate()
    {
        $salida = factory(App\Salida::class, 'full')->make(['sucursal_id' => null]);
        $sucursal = factory(App\Sucursal::class)->create();
        $salida->sucursal()->associate($sucursal);
        $this->assertSame(1, count($salida->sucursal));
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstado()
    {
        $salida = factory(App\Salida::class, 'full')->make();
        $this->assertInstanceOf(App\EstadoSalida::class, $salida->estado);
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstadoAssociate()
    {
        $salida = factory(App\Salida::class, 'full')->make(['estado_salida_id' => null]);
        $es = factory(App\EstadoSalida::class)->create();
        $salida->estado()->associate($es);
        $this->assertSame(1, count($salida->estado));
    }

    /**
     * @covers ::detalles
     * @group relaciones
     */
    public function testDetalles()
    {
        $salida = factory(App\Salida::class, 'full')->create();
        $sd = factory(App\SalidaDetalle::class, 'full')->create(['salida_id' => $salida->id]);
        $sds = $salida->detalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $sds);
        $this->assertInstanceOf(App\SalidaDetalle::class, $sds[0]);
        $this->assertCount(1, $sds);
    }

    /**
     * @covers ::crearDetalle
     * @group feature-salidas
     */
    public function testCrearDetalleConParametrosDeDetalleEsExitoso()
    {
        $this->setUpProducto();
        $producto = App\Producto::last();
        $sucursal = App\Sucursal::last();

        $salida = new Salida([
            'motivo' => 'Test',
            'empleado_id' => factory(App\Empleado::class)->create(['sucursal_id' => $sucursal->id])->id,
            'estado_salida_id' => factory(App\EstadoSalida::class)->create()->id,
            'sucursal_id' => $sucursal->id
        ]);

        $salida->save();

        $detalles = [
            'cantidad' => 5,
            'producto_id' => $producto->id,
            'upc' => $producto->upc
        ];

        $this->assertInstanceOf(App\SalidaDetalle::class, $salida->crearDetalle($detalles));
    }

    /**
     * @covers ::crearDetalle
     * @group feature-salidas
     */
    public function testCrearDetalleConParametrosIncorrectosNoEsExitoso()
    {
        $this->setUpProducto();
        $producto = App\Producto::last();
        $sucursal = App\Sucursal::last();

        $salida = new Salida([
            'motivo' => 'Test',
            'empleado_id' => factory(App\Empleado::class)->create(['sucursal_id' => $sucursal->id])->id,
            'estado_salida_id' => factory(App\EstadoSalida::class)->create()->id,
            'sucursal_id' => $sucursal->id
        ]);

        $salida->save();

        $detalles = [
            'cantidad' => 5,
            'upc' => $producto->upc
        ];

        $this->assertFalse($salida->crearDetalle($detalles));
    }

    private function setUpProducto()
    {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);

        $productoSucursal = $producto->productosSucursales()->where('sucursal_id', $sucursal->id)->first();
        $productoSucursal->existencia()->create([
            'cantidad' => 100,
            'cantidad_apartado' => 0,
            'cantidad_pretransferencia' => 0,
            'cantidad_transferencia' => 0,
            'cantidad_garantia_cliente' => 0,
            'cantidad_garantia_zegucom' => 0
        ]);
        return $producto;
    }
}
