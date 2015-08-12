<?php

use Illuminate\Database\Seeder;

class CodigoPostalTableSeeder extends Seeder {

    private $filePath = '\codigos_postales.txt';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        echo 'Seeding: CodigoPostal -> ';
        $data = $this->parseFile();
        foreach ($data as $key => $row) {
            $cp = factory(App\CodigoPostal::class)->make($row);
            if (!$cp->save()) {
                echo "Error: ";
                print_r($cp);
            }
        }
        echo "[X]\n";
    }

    private function parseFile() {
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

        return $data;
    }

}
