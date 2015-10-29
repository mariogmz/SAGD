(function (){
  "use strict";

 angular.module('blocks.env', [])

.constant('ENV', {name:'development',applicationFqdn:'http://api.sagd.app',apiNamespace:'/api',version:'/v1',cache_time:1,cache_whitelist:['codigo_postal','domicilio','familia','garantia','marca','margen','proveedor','subfamilia','sucursal?proveedor_clave=DICO','unidad'],socketEndpoint:'ws://socket.sagd.app'})

; }());