// app/blocks/state/state.module.js

(function () {
  'use strict';

  angular
    .module('blocks.state')
    .factory('state', state);

  state.$inject = [];

  function state() {
    var fromState;
    var toState;

    var setNewState = function (from, to) {
      fromState = from;
      toState = to;
    };

    var getPreviousState = function () {
      return fromState || "home";
    };

    var getCurrentState = function () {
      return toState;
    };

    return {
      setNewState: setNewState,
      current_state: getCurrentState,
      previous_state: getPreviousState
    };
  }
}());
