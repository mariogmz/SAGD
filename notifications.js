var Notifications = (function() {

  var Redis = require('ioredis');
  var redis = new Redis();

  var exports = {
    register: registerEvent,
    fetch: getEmployeeNotifications
  };

  return exports;

  function checkIfEventIsNewEmployee(event) {
    return event === "App\\Events\\EmpleadoCreado";
  }

  function createNewList(message) {
    var parsed_message = JSON.parse(message);
    return new Promise(function(resolve, reject) {
      if (checkIfEventIsNewEmployee(parsed_message.event)) {
        var list_name = parsed_message.data.payload.extra.user + '-notifications';
        redis.lpush(list_name, message).then(function(){
          resolve(true);
        });
      } else {
        reject(false);
      }
    });
  }

  function getListLengthOf(list) {
    return redis.llen(list);
  }

  function iterateAndPush(message, lambda) {
    return new Promise(function(resolve, reject) {
      var parsed_message = JSON.parse(message);
      var stream = redis.scanStream({match: '*-notifications'});

      stream.on('data', function (lists) {
        lambda(message, lists, parsed_message);
      });
      stream.on('end', function() {
        resolve(true);
      });
    });
  }

  function updateAllExceptNewEmployee(message) {
    function proc(message, lists, parsed_message) {
      var new_employee_list = parsed_message.data.payload.extra.user + '-notifications';
      var length = lists.length;

      for (var i = 0; i < length; i++) {
        if (lists[i] === new_employee_list) {
          continue;
        }
        redis.lpush(lists[i], message);
      }
    }

    iterateAndPush(message, proc);
  }

  function updateListsWithNewNotification(message) {
    function proc(message, lists) {
      var length = lists.length;
      for (var i = 0; i < length; i++) {
        redis.lpush(lists[i], message);
      }
    }

    iterateAndPush(message, proc);
  }

  function informAllClients(io, channel, message) {
    message = JSON.parse(message);
    console.log("Emitting on (%s) -> %s", channel, message.event);
    io.emit(channel, message);
  }

  function registerEvent(io, channel, message) {
    createNewList(message).then(function() {
      updateAllExceptNewEmployee(message);
    }).catch(function(){
      updateListsWithNewNotification(message);
    });

    informAllClients(io, channel, message);
  }

  function getLatestNotificationsFrom(list) {
    return redis.lrange(list, 0, 8);
  }

  function getEmployeeNotifications(socket, employee) {
    var user = employee.usuario;
    var list = user + '-notifications';
    getLatestNotificationsFrom(list).then(function (data) {
      for (var i=0; i<data.length; i++) {
        var message = JSON.parse(data[i]);
        socket.emit(message.data.payload.channel, message);
      }
    });
  }
})();

module.exports = Notifications;
