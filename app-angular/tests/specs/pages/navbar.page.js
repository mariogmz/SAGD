var NavbarPage = function () {
  "use strict";
  var toggler = $('.hamburguer');
  var brand = $('.brand');

  this.toggleMenu = function () {
    toggler.click();
  };

  this.performAction = function (moduleName, submoduleName, actionName) {
    var module;
    var submodule;
    var action;

    // Module
    element.all(by.binding('module.name')).then(function (modules) {
      modules.forEach(function (currentModule) {
        if (currentModule.getInnerHtml() === moduleName) {
          module = currentModule;
        }
      });
    });

    // Submodule
    element.all(by.binding('submodule.name')).then(function (submodules) {
      submodules.forEach(function (currentSubmodule) {
        if (currentSubmodule.getInnerHtml() === submoduleName) {
          submodule = currentSubmodule;
        }
      });
    });

    // Action
    element.all(by.binding('action.name')).then(function (actions) {
      actions.forEach(function (currentAction) {
        if (currentAction.getInnerHtml() === actionName) {
          action = currentAction;
        }
      });
    });

    // Build action
    var actionSecuence = new protractor.ActionSecuence(browser.driver);
    // Module
    if(module){actionSecuence = actionSecuence.mouseMove(module);}
    if(submodule){actionSecuence = actionSecuence.mouseMove(submodule);}
    if(action){
      // First, move to the top item on actions list
      action.element(by.xpath('..')).element.all(by.tagName('a')).first().then(function(element){
        actionSecuence = actionSecuence.mouseMove(element);
        actionSecuence = actionSecuence.mouseMove(action);
      });
    }
    // Perform
    actionSecuence.perform();
  };



};
