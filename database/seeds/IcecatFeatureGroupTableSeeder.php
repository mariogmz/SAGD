<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

class IcecatFeatureGroupTableSeeder extends Seeder
{
    protected $icecat_feed;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    private function getFeaturesFromIcecat(){
        $this->icecat_feed = new Sagd\IcecatFeed();
        $this->command->getOutput()->writeln('Fetching Icecat Feature Groups...');
        if(!file_exists('Icecat/feature_groups.xml')){
            $this->icecat_feed->downloadAndDecode('feature_groups');
        }
        return $this->icecat_feed->getFeatureGroups(true);
    }

    private function insertIntoDB(array $icecat_feature_groups){
        $total = count($icecat_feature_groups);
        $progress_bar = new ProgressBar($this->command->getOutput(), $total);
        $progress_bar->setFormat("<info>Seeding:</info> Icecat Feature Groups: [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $progress_bar->start();
        foreach($icecat_feature_groups as $icecat_feature_group){
            App\IcecatFeatureGroup::create($icecat_feature_group);
            $progress_bar->advance();
        }
        $progress_bar->finish();
        $this->command->getOutput()->writeln('');
    }
}
