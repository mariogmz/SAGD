var NavbarPage = function (){
  var LoginPage = require('./login.page');
  var loginPage = new LoginPage();
  loginPage.login();

  var toggler = $('.hamburguer');
  var brand = $('.brand');
  var modulesList = element.all(by.exactBinding('module.name'));
  var submodulesList = element.all(by.exactBinding('submmodule.name'));
  var actionsList = element.all(by.exactBinding('action.name'));

  this.mouseOverEachModule = function (callback){
    element.all(by.css('.module-list-item:not(.empleado)')).each(function (module, index){
      if (index > 0) { // Inicio
        browser.actions().mouseMove(module).perform().then(function(){
          var submenu = module.element(by.css('.submodule-menu'));
          callback(submenu);
        });
      }
    });
  };

  this.getModuleList = function (){
    return modulesList;
  };

  this.toggleMenu = function (){
    toggler.click();
    return this;
  };

  this.performAction = function (moduleName, submoduleName, actionName){
    var module;
    var submodule;
    var action;

    // Module
    element.all(by.binding('module.name')).then(function (modules){
      modules.forEach(function (currentModule){
        if (currentModule.getInnerHtml() === moduleName) {
          module = currentModule;
        }
      });
    });

    // Submodule
    element.all(by.binding('submodule.name')).then(function (submodules){
      submodules.forEach(function (currentSubmodule){
        if (currentSubmodule.getInnerHtml() === submoduleName) {
          submodule = currentSubmodule;
        }
      });
    });

    // Action
    element.all(by.binding('action.name')).then(function (actions){
      actions.forEach(function (currentAction){
        if (currentAction.getInnerHtml() === actionName) {
          action = currentAction;
        }
      });
    });

    // Build action
    var actionSecuence = new protractor.ActionSecuence(browser.driver);
    // Module
    if (module) {
      actionSecuence = actionSecuence.mouseMove(module);
    }
    if (submodule) {
      actionSecuence = actionSecuence.mouseMove(submodule);
    }
    if (action) {
      // First, move to the top item on actions list
      action.element(by.xpath('..')).element.all(by.tagName('a')).first().then(function (element){
        actionSecuence = actionSecuence.mouseMove(element);
        actionSecuence = actionSecuence.mouseMove(action);
      });
    }
    // Perform
    actionSecuence.perform();
  };

};

module.exports = NavbarPage;
