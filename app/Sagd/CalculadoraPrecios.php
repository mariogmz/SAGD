<?php
namespace Sagd;


trait CalculadoraPrecios {

    // En caso de que no se haya establecido un margen_id, equivale al valor del margen legacy 'Libre'
    protected $factor_margen = 0;
    protected $factor_diferencia_margen = 0.70;

    protected $precio_1;
    protected $utilidad_base;
    protected $costo;
    protected $margen_id;

    /**
     * Calcula todos los precios dado un precio base y un margen (opcional)
     * @param float $precio_1
     * @param float|null $costo
     * @param bool|null $externo
     * @param int|null $margen_id
     * @return array
     */
    public function calcularPrecios($precio_1, $costo, $externo = false, $margen_id = null) {
        $this->precio_1 = $precio_1;
        $this->costo = $costo;
        $this->margen_id = $margen_id;

        // Calcular utilidad 1
        $this->utilidad_base = round(100 * ($this->precio_1 / $this->costo - 1), 2);
        if ($this->utilidad_base > 0) {
            return $externo ? $this->calcularExterno() : $this->calcularInterno();
        } else {
            return null;
        }
    }

    private function calcularInterno() {
        $utilidades = null;
        if (is_null($this->margen_id)) {
            $utilidades = $this->calcularUtilidadesSinMargen();
        } else {
            $margen = \App\Margen::find($this->margen_id);
            $this->factor_margen = $margen->valor * 100;

            $utilidades = $this->calcularUtilidadesConMargen();
        }
        $precios = $this->obtenerPrecios($utilidades);

        return $this->redondeos([
            'precios'    => $precios,
            'utilidades' => $utilidades
        ]);
    }

    private function calcularExterno() {
        $utilidades = null;
        if (is_null($this->margen_id)) {
            $utilidades = $this->calcularUtilidadesSinMargen();
        } else {
            $margen = \App\Margen::find($this->margen_id);
            $this->utilidad_base = $margen->valor_webservice_p1 * 100;
            $this->factor_margen = $margen->valor_webservice_p8 * 100;
            $utilidades = $this->calcularUtilidadesConMargen();
        }
        $precios = $this->obtenerPrecios($utilidades);
        return $this->redondeos([
            'precios'    => $precios,
            'utilidades' => $utilidades
        ]);
    }

    private function calcularUtilidadesConMargen() {
        $diferencia_mayoreo = $this->factor_margen / 8;
        $diferencia_mayoreo = $diferencia_mayoreo > 5 ? 5 : $diferencia_mayoreo;
        $utilidad_1 = $this->utilidad_base;

        // Utilidades mayoristas (del 6 al 10)
        $utilidad_8 = intval($this->factor_margen);
        $utilidad_9 = $utilidad_8 - $diferencia_mayoreo;
        $utilidad_10 = $utilidad_9 - $diferencia_mayoreo;
        $utilidad_7 = $utilidad_8 + $diferencia_mayoreo;
        $utilidad_6 = $utilidad_7 + $diferencia_mayoreo;

        // Utilidades minoristas (del 1 al 5)
        $diferencia_menudeo = ($utilidad_1 - $utilidad_6) / 5;

        $utilidad_2 = $utilidad_1 - $diferencia_menudeo;
        $utilidad_3 = $utilidad_2 - $diferencia_menudeo;
        $utilidad_4 = $utilidad_3 - $diferencia_menudeo;
        $utilidad_5 = $utilidad_4 - $diferencia_menudeo;

        return compact('utilidad_1', 'utilidad_2', 'utilidad_3', 'utilidad_4', 'utilidad_5',
            'utilidad_6', 'utilidad_7', 'utilidad_8', 'utilidad_9', 'utilidad_10');
    }

    private function calcularUtilidadesSinMargen() {
        $utilidad_1 = $this->utilidad_base;
        $descuento_maximo = $utilidad_1 * $this->factor_diferencia_margen;
        $diferencia = $descuento_maximo / 11;

        // Utilidades minoristas (del 1 al 5)
        $utilidad_2 = $utilidad_1 - 2.5 * $diferencia;
        $utilidad_3 = $utilidad_1 - 3 * $diferencia;
        $utilidad_4 = $utilidad_1 - 3.5 * $diferencia;
        $utilidad_5 = $utilidad_1 - 4 * $diferencia;

        // Utilidades mayoristas (del 6 al 10)
        $utilidad_6 = $utilidad_1 - 7 * $diferencia;
        $utilidad_7 = $utilidad_1 - 8 * $diferencia;
        $utilidad_8 = $utilidad_1 - 9 * $diferencia;
        $utilidad_9 = $utilidad_1 - 9.5 * $diferencia;
        $utilidad_10 = $utilidad_1 - 10 * $diferencia;

        return compact('utilidad_1', 'utilidad_2', 'utilidad_3', 'utilidad_4', 'utilidad_5',
            'utilidad_6', 'utilidad_7', 'utilidad_8', 'utilidad_9', 'utilidad_10');
    }

    private function obtenerPrecios($utilidades) {
        $precio_1 = $this->costo * ($utilidades['utilidad_1'] / 100 + 1);
        $precio_2 = $this->costo * ($utilidades['utilidad_2'] / 100 + 1);
        $precio_3 = $this->costo * ($utilidades['utilidad_3'] / 100 + 1);
        $precio_4 = $this->costo * ($utilidades['utilidad_4'] / 100 + 1);
        $precio_5 = $this->costo * ($utilidades['utilidad_5'] / 100 + 1);
        $precio_6 = $this->costo * ($utilidades['utilidad_6'] / 100 + 1);
        $precio_7 = $this->costo * ($utilidades['utilidad_7'] / 100 + 1);
        $precio_8 = $this->costo * ($utilidades['utilidad_8'] / 100 + 1);
        $precio_9 = $this->costo * ($utilidades['utilidad_9'] / 100 + 1);
        $precio_10 = $this->costo * ($utilidades['utilidad_10'] / 100 + 1);

        return compact('precio_1', 'precio_2', 'precio_3', 'precio_4', 'precio_5',
            'precio_6', 'precio_7', 'precio_8', 'precio_9', 'precio_10');
    }

    /**
     * Redondea los resultados finales después de todas las operaciones
     * @param array $resultados
     * @return array
     */
    private function redondeos($resultados){
        for($i = 1; $i <= 10; $i++){
            $var = 'utilidad_' . $i;
            $resultados['utilidades'][$var] = round($resultados['utilidades'][$var], 2);
        }

        for($i = 1; $i <= 10; $i++){
            $var = 'precio_' . $i;
            $resultados['precios'][$var] = round($resultados['precios'][$var], 2);
        }
        return $resultados;
    }


}
