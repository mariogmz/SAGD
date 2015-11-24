<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

class IcecatFeatureTableSeeder extends Seeder {

    protected $icecat_feed;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::beginTransaction();
        try {
            $this->insertIntoDB($this->getFeaturesFromIcecat());
            DB::commit();
        }catch(ErrorException $ex){
            $this->command->getOutput()->writeln($ex->getMessage());
            $this->command->getOutput()->writeln($ex->getFile() . ' ' . $ex->getLine());
            $this->command->getOutput()->writeln($ex->getTraceAsString());
            DB::rollBack();
        }
    }

    /**
     * @return array|int
     */
    private function getFeaturesFromIcecat() {
        $this->icecat_feed = new Sagd\IcecatFeed();
        $this->command->getOutput()->writeln('Fetching Icecat Features...');
        $this->icecat_feed->downloadAndDecode('features');

        return $this->icecat_feed->getFeatures(true);
    }

    private function insertIntoDB(array $icecat_features) {
        $total = count($icecat_features);
        $progress_bar = new ProgressBar($this->command->getOutput(), $total);
        $progress_bar->setFormat("<info>Seeding:</info> Icecat Features : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $progress_bar->start();
        foreach ($icecat_features as $icecat_feature) {
            App\IcecatFeature::create($icecat_feature);
            $progress_bar->advance();
        }
        $progress_bar->finish();
        $this->command->getOutput()->writeln('');
    }
}
