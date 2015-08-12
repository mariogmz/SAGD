<?php

use Illuminate\Console\Command;
use Illuminate\Database\Seeder;

class CodigoPostalTableSeeder extends Seeder {

    /**
     * @var \Illuminate\Console\Command
     */
    protected $command;

    private $filePath = '\codigos_postales.txt';
    private $totalCount = 0;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $current = 1;
        $data = $this->parseFile();
        foreach ($data as $key => $row) {
            $cp = factory(App\CodigoPostal::class)->make($row);
            if (!$cp->save()) {
                echo "Error: ";
                print_r($cp);
            }
            $current++;
            $output = sprintf("%01.2f%%", ($current/$this->totalCount)*100);
            $this->command->getOutput()->write("\r<info>Seeding:</info> CodigoPostal [2/2] <comment>".$output."</comment>");
        }
        echo "\n";
    }

    private function parseFile() {
        $this->command->getOutput()->writeln("\r<info>Seeding:</info> CodigoPostal [1/2]");
        $data = [];
        $fileHandler = fopen($this->filePath, 'r');
        if ($fileHandler) {
            while (($line = fgets($fileHandler)) !== false) {
                $row = explode('|', $line);
                $data[$row[0]] = [
                    'estado'        => $row[4],
                    'municipio'     => $row[3],
                    'codigo_postal' => $row[0]
                ];
            }
            fclose($fileHandler);
        } else {
            throw new \Illuminate\Contracts\Filesystem\FileNotFoundException();
        }
        $this->totalCount = count($data);
        return $data;
    }

}
