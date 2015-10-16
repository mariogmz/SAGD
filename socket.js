var app = require('http').createServer(handler);
var io = require('socket.io')(app);
var Redis = require('ioredis');
var subscriber = new Redis();
var notifications = require('./notifications.js');

app.listen(3000, function(){
    console.log('Listening on Port 3000');
});

function handler(req, res) {
  console.log('Connection');
  res.writeHead(200);
  res.write('');
  res.end();
}

io.on('connection', function(socket){
  var visitor = socket.client.conn.remoteAddress;
  var origin = socket.handshake.headers.origin;
  console.log("New client: %s from %s", visitor, origin);

  socket.on('fetch', function(employee){
    notifications.fetch(socket, employee);
  });

  socket.on('delete', function(payload) {
    notifications.delete(socket, payload);
  });
});


subscriber.psubscribe('*', function(err, count) {

});

subscriber.on('pmessage', function(subscribed, channel, message) {
  notifications.register(io, channel, message);
});

