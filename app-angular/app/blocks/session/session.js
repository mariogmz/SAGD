// app/blocks/session/session.js

(function (){
  'use strict';

  angular
    .module('blocks.session')
    .factory('session', session);

  session.$inject = ['$auth', '$state', '$http', 'api'];

  function session($auth, $state, $http, api){

    var auth = $auth;
    var state = $state;

    var loginError = false;
    var loginErrorText = '';

    var isAuthenticated = auth.isAuthenticated;

    var redirectToHomeIfAuthenticated = function (){
      if (isAuthenticated()) {
        state.go('home', {});
      }
    };

    var logoutUserIfAuthenticated = function (){
      if (isAuthenticated()) {
        auth.removeToken();
        localStorage.removeItem('empleado');
      }
    };

    var getEmpleado = function (){
      api.get('/authenticate/empleado').then(setEmpleadoToLocalStorage);
    };

    var setEmpleadoToLocalStorage = function (response){
      localStorage.setItem('empleado', JSON.stringify(response.data.empleado));
      $state.go('home', {});
    };

    var loginWithCredentials = function (credentials){
      return auth.login(credentials).then(getEmpleado, function (error){
        loginError = true;
        loginErrorText = error.data.error;
      });
    };

    var login = function (email, password){
      redirectToHomeIfAuthenticated();
      var credentials = {
        email: email,
        password: password
      };
      return loginWithCredentials(credentials);
    };

    var logout = function (){
      logoutUserIfAuthenticated();
      state.go('login', {});
    };

    function resetEmpleado() {
      return api.get('/authenticate/empleado').then(function(response){
        localStorage.setItem('empleado', JSON.stringify(response.data.empleado));
      });
    }

    return {
      isAuthenticated: isAuthenticated,
      resetEmpleado: resetEmpleado,
      obtenerEmpleado: function (){
        return JSON.parse(localStorage.getItem('empleado'));
      },
      login: login,
      getLoginError: function (){
        return loginError;
      },
      cleanLoginError: function (){
        loginError = false;
      },
      getLoginErrorText: function (){
        return loginErrorText;
      },
      logout: logout
    };

  }
}());
