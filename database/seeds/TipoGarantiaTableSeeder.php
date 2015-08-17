<?php

use Illuminate\Database\Seeder;

class TipoGarantiaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 0, 'descripcion' => 'Sin Garantia']);
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 0, 'descripcion' => 'Centro Servicio']);
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 1, 'descripcion' => '1 Dia']);
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 3, 'descripcion' => '3 Dias']);
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 7, 'descripcion' => '1 Semana']);
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 30, 'descripcion' => '1 Mes']);
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 60, 'descripcion' => '2 Meses']);
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 90, 'descripcion' => '3 Meses']);
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 120, 'descripcion' => '4 Meses']);
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 150, 'descripcion' => '5 Meses']);
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 180, 'descripcion' => '6 Meses']);
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 365, 'descripcion' => '1 Año']);
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 1095, 'descripcion' => '3 Años']);
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 1825, 'descripcion' => '5 Años']);
        DB::table('tipos_garantias')->insert(['seriado' => 0, 'dias' => 2555, 'descripcion' => '7 Años']);
    }
}
