module.exports = function() {
    var Dado = Dada = Dados = Dadas = Cuando = Entonces = Y = Pero = this.defineStep;
    var world = require("../support/world.js").World;

    Cuando(/^Visito la pagina principal$/, function (callback) {
      world.visit('http://sagd.app/login', callback);
    });

    Entonces(/^Pongo "([^"]*)" en el campo de "([^"]*)"$/, function (text, type, callback) {
      world.browser.fill('input[type='+type+']', text);
      callback();
    });

    Cuando(/^Presiono el boton "([^"]*)"$/, function (selector, callback) {
      return world.browser.pressButton(selector);
    });

    Entonces(/^Se debe de ver el texto "([^"]*)" en "([^"]*)"$/, function (text, selector, callback) {
      var expected = text;
      var actual = world.browser.text(selector);
      if(expected === actual) {
        callback();
      } else {
        callback.fail(new Error("Expected " + expected));
      }
    });

    Y(/^El elemento "([^"]*)" debe tener clase "([^"]*)"$/, function (selector, clase, callback){
      world.browser.assert.className(selector, clase);
    });

}
