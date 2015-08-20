module.exports = function() {
    var Given = When = Then = And = this.defineStep;
    this.World = require("../support/world.js").World;

    Given(/^I visit the login page$/, function(callback){
        this.visit('http://sagd.app/#/login', callback);
    });

    Then(/^I should see the text "(.*)"$/, function(text, callback){
        var page = this.browser.text;
        if(page === text){
            callback();
        } else {
            callback.fail(new Error("Expected to find " + text));
        }
    });
}
