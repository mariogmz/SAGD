<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

class IcecatCategoryFeatureGroupTableSeeder extends Seeder {

    protected $icecat_feed;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::beginTransaction();
        try {
            $categories_features = $this->getCategoriesFeaturesFromSource();
            $this->insertIntoDB($categories_features);
            DB::commit();
        }catch(ErrorException $ex){
            $this->command->getOutput()->writeln($ex->getMessage());
            $this->command->getOutput()->writeln($ex->getFile() . ' ' . $ex->getLine());
            $this->command->getOutput()->writeln($ex->getTraceAsString());
            DB::rollBack();
        }
    }

    private function getCategoriesFeaturesFromSource() {
        $this->icecat_feed = new Sagd\IcecatFeed();
        if (!file_exists('Icecat/categories_features.xml')) {
            $this->command->getOutput()->writeln('Fetching Categories Features from Icecat source...');
            $this->icecat_feed->downloadAndDecode('category_features');
        }
        $this->command->getOutput()->writeln('Parsing...');
        return  $this->icecat_feed->getCategoriesFeatureGroups(true);

    }

    private function insertIntoDB($categories_features) {
        $total = count($categories_features);
        $progress_bar = new ProgressBar($this->command->getOutput(), $total);
        $progress_bar->setFormat("<info>Seeding:</info> Icecat Categories Feature Groups: [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $progress_bar->start();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($categories_features as $category_feature) {
            App\IcecatCategoryFeatureGroup::create($category_feature);
            $progress_bar->advance();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $progress_bar->finish();
        $this->command->getOutput()->writeln('');

    }


}
