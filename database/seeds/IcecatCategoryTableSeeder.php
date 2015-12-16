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
        DB::beginTransaction();
        try {
            $icecat_categories = $this->buildNewRelationships();
            $this->insertIntoDB($icecat_categories);
            DB::commit();
        } catch (ErrorException $ex) {
            $this->command->getOutput()->writeln($ex->getMessage());
            $this->command->getOutput()->writeln($ex->getFile() . ' ' . $ex->getLine());
            $this->command->getOutput()->writeln($ex->getTraceAsString());
            DB::rollBack();
        }
    }

    /**
     * Get all the legacy relationships between subfamily and icecat category
     * @return array
     */
    private function getLegacyRelationships() {
        $this->command->getOutput()->writeln('Fetching legacy icecat relationships...');
        $this->legacy_connection = DB::connection('mysql_legacy');
        $legacy_icecat_categories = $this->legacy_connection
            ->table('producto_icecat_relacion')
            ->select(['categoria_icecat AS icecat_category_name', 'subfamilia_nueva as subfamilia_clave'])
            ->get();

        return (array) $legacy_icecat_categories;
    }

    /**
     * Download and get an array containing all the icecat categories from endpoint
     * @return array
     * @throws ErrorException
     */
    private function getIcecatCategories() {
        $this->command->getOutput()->writeln('Getting Icecat Categories from Endpoint...');
        $this->icecat_feed = new \Sagd\IcecatFeed();
        $this->icecat_feed->downloadAndDecode('categories');

        $this->command->getOutput()->writeln('Parsing...');
        $icecat_categories = $this->icecat_feed->getCategories(true, true);
        array_unshift($icecat_categories, [
            'icecat_id'                 => 1,
            'description'               => 'Icecat Master Category',
            'name'                      => 'Icecat Master Category',
            'keyword'                   => 'null',
            'icecat_parent_category_id' => 'null'
        ]);
        $this->command->getOutput()->writeln('Parsed!');

        return $icecat_categories;
    }

    /**
     * Performs a match between icecat categories and subfamilies and sets the matching subfamily id to
     * icecat category record
     * @return array
     */
    private function buildNewRelationships() {
        $this->command->getOutput()->writeln('Building new relationships...');
        $legacy_relationships = $this->getLegacyRelationships();
        $icecat_source = $this->getIcecatCategories();
        $subfamilias = App\Subfamilia::all(['id', 'clave'])->toArray();

        reindexar('name', $icecat_source);
        reindexar('clave', $subfamilias);

        foreach ($legacy_relationships as $legacy_relationship) {
            if (array_key_exists($legacy_relationship->icecat_category_name, $icecat_source) &&
                array_key_exists($legacy_relationship->subfamilia_clave, $subfamilias)
            ) {
                $subfamilia_id = $subfamilias[$legacy_relationship->subfamilia_clave]['id'];
                $icecat_source[$legacy_relationship->icecat_category_name]['subfamilia_id'] = $subfamilia_id;
            }
        }

        return $icecat_source;
    }

    /**
     * Insert all the categories into database
     * @param array $categories
     */
    private function insertIntoDB($categories) {
        $total = count($categories);
        $progress_bar = new ProgressBar($this->command->getOutput(), $total);
        $progress_bar->setFormat("<info>Seeding:</info> Icecat Categories : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $progress_bar->start();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($categories as $category) {
            App\IcecatCategory::create($category);
            $progress_bar->advance();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $progress_bar->finish();
        $this->command->getOutput()->writeln('');
    }

}
