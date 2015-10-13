var app = require('http').createServer(handler);
var io = require('socket.io')(app);
var Redis = require('ioredis');
var subscriber = new Redis();
var redis = new Redis();
var pastMessages = 'saved';

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
  updateClientWithMessages();
});


subscriber.psubscribe('*', function(err, count) {

});

subscriber.on('pmessage', function(subscribed, channel, message) {
    saveMessagetoRedis(message);
    emitMessage(channel, message);
});

function updateClientWithMessages() {
  redis.lrange(pastMessages, 0, 4).then(function(data) {
    var length = data.length -1;
    for (var i = 0; i < length; i++) {
      emitMessage(pastMessages, data[i]);
    };
  });
}

function saveMessagetoRedis(message) {
  redis.lpush(pastMessages, message);
  redis.ltrim(pastMessages, 0, 19);
}

function emitMessage(channel, message) {
  message = JSON.parse(message);
  console.log("Emitting on (%s): %s", channel, message.event);
  io.emit(channel, message);
}
