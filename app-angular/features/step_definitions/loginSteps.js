module.exports = function() {
    var Given = When = Then = And = this.defineStep;
    var world = require("../support/world.js").World;

    Given(/^I visit the login page$/, function(callback){
      world.visit('http://sagd.app/#/login', callback);
    });

    Then(/^I should see the text "([^"]*)" on "([^*]*)"$/, function(text, selector, callback){
        var expected = text;
        var actual = world.browser.text(selector);
        if(expected === actual) {
          callback();
        } else {
          callback.fail(new Error("Expected " + expected));
        }
    });

    Then(/^I should see the button "([^"]*)"$/, function (expected, callback) {
      var actual = world.browser.text('form > button');
      if(expected === actual) {
        callback();
      } else {
        callback.fail(new Error("Expected " + expected));
      }
    });

    Then(/^I put "([^"]*)" on the "([^"]*)" input$/, function (text, type, callback) {
      world.browser.fill('input[type='+type+']', text);
      callback();
    });

    Then(/^I click the "([^"]*)" button$/, function (arg1, callback) {
      return world.browser.pressButton('form > button');
    });
}
