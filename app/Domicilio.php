<?php

namespace App;


/**
 * App\Domicilio
 *
 * @property integer $id
 * @property string $calle
 * @property string $localidad
 * @property integer $codigo_postal_id
 * @property-read \App\CodigoPostal $codigoPostal
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Telefono[] $telefonos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Sucursal[] $sucursales
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Cliente[] $clientes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RazonSocialEmisor[] $razonesSocialesEmisores
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RazonSocialReceptor[] $razonesSocialesReceptores
 * @method static \Illuminate\Database\Query\Builder|\App\Domicilio whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Domicilio whereCalle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Domicilio whereLocalidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Domicilio whereCodigoPostalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Domicilio whereDeletedAt($value)
 */
class Domicilio extends LGGModel {

    protected $table = 'domicilios';
    public $timestamps = false;

    protected $fillable = ['calle', 'localidad', 'codigo_postal_id', 'telefono_id'];
    public static $rules = [
        'calle'            => 'required|string|max:100',
        'localidad'        => 'required|string|max:50',
        'codigo_postal_id' => 'required|integer',
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Domicilio::creating(function ($domicilio) {
            if (!$domicilio->isValid()) {
                return false;
            }

            return true;
        });
        Domicilio::updating(function ($domicilio) {
            $domicilio->updateRules = self::$rules;

            return $domicilio->isValid();
        });
    }

    /**
     * Guarda los cambios solicitados para los telefonos asociados, de acuerdo
     * al parametro de "action" que tengan:
     *
     * - 0. Crear nuevo
     * - 1. Actualizar existente
     * - 2. Eliminar registro
     *
     * @param array $telefonos
     * @return bool
     */
    public function guardarTelefonos(array $telefonos) {
        $nuevos = [];
        $por_actualizar = [];
        $por_eliminar = [];
        foreach($telefonos as $telefono) {
            if(array_key_exists('action', $telefono) ){
                switch ($telefono['action']) {
                    case 0:
                        array_push($nuevos, $telefono);
                        break;
                    case 1:
                        array_push($por_actualizar, $telefono);
                        break;
                    case 2:
                        array_push($por_eliminar, $telefono);
                        break;
                }
            }
        }

        return ($this->crearNuevosTelefonos($nuevos)
            && $this->actualizarTelefonos($por_actualizar)
            && $this->eliminarTelefonos($por_eliminar));
    }

    /**
     * Da de alta nuevos teléfonos para este domicilio
     * @param array $telefonos
     * @return bool
     */
    private function crearNuevosTelefonos(array $telefonos) {
        foreach($telefonos as $telefono) {
            $nuevo_telefono = new Telefono();
            $nuevo_telefono->fill($telefono);
            if(empty($this->telefonos()->save($nuevo_telefono))){
                return false;
            }
        }
        return true;
    }

    /**
     * Actualiza los teléfonos para este domiclio
     * @param array $telefonos
     * @return bool
     */
    private function actualizarTelefonos(array $telefonos) {
        foreach($telefonos as $telefono_raw) {
            $telefono = Telefono::find($telefono_raw['id']);
            if(empty($telefono) || !$telefono->update($telefono_raw)){
                return false;
            }
        }
        return true;
    }

    /**
     * Elimina los teléfonos solicitados para este domicilio
     * @param array $telefonos
     * @return bool
     */
    private function eliminarTelefonos(array $telefonos) {
        $telefonos_ids = collect($telefonos)->lists('id');
        return (count($telefonos) == 0 || Telefono::whereIn('id', $telefonos_ids)->delete() > 0);
    }

    /**
     * Obtiene el código postal asociado al domicilio
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function codigoPostal() {
        return $this->belongsTo('App\CodigoPostal');
    }

    /**
     * Obtiene el teléfono asociado al domicilio
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function telefonos() {
        return $this->hasMany('App\Telefono');
    }

    /**
     * Obtiene las sucursales asociadas al domicilio
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sucursales() {
        return $this->hasMany('App\Sucursal');
    }


    /**
     * Obtiene los Clientes asociados con el Domicilio
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clientes() {
        return $this->belongsToMany('App\Cliente', 'domicilios_clientes',
            'domicilio_id', 'cliente_id');
    }

    /**
     * Obtiene las Razones Sociales Emisores asociadas con el Domicilio
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function razonesSocialesEmisores() {
        return $this->hasMany('App\RazonSocialEmisor', 'domicilio_id');
    }


    /**
     * Obtiene las Razones Sociales Receptores asociadas con el Domicilio
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function razonesSocialesReceptores() {
        return $this->hasMany('App\RazonSocialReceptor', 'domicilio_id');
    }
}
