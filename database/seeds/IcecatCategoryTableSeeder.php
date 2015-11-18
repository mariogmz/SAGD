<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

class IcecatCategoryTableSeeder extends Seeder {

    private $icecat_feed;
    private $legacy_connection;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $icecat_categories = $this->buildNewRelationships();
        $this->insertIntoDB($icecat_categories);
    }

    /**
     * Get all the legacy relationships between subfamily and icecat category
     * @return array
     */
    private function getLegacyRelationships() {
        $this->legacy_connection = DB::connection('mysql_legacy');
        $legacy_icecat_categories = $this->legacy_connection
            ->table('producto_icecat_relacion')
            ->select(['categoria_icecat AS icecat_category_name', 'subfamilia_nueva as subfamilia_clave']);

        return (array) $legacy_icecat_categories;
    }

    /**
     * Download and get an array containing all the icecat categories from endpoint
     * @return array
     * @throws ErrorException
     */
    private function getIcecatCategories() {
        $this->icecat_feed = new \Sagd\IcecatFeed();
        $this->icecat_feed->downloadAndDecode('categories');

        return $this->icecat_feed->getCategories(true);
    }

    /**
     * Performs a match between icecat categories and subfamilies and sets the matching subfamily id to
     * icecat category record
     * @return array
     */
    private function buildNewRelationships() {
        $legacy_relationships = $this->getLegacyRelationships();
        $icecat_source = $this->getIcecatCategories();
        $subfamilias = App\Subfamilia::all(['id', 'clave']);

        reindexar('name', $icecat_source);
        reindexar('clave', $subfamilias);

        foreach ($legacy_relationships as $legacy_relationship) {
            if (isset($icecat_source[$legacy_relationship['icecat_category_name']])
                && isset($subfamilias[$legacy_relationship['subfamilia_clave']])
            ) {
                $subfamilia_id = $subfamilias[$legacy_relationship['subfamilia_clave']]->id;
                $icecat_source[$legacy_relationship->icecat_category_name]['subfamilia_id'] = $subfamilia_id;
            }
        }

        return $icecat_source;
    }

    /**
     * Insert all the categories into database using a chunk algorithm
     * @param array $categories
     * @param int $chunk_size
     */
    private function insertIntoDB($categories, $chunk_size = 500) {
        $total = count($categories);
        $progress_bar = new ProgressBar($this->command->getOutput(), $total);
        $progress_bar->setFormat("<info>Seeding:</info> Icecat Categories : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $progress_bar->start();
        $categoriesChunks = array_chunk($categories, $chunk_size);
        foreach ($categoriesChunks as $chunk) {
            DB::table('icecat_categories')->insert($chunk);
            $progress_bar->advance($chunk_size);
        }
        $progress_bar->finish();
    }

}
