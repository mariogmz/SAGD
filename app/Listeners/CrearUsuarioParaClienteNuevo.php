<?php

namespace App\Listeners;


use App\Cliente;
use App\Events\ClienteCreado;
use App\User;


class CrearUsuarioParaClienteNuevo {

    protected $cliente;
    protected $email;
    protected $password;

    /**
     * Create the event listener.
     *
     * @param Cliente $cliente
     */
    public function __construct(Cliente $cliente) {
        $this->cliente = $cliente;
    }

    /**
     * Handle the event.
     *
     * @param  ClienteCreado $event
     * @return void
     */
    public function handle(ClienteCreado $event) {
        $this->cliente = $event->cliente;
        if (array_key_exists('email', $event->datos)) {
            $this->email = $event->datos['email'];
        }
        if (array_key_exists('password', $event->datos)) {
            $this->password = \Hash::make($event->datos['password']);
        }

        $this->crearNuevoUsuario();
    }

    /**
     * Verifica si se estableció un nombre de usuario y un email para
     * un nuevo cliente, de no ser así, establece unos "predeterminados"
     * para poder crearle un usuario.
     *
     * El correo (si no fué proporcionado uno) se compone así:
     * [username] @ clientes.grupodicotech.com.mx
     *
     * La contraseña (si no fué proporcionada) se compone:
     * [username] + [id del cliente]
     */
    private function crearNuevoUsuario() {
        if (empty($this->password)) {
            $this->password = \Hash::make($this->cliente->usuario . $this->cliente->id);
        }
        if (empty($this->email)) {
            $this->email = $this->cliente->usuario . '@' . env('STUB_EMAIL_DOMAIN', 'clientes.grupodicotech.com.mx');
        }
        $user = new User();
        $user->fill([
            'email'          => $this->email,
            'password'       => $this->password,
            'morphable_id'   => $this->cliente->id,
            'morphable_type' => get_class($this->cliente)
        ]);

        $user->save();

    }
}
