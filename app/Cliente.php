<?php

namespace App;

class Cliente extends LGGModel
{
    //
    protected $table = "clientes";
    public $timestamps = false;
    protected $fillable = ['email', 'usuario', 'nombre', 'fecha_nacimiento',
        'sexo', 'ocupacion', 'fecha_verificacion_correo',
        'fecha_expira_club_zegucom', 'referencia_otro'];

    public static $rules = [
        'email' => 'required|email|max:45|unique:clientes',
        'usuario' => 'required|max:20',
        'password' => 'min:64|max:64',
        'nombre' => 'required|max:200',
        'fecha_nacimiento' => 'date',
        'sexo' => 'required|in:HOMBRE,MUJER',
        'ocupacion' => 'max:45',
        'fecha_verificacion_correo' => 'date',
        'fecha_expira_club_zegucom' => 'date',
        'referencia_otro' => 'max:50',
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        Cliente::creating(function($cliente){
            if ( !$cliente->isValid() ){
                return false;
            }
            return true;
        });
    }


    /**
    * Obtiene el Cliente Estatus asociado con el Cliente
    * @return App\ClienteEstatus
    */
    public function estatus()
    {
        return $this->belongsTo('App\ClienteEstatus', 'cliente_estatus_id');
    }


    /**
    * Obtiene el Cliente Referencia asociado con el Cliente
    * @return App\ClienteReferencia
    */
    public function referencia()
    {
        return $this->belongsTo('App\ClienteReferencia', 'cliente_referencia_id');
    }


    /**
    * Obtiene el Empleado asociado con el Cliente
    * @return App\Empleado
    */
    public function empleado()
    {
        return $this->belongsTo('App\Empleado', 'empleado_id');
    }

    /**
    * Obtiene el Vendedor asociado con el Cliente
    * @return App\Empleado
    */
    public function vendedor()
    {
        return $this->belongsTo('App\Empleado', 'vendedor_id');
    }


    /**
    * Obtiene la Sucursal asociada con el Cliente
    * @return App\Sucursal
    */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal', 'sucursal_id');
    }


    /**
    * Obtiene los Empleados asociado con el Cliente
    * @return Illuminate\Database\Eloquent\Collection::class
    */
    public function empleados()
    {
        return $this->belongsToMany('App\Empleado', 'clientes_comentarios',
            'cliente_id', 'empleado_id');
    }


    /**
    * Obtiene los Comentarios asociado con el Cliente
    * @return Illuminate\Database\Eloquent\Collection::class
    */
    public function comentarios()
    {
        return $this->hasMany('App\ClienteComentario', 'cliente_id');
    }


    /**
    * Obtiene las Autorizaciones asociado con el Cliente
    * @return Illuminate\Database\Eloquent\Collection::class
    */
    public function autorizaciones()
    {
        return $this->hasMany('App\ClienteAutorizacion', 'cliente_id');
    }

    /**
     * Realiza el trabajo de crear la autorizacion en base al parametro
     * @param App\Cliente o String
     * @return bool
     */
    public function autoriza($cliente)
    {
        $ca = new ClienteAutorizacion;
        $ca->cliente()->associate($this);

        if (is_string($cliente)) {
            $ca->nombre_autorizado = $cliente;
        } else {
            $ca->cliente_autorizado_id = $cliente->id;
        }
        if ( $ca->save() ){
            return true;
        } else {
            return false;
        }
    }


    /**
    * Obtiene las paginas web distribuidor asociado con el Cliente
    * @return Illuminate\Database\Eloquent\Collection::class
    */
    public function paginasWebDistribuidores()
    {
        return $this->hasMany('App\PaginaWebDistribuidor', 'cliente_id');
    }


    /**
    * Obtiene los Domicilios asociado con el Cliente
    * @return Illuminate\Database\Eloquent\Collection::class
    */
    public function domicilios()
    {
        return $this->belongsToMany('App\Domicilio', 'domicilios_clientes',
            'cliente_id', 'domicilio_id');
    }
}
