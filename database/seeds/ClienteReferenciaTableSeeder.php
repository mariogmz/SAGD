<?php

use Illuminate\Database\Seeder;

class ClienteReferenciaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\ClienteReferencia::class)->create(['nombre' => 'Por medio de Google']);
        factory(App\ClienteReferencia::class)->create(['nombre' => 'Por medio de Facebook']);
        factory(App\ClienteReferencia::class)->create(['nombre' => 'Por medio de Youtube']);
        factory(App\ClienteReferencia::class)->create(['nombre' => 'Por recomendación de un amigo o familiar']);
        factory(App\ClienteReferencia::class)->create(['nombre' => 'Los escuché en la radio']);
        factory(App\ClienteReferencia::class)->create(['nombre' => 'Vi un anuncio suyo']);
        factory(App\ClienteReferencia::class)->create(['nombre' => 'Vi la tienda y entré']);
        factory(App\ClienteReferencia::class)->create(['nombre' => 'Otro']);
    }
}
