// app/blocks/session/session.module.js

(function() {
    'use strict';

    angular.module('blocks.session', []);
})();
// app/core/core.module.js

(function() {
    'use strict';

    angular.module('sagdApp.core', [
        /*
         * Angular modules
         */
        'ngAnimate',

        /*
         * Our reusable cross app code modules
         */
        'blocks.session',

        /*
         * 3rd party app modules
         */
        'ui.router',
        'satellizer'
    ]);
})();

// app/dashboard/dashboard.module.js

(function() {
    'use strict';

    angular.module('sagdApp.dashboard', [
      'sagdApp.core',
      'satellizer'
    ]);
})();

// app/empleado/empleado.module.js

(function() {
    'use strict';

    angular.module('sagdApp.empleado', [
      'sagdApp.core'
    ]);
})();

// app/navbar/navbar.module.js

(function() {
    'use strict';

    angular.module('sagdApp.navbar', [
      'sagdApp.core'
    ]);
})();

// app/session/session.module.js

(function() {
    'use strict';

    angular.module('sagdApp.session', [
      'sagdApp.core'
    ]);
})();

// app.js

(function () {

  'use strict';

  angular
    .module('sagdApp', [
      'sagdApp.core',

      'sagdApp.dashboard',
      'sagdApp.session',
      'sagdApp.empleado',
      'sagdApp.navbar'
  ]);
})();

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

// app/core/config.js

(function() {
    'use strict';

    var core = angular.module('sagdApp.core');

    core.config(configure);

    configure.$inject = ['$stateProvider', '$urlRouterProvider', '$authProvider', '$locationProvider'];

    function configure ($stateProvider, $urlRouterProvider, $authProvider, $locationProvider) {
      var baseUrl = 'http://api.sagd.app/api/v1';
      $authProvider.loginUrl = baseUrl + '/authenticate';
      $authProvider.withCredentials = true;

      $urlRouterProvider.otherwise('/login');

      if (window.history && window.history.pushState) {
        $locationProvider.html5Mode(true).hashPrefix('!');
      }
    }

    core.run(['$state', angular.noop]);
})();

// app/dashboard/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.dashboard')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
      $stateProvider
          .state('home', {
              url: '/',
              templateUrl: 'app/dashboard/dashboard.html',
              controller: 'DashboardController',
              controllerAs: 'vm'
          });
    }
})();

// app/dashboard/dashboard.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.dashboard')
    .controller('DashboardController', DashboardController);

  DashboardController.$inject = ['$auth', '$state'];

  function DashboardController($auth, $state) {
    if(! $auth.isAuthenticated()){
      $state.go('login', {});
    }
  }
})();

// app/empleado/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.empleado')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('empleado', {
                url: '/empleado',
                templateUrl: 'app/empleado/empleado.html',
                controller: 'EmpleadoController',
                controllerAs: 'vm'
            });
    }
})();

// app/empleado/empleado.controller.js

(function () {

  'use strict';

  angular
    .module('sagdApp.empleado')
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

// app/navbar/navbar.controller.js

(function () {

  'use strict';

  angular
    .module('sagdApp.navbar')
    .directive('logout', function () {
      return {
        templateUrl: 'app/session/logout.html'
      };
    });
})();

// app/navbar/navbar.animations.js

(function () {

  'use strict';

  angular
    .module('sagdApp.navbar')
    .animation('.module-navbar', NavbarAnimation);

  NavbarAnimation.$inject = [];

  function NavbarAnimation() {

    var showSubmenu = function(element, className, done) {
        var menu = $(element).children('.menu');
        $(menu).addClass('active');
    }

    var hideSubmenu = function(element, className, done) {
        var menu = $(element).children('.menu');
        $(menu).removeClass('active');
    }

    return {
      addClass: showSubmenu,
      removeClass: hideSubmenu
    };
  }

})();

// app/navbar/navbar.controller.js

(function () {

  'use strict';

  angular
    .module('sagdApp.navbar')
    .controller('NavbarController', NavbarController)
    .directive('navBar', function () {
      return {
        templateUrl: 'app/navbar/navbar.html'
      };
    });

  NavbarController.$inject = ['$auth', 'session'];

  function NavbarController($auth, session) {
    var vm = this;
    vm.modules = [
      {
        nombre: 'Inicio',
        state: 'home',
        active: true,
        submodules: [
          {
            nombre: 'Inicio',
            state: 'home'
          }
        ]
      }, {
        nombre: 'Productos',
        state: 'producto',
        active: false,
        submodules: [
          {
            nombre: 'Cátalogo',
            state: 'producto/catalogo',
          },{
            nombre: 'Marcas',
            state: 'producto/marca',
          },{
            nombre: 'Familias',
            state: 'producto/familia',
          },{
            nombre: 'Subfamilias',
            state: 'producto/subfamilias',
          }
        ]
      }, {
        nombre: 'Inventario',
        state: 'inventario',
        active: false,
        submodules: [
          {
            nombre: 'Transferencias',
            state: 'producto/transferencia',
          },{
            nombre: 'Un nombre muy muy largo',
            state: 'producto/test',
          }
        ]
      }, {
        nombre: 'Ventas',
        state: 'venta',
        active: false,
        submodules: [
          {
            nombre: 'Ventas',
            state: 'venta',
          },{
            nombre: 'Consultar',
            state: 'venta/consulta',
          },{
            nombre: 'Cotizaciones',
            state: 'venta/cotizacion',
          },{
            nombre: 'Utilidad',
            state: 'venta/utilidad',
          }
        ]
      }, {
        nombre: 'Clientes',
        state: 'cliente',
        active: false,
        submodules: [
          {
            nombre: 'Listar',
            state: 'cliente',
          }
        ]
      }, {
        nombre: 'Proveedores',
        state: 'proveedor',
        active: false,
        submodules: [
          {
            nombre: 'Listar',
            state: 'proveedor',
          }
        ]
      }, {
        nombre: 'Soporte',
        state: 'soporte',
        active: false,
        submodules: [
          {
            nombre: 'Listar',
            state: 'soporte',
          }
        ]
      }, {
        nombre: 'Empleados',
        state: 'empleado',
        active: false,
        submodules: [
          {
            nombre: 'Listar',
            state: 'empleado',
          }
        ]
      }, {
        nombre: 'Cajas y Cortes',
        state: 'caja_corte',
        active: false,
        submodules: [
          {
            nombre: 'Listar cajas',
            state: 'caja_corte/caja'
          },{
            nombre: 'Corte de Caja',
            state: 'caja_corte',
          }
        ]
      }, {
        nombre: 'Paqueterías',
        state: 'paqueteria',
        active: false,
        submodules: [
          {
            nombre: 'Listar',
            state: 'paqueteria'
          }
        ]
      } , {
        nombre: 'Facturación',
        state: 'facturacion',
        active: false,
        submodules: [
          {
            nombre: 'Consultar',
            state: 'facturacion'
          },{
            nombre: 'Reportes',
            state: 'facturacion/reporte'
          },{
            nombre: 'Efectivo',
            state: 'facturacion/efectivo'
          },{
            nombre: 'Administrar folios',
            state: 'facturacion/folio'
          },{
            nombre: 'VM',
            state: 'facturacion/VM'
          },
        ]
      } , {
        nombre: 'Configuración',
        state: 'configuracion',
        active: false,
        submodules: [
          {
            nombre: 'Sucursales',
            state: 'configuracion/sucursal'
          },{
            nombre: 'Logs',
            state: 'configuracion/logs'
          },{
            nombre: 'PM',
            state: 'configuracion/pm'
          },{
            nombre: 'Tipo de Cambio',
            state: 'configuracion/tipocambio'
          }
        ]
      }
    ];

    vm.isAuthenticated = session.isAuthenticated;
    vm.logout = session.logout;
    vm.empleado = JSON.parse(localStorage.empleado || "{}");
  }

})();

// app/session/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.session')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('login', {
                url: '/login',
                templateUrl: 'app/session/login.html',
                controller: 'SessionController',
                controllerAs: 'vm'
            })
            .state('logout', {
                url: '/logout',
                templateUrl: 'app/session/logout.html',
                controller: 'SessionController',
                controllerAs: 'vm'
            });
    }
})();

// app/session/session.controller.js

(function () {

  'use strict';

  angular
    .module('sagdApp.session')
    .controller('SessionController', SessionController);

  SessionController.$inject = ['session'];

  function SessionController(session) {
    var vm = this;

    vm.login = function () {
      session.login(vm.email, vm.password);
    };

    vm.logout = function () {
      session.logout();
    }
  }

})();
