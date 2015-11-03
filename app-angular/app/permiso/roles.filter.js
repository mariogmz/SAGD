// app/permiso/roles/roles.filter.js

(function (){
  'use strict';

  angular
    .module('sagdApp.permiso')
    .filter('normalizeControllerName', normalizeControllerName);

  normalizeControllerName.$inject = ['$filter'];

  function normalizeControllerName($filter){
    return function (input){
      var normalized = input.match(/([A-Z]\w+)([A-Z]\w+)(?=Controller)/) || input.match(/\w+(?=Controller)/)[0];
      if (typeof normalized === "object") {
        return [normalized[1], normalized[2]].join(' ');
      } else {
        return normalized;
      }
    };
  };
}());
