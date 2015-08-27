// app/blocks/session/session.module.js

(function() {
    'use strict';

    angular
        .module('blocks.session')
        .factory('session', session);

    session.$inject = ['$auth', '$state', '$http'];

    function session($auth, $state, $http) {

      return function(){
        var auth = $auth;
        var state = $state;
        var loginError;
        var loginErrorText;

        var isAuthenticated = auth.isAuthenticated;

        var redirectToHomeIfAuthenticated = function () {
          if(isAuthenticated()){
            state.go('home', {});
          }
        };

        var logoutUserIfAuthenticated = function () {
          if(isAuthenticated()){
            auth.removeToken();
            localStorage.removeItem('empleado');
          }
        };

        var getEmpleado = function() {
          return $http.get('http://api.sagd.app/api/v1/authenticate/empleado');
        };

        var setEmpleadoToLocalStorage = function(response) {
          var empleado = JSON.stringify(response.data.empleado);
          localStorage.setItem('empleado', empleado);
          state.go('home', {});
        };

        var loginWithCredentials = function (credentials) {
          auth.login(credentials).then(getEmpleado, function(error){
            loginError = true;
            loginErrorText = error.data.error;
          }).then(setEmpleadoToLocalStorage);
        };


        var login = function (email, password) {
          redirectToHomeIfAuthenticated();
          var credentials = {
            email: email,
            password: password
          }
          loginWithCredentials(credentials);
        };

        var logout = function () {
          logoutUserIfAuthenticated();
          state.go('login', {});
        };

        return {
          isAuthenticated : isAuthenticated,
          login : login,
          loginError : loginError,
          loginErrorText : loginErrorText,
          logout : logout,
        };
      }();

    }
}());
