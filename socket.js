var app = require('http').createServer(handler);
var io = require('socket.io')(app);
var Redis = require('ioredis');
var redis = new Redis();

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

});


redis.psubscribe('*', function(err, count) {

});

redis.on('pmessage', function(subscribed, channel, message) {
    message = JSON.parse(message);
    console.log(subscribed);
    console.log("Emitting on ("+channel+"): "+ message.event + "\n -> " + JSON.stringify(message.data));
    io.emit(channel + ':' + message.event, message.data);
});
