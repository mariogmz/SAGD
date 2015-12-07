<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests;
use Sagd\IcecatFeed;

class IcecatController extends Controller {

    protected $icecat_feed;

    public function __construct(IcecatFeed $icecat_feed) {
        $this->icecat_feed = $icecat_feed;
        $this->middleware('jwt.auth');
    }

    /**
     * @param string $numero_parte
     * @param int $marca
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerFicha($numero_parte, $marca) {
        $this->authorize($this);
        if ($ficha = $this->icecat_feed->getProductSheetRaw($numero_parte, $marca)) {
            return response()->json([
                'message' => 'Se recuperó la ficha desde Icecat correctamente.',
                'ficha'   => $ficha
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo obtener la ficha desde Icecat',
                'error'   => 'No se encontró el número de parte o fabricante solicitados'
            ], 404);
        }

    }
}
