// app.js

(function () {

  'use strict';

  angular
    .module('sagdApp', ['ui.router', 'satellizer'])
    .config(['$stateProvider', '$urlRouterProvider', '$authProvider', '$locationProvider', function ($stateProvider, $urlRouterProvider, $authProvider, $locationProvider) {

      var baseUrl = 'http://api.sagd.app/api/v1/';
      // Satellizer configuration that specifies which API
      // route the JWT should be retrieved from
      $authProvider.loginUrl = baseUrl + 'authenticate';
      $authProvider.withCredentials = true;

      $urlRouterProvider.otherwise('/login');

      $stateProvider
        .state('home', {
          url: '/',
          templateUrl: 'app/dashboard/dashboardView.html',
          controller: 'DashboardController as dash'
        })
        .state('login', {
          url: '/login',
          templateUrl: 'app/authentication/loginView.html',
          controller: 'AuthenticateController as auth'
        })
        .state('logout', {
          url: '/logout',
          templateUrl: 'app/logout/logoutView.html',
          controller: 'LogoutController as logout'
        })
        .state('empleado', {
          url: '/empleado',
          templateUrl: 'app/empleado/empleadoView.html',
          controller: 'EmpleadoController as empleado'
        });

      if (window.history && window.history.pushState) {
        $locationProvider.html5Mode(true).hashPrefix('!');
      }
    }])
    .run(['$state', angular.noop]);

})();

// public/scripts/AuthCtrl.js

(function () {

  'use strict';

  angular
    .module('sagdApp')
    .controller('AuthenticateController', AuthenticateController);

  AuthenticateController.$inject = ['$auth', '$state'];

  function AuthenticateController($auth, $state) {

    if($auth.isAuthenticated()){
      $state.go('home', {});
    }

    var self = this;

    self.login = function () {

      var credentials = {
        email: self.email,
        password: self.password
      };

      // Use Satellizer's $auth service to login
      $auth.login(credentials).then(function (data) {

        // If login is successful, redirect to the users state
        $state.go('home', {});
      });
    };

    self.state = $state.$current.name;

  }

})();

// app/dashboard/DashboardCtrl.js

(function (){

  'use strict';

  angular
    .module('sagdApp')
    .controller('DashboardController', DashboardController);

  DashboardController.$inject = ['$auth', '$state'];

  function DashboardController($auth, $state) {

    if(! $auth.isAuthenticated()){
      $state.go('login', {});
    }
  }
})();

// app/empleado/empleadoController.js

(function () {

  'use strict';

  angular
    .module('sagdApp')
    .controller('EmpleadoController', EmpleadoController);

  EmpleadoController.$inject = ['$http', '$auth', '$state'];

  function EmpleadoController($http, $auth, $state) {

    if(! $auth.isAuthenticated()){
      $state.go('login', {});
    }

    var vm = this;

    vm.empleados;
    vm.errores;

    vm.isAuthenticated = function () {
      return $auth.isAuthenticated();
    }

    vm.getEmpleados = function () {

      // This request will hit the index method in the AuthenticateController
      // on the Laravel side and will return the list of users
      $http.get('http://api.sagd.app/api/v1/empleado').success(function (empleados) {
        vm.empleados = empleados;
      }).error(function (error) {
        vm.errores = error;
      });
    }
  }

})();

// app/dashboard/LogoutCtrl.js

(function (){

  'use strict';

  angular
    .module('sagdApp')
    .controller('LogoutController', LogoutController);

  LogoutController.$inject = ['$auth', '$state'];

  function LogoutController($auth, $state) {

    if($auth.isAuthenticated()){
      $auth.removeToken();
    }
    $state.go('login', {});
  }
})();

// app/navbar/Navbar.js

(function () {

  'use strict';

  angular
    .module('sagdApp')
    .controller('NavbarController', NavbarController)
    .directive('navBar', function () {
      return {
        templateUrl: 'app/navbar/navbar.html'
      };
    });

  NavbarController.$inject = ['$auth'];

  function NavbarController($auth) {
    var vm = this;
    vm.modules = [
      {
        nombre: 'Inicio',
        state: 'home',
        active: true
      }, {
        nombre: 'Productos',
        state: 'producto',
        active: false
      }, {
        nombre: 'Clientes',
        state: 'cliente',
        active: false
      }, {
        nombre: 'Facturación',
        state: 'facturacion',
        active: false
      }, {
        nombre: 'Ventas',
        state: 'venta',
        active: false
      }, {
        nombre: 'Gastos',
        state: 'gasto',
        active: false
      }, {
        nombre: 'Garantías',
        state: 'garantia',
        active: false
      }, {
        nombre: 'Paquetes',
        state: 'paquete',
        active: false
      }, {
        nombre: 'Web',
        state: 'web',
        active: false
      }, {
        nombre: 'Sistema',
        state: 'sistema',
        active: false
      }
    ];
    vm.isAuthenticated = function () {
      return $auth.isAuthenticated();
    }
  }

})();
