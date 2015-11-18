<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

class IcecatSupplierTableSeeder extends Seeder {

    private $icecat_feed;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $icecat_suppliers = $this->buildNewRelationships();
        $this->insertIntoDB($icecat_suppliers);
    }

    /**
     * Download and gets an array containing all the icecat suppliers
     * @return array
     * @throws ErrorException
     */
    private function getIcecatSuppliers() {
        $this->command->getOutput()->writeln('Fetching Icecat Suppliers from endpoint...');

        $this->icecat_feed = new \Sagd\IcecatFeed();
        $this->icecat_feed->downloadAndDecode('suppliers');

        return $this->icecat_feed->getSuppliers(true);
    }

    private function buildNewRelationships() {
        $this->command->getOutput()->writeln('Building new relationships...');
        $icecat_suppliers = $this->getIcecatSuppliers();
        $marcas = App\Marca::all(['id', 'nombre'])->toArray();

        reindexar('nombre', $marcas);

        foreach ($icecat_suppliers as &$icecat_supplier) {
            if (array_key_exists($icecat_supplier['name'], $marcas)) {
                $icecat_supplier['marca_id'] = $marcas[$icecat_supplier['name']]['id'];
            }
        }

        return $icecat_suppliers;
    }

    private function insertIntoDB($icecat_suppliers) {
        $total = count($icecat_suppliers);
        $progress_bar = new ProgressBar($this->command->getOutput(), $total);
        $progress_bar->setFormat("<info>Seeding:</info> Icecat Suppliers : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $progress_bar->start();
        foreach ($icecat_suppliers as $supplier) {
            App\IcecatSupplier::create($supplier);
            $progress_bar->advance();
        }
        $progress_bar->finish();
    }
}
