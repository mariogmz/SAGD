(function (){
  "use strict";

 angular.module('blocks.env', [])

.constant('ENV', {name:'development',applicationFqdn:'http://api.sagd.app',apiNamespace:'/api',version:'/v1'})

; }());