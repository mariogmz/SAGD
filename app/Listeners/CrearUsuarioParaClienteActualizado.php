<?php

namespace App\Listeners;


use App\Cliente;
use App\Events\ClienteActualizado;
use App\User;

class CrearUsuarioParaClienteActualizado {

    protected $cliente;
    protected $email;
    protected $password;


    /**
     * Create the event listener.
     * @param Cliente $cliente
     */
    public function __construct(Cliente $cliente) {
        $this->cliente = $cliente;
    }

    /**
     * Handle the event.
     *
     * @param  ClienteActualizado $event
     * @return void
     */
    public function handle(ClienteActualizado $event) {
        $this->cliente = $event->cliente;
        if (array_key_exists('user', $event->datos) && !empty($event->datos['user'])) {
            if (array_key_exists('email', $event->datos['user'])) {
                $this->email = $event->datos['user']['email'];
            } else {
                $this->email = $this->cliente->usuario . '@' . env('STUB_EMAIL_DOMAIN', 'clientes.grupodicotech.com.mx');
            }
            if (array_key_exists('password', $event->datos['user'])) {
                $this->password = \Hash::make($event->datos['user']['password']);
            } else {
                $this->password = \Hash::make($this->cliente->usuario . $this->cliente->id);
            }
        }

        if (empty($this->cliente->user)) {
            $this->crearNuevoUsuario();
        } else {
            $this->actualizarUsuario();
        }
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
        $user = new User();
        $user->fill([
            'email'          => $this->email,
            'morphable_id'   => $this->cliente->id,
            'morphable_type' => get_class($this->cliente)
        ]);
        $user->password = $this->password;
        $user->save();
    }

    private function actualizarUsuario() {
        $user = $this->cliente->user;
        $user->email = $this->email;
        $user->password = $this->password;
        $user->save();
    }
}
