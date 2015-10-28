<?php

use Illuminate\Database\Seeder;

class ExistenciasTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->seed();
    }

    private function seed() {
        $existencias = $this->obtenerExistencias();
        $this->obtenerIds($existencias);
        $this->registrarExistencias($existencias);
    }

    /**
     * Consulta desde la base de datos legacy las existencias mayores a cero para todos
     * los productos, en todas las sucursales
     * @return array
     */
    private function obtenerExistencias() {
        $legacy = DB::connection('mysql_legacy');
        $query = 'SELECT
            producto_upc AS upc,
            sucursal_clave,
            existencia AS cantidad,
            apartado AS cantidad_apartado,
            preetransferencia AS cantidad_pretransferencia,
            entransferencia AS cantidad_transferencia,
            garc AS cantidad_garantia_cliente,
            garz AS cantidad_garantia_zegucom
        FROM
            producto_existencia
        WHERE
            existencia > 0;';
        $existencias_raw = $legacy->select($query);
        $existencias = [];
        foreach ($existencias_raw as $existencia) {
            array_push($existencias, (array) $existencia);
        }

        return $existencias;
    }

    /**
     * Cambia las claves de las sucursales legacy por los sucursal_id de la nueva base de datos,
     * también cambia los UPC's de los productos por los ID's de la nueva base de datos
     * @param array $existencias
     */
    private function obtenerIds(&$existencias) {
        $sucursales = [
            'dicotech'  => 1,
            'Arboledas' => 4,
            'leon'      => 2,
            'Zacatecas' => 3
        ];
        $productos = App\Producto::all()->toArray();
        reindexar('upc', $productos);

        foreach ($existencias as $key => &$existencia) {
            if (isset($productos[$existencia['upc']])) {

                $existencia['producto_id'] = $productos[$existencia['upc']]['id'];
                $existencia['sucursal_id'] = $sucursales[$existencia['sucursal_clave']];

                unset($existencia['upc']);
                unset($existencia['sucursal_clave']);

            } else {
                unset($existencias[$key]);
            }
        }
    }

    private function registrarExistencias(array $existencias) {
        $successful = 0;
        $fails = 0;
        foreach ($existencias as $existencia) {
            if (App\ProductoSucursal::whereProductoId($existencia['producto_id'])
                ->whereSucursalId($existencia['sucursal_id'])
                ->first()->existencia()->update(array_except($existencia, ['producto_id', 'sucursal_id']))
            ) {
                $successful ++;
            } else {
                $fails ++;
            }
            $this->command->getOutput()->write("\rSeeding Existencias, <info>Successful : {$successful}</info>. <error> Errors : {$fails}</error>");

        }
    }

}
