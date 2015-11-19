<?php

namespace App;

use DB;
use Carbon\Carbon;


/**
 * App\Cliente
 *
 * @property integer $id
 * @property string $email
 * @property string $usuario
 * @property string $password
 * @property string $nombre
 * @property string $fecha_nacimiento
 * @property string $sexo
 * @property string $ocupacion
 * @property string $fecha_verificacion_correo
 * @property string $fecha_expira_club_zegucom
 * @property string $referencia_otro
 * @property string $access_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $cliente_estatus_id
 * @property integer $sucursal_id
 * @property integer $cliente_referencia_id
 * @property integer $empleado_id
 * @property integer $vendedor_id
 * @property integer $rol_id
 * @property-read \App\ClienteEstatus $estatus
 * @property-read \App\ClienteReferencia $referencia
 * @property-read \App\Empleado $empleado
 * @property-read \App\Empleado $vendedor
 * @property-read \App\Sucursal $sucursal
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Empleado[] $empleados
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ClienteComentario[] $comentarios
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ClienteAutorizacion[] $autorizaciones
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PaginaWebDistribuidor[] $paginasWebDistribuidores
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domicilio[] $domicilios
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ServicioSoporte[] $serviciosSoportes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Rma[] $rmas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RazonSocialReceptor[] $razonesSociales
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereFechaNacimiento($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereSexo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereOcupacion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereFechaVerificacionCorreo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereFechaExpiraClubZegucom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereReferenciaOtro($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereAccessToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereClienteEstatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereSucursalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereClienteReferenciaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereEmpleadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereVendedorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereRolId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereDeletedAt($value)
 */
class Cliente extends LGGModel {

    protected $table = "clientes";
    public $timestamps = true;
    protected $fillable = ['usuario', 'nombre', 'fecha_nacimiento',
        'sexo', 'ocupacion', 'fecha_verificacion_correo',
        'fecha_expira_club_zegucom', 'referencia_otro',
        'cliente_estatus_id', 'rol_id', 'sucursal_id', 'cliente_referencia_id',
        'empleado_id', 'vendedor_id'];

    public static $rules = [
        'usuario'                   => 'required|max:20|unique:clientes,usuario',
        'nombre'                    => 'required|max:200',
        'fecha_nacimiento'          => 'date',
        'sexo'                      => 'in:HOMBRE,MUJER',
        'ocupacion'                 => 'max:45',
        'fecha_verificacion_correo' => 'date',
        'fecha_expira_club_zegucom' => 'date',
        'referencia_otro'           => 'max:50',
        'cliente_estatus_id'        => 'required|integer',
        'rol_id'                    => 'required|integer',
        'sucursal_id'               => 'required|integer',
        'cliente_referencia_id'     => 'required|integer',
        'empleado_id'               => 'integer',
        'vendedor_id'               => 'integer',
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Cliente::creating(function ($cliente) {
            return $cliente->isValid();
        });
        Cliente::updating(function ($cliente) {
            $cliente->updateRules = self::$rules;
            $cliente->updateRules['usuario'] .= ',' . $cliente->id;

            return $cliente->isValid('update');
        });
    }


    /**
     * Obtiene el Cliente Estatus asociado con el Cliente
     * @return App\ClienteEstatus
     */
    public function estatus() {
        return $this->belongsTo('App\ClienteEstatus', 'cliente_estatus_id');
    }


    /**
     * Obtiene el Cliente Referencia asociado con el Cliente
     * @return App\ClienteReferencia
     */
    public function referencia() {
        return $this->belongsTo('App\ClienteReferencia', 'cliente_referencia_id');
    }


    /**
     * Obtiene el Empleado asociado con el Cliente
     * @return App\Empleado
     */
    public function empleado() {
        return $this->belongsTo('App\Empleado', 'empleado_id');
    }

    /**
     * Obtiene el Vendedor asociado con el Cliente
     * @return App\Empleado
     */
    public function vendedor() {
        return $this->belongsTo('App\Empleado', 'vendedor_id');
    }


    /**
     * Obtiene la Sucursal asociada con el Cliente
     * @return App\Sucursal
     */
    public function sucursal() {
        return $this->belongsTo('App\Sucursal', 'sucursal_id');
    }


    /**
     * Obtiene los Empleados asociado con el Cliente
     * @return Illuminate\Database\Eloquent\Collection::class
     */
    public function empleados() {
        return $this->belongsToMany('App\Empleado', 'clientes_comentarios',
            'cliente_id', 'empleado_id');
    }


    /**
     * Obtiene los Comentarios asociado con el Cliente
     * @return Illuminate\Database\Eloquent\Collection::class
     */
    public function comentarios() {
        return $this->hasMany('App\ClienteComentario', 'cliente_id');
    }


    /**
     * Obtiene las Autorizaciones asociado con el Cliente
     * @return Illuminate\Database\Eloquent\Collection::class
     */
    public function autorizaciones() {
        return $this->hasMany('App\ClienteAutorizacion', 'cliente_id');
    }

    /**
     * Obtiene las paginas web distribuidor asociado con el Cliente
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function paginasWebDistribuidores() {
        return $this->hasMany('App\PaginaWebDistribuidor', 'cliente_id');
    }

    /**
     * Obtiene los Tabuladores por sucursal del Cliente
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function tabuladores() {
        return $this->hasMany('App\Tabulador');
    }

    /**
     * Obtiene los Domicilios asociado con el Cliente
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function domicilios() {
        return $this->belongsToMany('App\Domicilio', 'domicilios_clientes',
            'cliente_id', 'domicilio_id');
    }

    /**
     * Obtiene los soportes que ha solicitado el cliente
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function serviciosSoportes() {
        return $this->hasMany('App\ServicioSoporte');
    }

    /**
     * Obtiene los RMAs que ha solicitado el cliente
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rmas() {
        return $this->hasMany('App\Rma');
    }

    /**
     * Actualiza la fecha de verificacion de correo al dia de hoy
     * @return bool
     */
    public function verificoCorreo() {
        $this->fecha_verificacion_correo = Carbon::now();

        return true;
    }


    /**
     * Obtiene las Razones Sociales asociadas con el Cliente
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function razonesSociales() {
        return $this->hasMany('App\RazonSocialReceptor', 'cliente_id');
    }


    /**
    * Obtiene el User morphable con el Cliente
    * @return App\User
    */
    public function user()
    {
        return $this->morphOne('App\User', 'morphable');
    }

    /**
     * Crea cliente nuevo con tabuladores
    */
    public function saveWithData($parameters) {

        $this->fill($parameters);
        $email = $parameters['email'];
        $password = $parameters['password'];

        // Se inicia transacción al crear cliente, tabuladores y usuario
        DB::beginTransaction();

        if( $this->save() &&
            $this->guardarTabuladores($this->id) &&
            $this->guardarUsuario($email, $password)
        ){

            $cliente = new Cliente($parameters);
            $cliente->save();

            // Agregar autorizado(s)
            if(!empty($parameters['autorizado'])){

                if(!$this->autoriza($parameters['autorizado'])) {
                    DB::rollback();
                    return false;
                }
            }

            DB::commit();
            return true;
        
        }else {
            DB::rollback();
            return false;
        }

    }

    /**
     * Función que Actualiza cliente y sus relaciones
     * @param array $parameters
     * @return bool
     */
    public function actualizar($parameters) {

        DB::beginTransaction();


        $parameters['tabuladores'];

        $tabuladores = $this->tabuladores($parameters['tabuladores']);


        $this->fill($parameters);
        if( $this->save() &&
            $this->autorizaciones()->first()->update(['nombre_autorizado' => $parameters['autorizaciones'][0]['nombre_autorizado']]) &&
            $this->actualizarTabuladores($parameters['tabuladores'])
        ){
            DB::commit();
            return true;

        } else {

            DB::rollback();
            $this->errors(['Error test']);
            return false;
        }
    }

  /**
   * @return bool
   */
    public function guardarTabuladores($cliente_id) {
        $sucursales = Sucursal::all();

        foreach ($sucursales as $sucursal) {
          try{
            Tabulador::create(array('cliente_id'  => $cliente_id,
                                    'sucursal_id' => $sucursal->id,
                                    'tabulador' => 1,
                                    'tabulador_original' => 1,
                                    'habilitada' => 1,
                                    'venta_especial' => 0));
          }catch (Exception $e){
            return false;
          }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function actualizarTabuladores($tabuladores)
    {

       foreach($tabuladores as $tabulador)
       {

           $tab = Tabulador::findOrFail($tabulador['id']);

           if($tab) {
               $tab->tabulador = $tabulador['tabulador'];
               $tab->save();
           }else{
               return false;
           }
       }

       return true;
    }

    /**
     * @return bool
     */
    public function guardarUsuario($email, $password) {

        $user = new User(['email' => $email,
                                'password' => \Hash::make($password),
                                'morphable_id' => $this->id,
                                'morphable_type' => 'App\Cliente']);

        return $user->save();
    }

    /**
     * Realiza el trabajo de crear la autorizacion en base al parametro
     * @param App\Cliente o String
     * @return bool
     */
    public function autoriza($cliente) {

        $ca = new ClienteAutorizacion;
        $ca->cliente()->associate($this);

        if (is_string($cliente)) {
            $ca->nombre_autorizado = $cliente;
        } else {
            $ca->cliente_autorizado_id = $cliente->id;
        }
        if ($ca->save()) {
            return true;
        } else {
            return false;
        }
    }
}
