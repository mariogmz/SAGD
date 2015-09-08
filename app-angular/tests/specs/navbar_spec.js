var navbarPage, NavbarPage;
NavbarPage = require('./pages/navbar.page');

describe('la barra de navegación', function () {

  beforeEach(function () {
    var width = 1366;
    var height = 768;
    browser.driver.manage().window().setSize(width, height);
    navbarPage = new NavbarPage();
  });

  it('debe mostrar la lista de módulos', function () {
    expect(navbarPage.getModuleList().count()).toBe(11);
  });

});
