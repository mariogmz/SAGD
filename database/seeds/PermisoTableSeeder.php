<?php

use Illuminate\Database\Seeder;

use App\Permiso;
use Symfony\Component\Console\Helper\ProgressBar;

class PermisoTableSeeder extends Seeder {

    protected $routes;
    protected $permisosData;
    protected $progressBar;
    protected $errorBag;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->permisosData = [];
        $this->errorBag = [];

        $this->getRoutes();
        $this->parseRoutes();
        $this->guardarPermisos();
    }

    private function getRoutes()
    {
        $this->routes = Route::getRoutes();
        $this->setUpProgressBar();
    }

    private function parseRoutes()
    {
        foreach ($this->routes as $route) {
            $controllerFullPath = $route->getActionName();
            $match = [];
            if ( preg_match('/(\w+)@(\w+)/', $controllerFullPath, $match) > 0 ) {
                $controlador = $match[1];
                $accion = $match[2];
                $descripcion = "Este permiso autoriza en ".$controlador." a la accion ".$accion;
                $data = [
                    'controlador'   => $controlador,
                    'accion'        => $accion,
                    'descripcion'   => $descripcion
                ];
                array_push($this->permisosData, $data);
            }
            $this->progressBar->advance();
        }
    }

    private function guardarPermisos()
    {
        foreach ($this->permisosData as $data) {
            $permiso = new Permiso($data);
            if (!$permiso->save()) {
                array_push($this->errorBag, [
                    'errors' => $permiso->errors->all(),
                    'data' => $data
                ]);
            }
            $this->progressBar->start();
        }
        $this->progressBar->finish();
        $this->printErrors();
    }

    private function setUpProgressBar()
    {
        $elements = count($this->routes) * 2;
        $this->progressBar = new ProgressBar($this->command->getOutput(), $elements);
        $this->progressBar->setFormat("<info>Seeding:</info> Permisos : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $this->progressBar->start();
    }

    private function printErrors()
    {
        if (count($this->errorBag) > 0) {
            $messages = [];
            array_push($messages, "<error>Se encontraron ".count($this->errorBag)." errores</error>");
            array_push($messages, "<info>Seguramente son updates, esto es normal</info>");
            $this->command->getOutput()->writeln($messages);
        }
    }
}
