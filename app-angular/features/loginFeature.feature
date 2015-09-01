# language: es

Característica: Inicio de sesión
  Escenario: Pantalla de login
    Cuando Visito la pagina principal
    Entonces Se debe de ver el texto "Acceso" en ".login-card-block > h4"
    Y Se debe de ver el texto "Acceder" en "#acceder"

  Escenario: Cuando las credenciales son correctas
    Cuando Visito la pagina principal
    Entonces Pongo "sistemas@zegucom.com.mx" en el campo de "email"
    Y Pongo "test123" en el campo de "password"
    Cuando Presiono el boton "#acceder"
    Entonces Se debe de ver el texto "Inicio" en ".module-container"

  Escenario: Cuando las credenciales son incorrectas
    Cuando Visito la pagina principal
    Entonces Pongo "sistemas@zegucom.com.mx" en el campo de "email"
    Y Pongo "contraseñaincorrecta" en el campo de "password"
    Cuando Presiono el boton "#acceder"
    Entonces El elemento "#flash-error" debe tener clase "active"
