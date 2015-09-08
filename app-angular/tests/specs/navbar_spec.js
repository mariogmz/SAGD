var navbarPage, NavbarPage;
NavbarPage = require('./pages/navbar.page');

describe('la barra de navegación', function (){

  beforeEach(function (){
    var width = 1366;
    var height = 768;
    browser.driver.manage().window().setSize(width, height);
    navbarPage = new NavbarPage();
  });

  it('debe mostrar la lista de módulos', function (){
    expect(navbarPage.getModuleList().count()).toBe(11);
  });

  it('debe mostrar el usuario en mayúsculas del empleado logueado en el último módulo', function (){
    expect(navbarPage.getUsername()).toBe('ADMIN');
  });

  it('debe realizar un logout al dar click en el comando "Salir" del menú de usuario', function (){
    navbarPage.performLogout(function (){
      var token = browser.executeScript("return window.localStorage.getItem('satellizer_token');");
      expect(token).toBe(null);
    });
  });

  it('debe mostrar la lista de submódulos cuando pasa el puntero sobre cada módulo', function (){
    navbarPage.mouseOverEachModule(function (submenu){
      expect(submenu.getAttribute('class')).toContain('show');
    });
  });

  it('debe mostrar la lista de acciones cuando pasa el puntero sobre cada submódulo con acciones', function (){
    navbarPage.mouseOverEachSubmoduleWithActions(function (actionMenu){
      expect(actionMenu.getAttribute('class').toContain('show'));
    })
  });

});
