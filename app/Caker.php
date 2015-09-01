<?php

namespace App;


use Faker\Factory;

class Caker {

    private static $faker;

    public static function getInstance() {
        if (null === static::$faker) {
            static::$faker = Factory::create();
        }

        return static::$faker;
    }

    protected function __construct() {
    }

    private function __clone() {
    }

    private function __wakeup() {
    }

    public static function realUnique($tabla = null, $columna = null, $tipo = null, $arguments = null) {
        if (is_null($tabla) or is_null($columna) or is_null($tipo)) {
            throw new \InvalidArgumentException;
        }
        try {
            switch ($tipo) {
                case "regexify":
                    $value = self::getInstance()->unique()->regexify($arguments);
                    break;
                case "userName":
                    $value = self::getInstance()->unique()->userName;
                    break;
                case "email":
                    $value = self::getInstance()->unique()->email;
                    break;
            }
        } catch (\OverflowException $ex) {
            self::refresh();
            switch ($tipo) {
                case "regexify":
                    $value = self::getInstance()->unique()->regexify($arguments);
                    break;
                case "userName":
                    $value = self::getInstance()->unique()->userName;
                    break;
                case "email":
                    $value = self::getInstance()->unique()->email;
                    break;
            }
        }

        return $value;
    }

    public static function getEstadoVenta() {
        $ev = EstadoVenta::all()->first();
        if (is_null($ev)) {
            return factory(EstadoVenta::class)->create();
        }

        return $ev;
    }

    public static function getSucursal() {
        $s = Sucursal::all()->first();
        if (is_null($s)) {
            return factory(Sucursal::class)->create();
        }

        return $s;
    }

    public static function pluck($key, $data) {
        return array_reduce($data, function ($result, $array) use ($key) {
            isset($array[$key]) && $result[] = $array[$key];

            return $result;
        }, array());
    }

    private static function refresh() {
        echo "Refreshing Faker and running DB reset...\n";
        \Artisan::call('reset:db', ['--force' => true]);
        static::$faker = Factory::create();
        echo "DONE!...\n";
    }
}
