var loginPage, LoginPage;

LoginPage = require('./pages/login.page');

describe('las ruta', function () {

  beforeEach(function () {
    var width = 1366;
    var height = 768;
    browser.driver.manage().window().setSize(width, height);
    loginPage = new LoginPage();
    loginPage.get();
    browser.executeScript("window.localStorage.clear();");
  });

  it('se debe de ver el titulo correcto', function () {
    expect(loginPage.getTitle()).toBe("Sistema Administrativo de Grupo Dicotech");
  });

  describe('con las credenciales incorrectas', function () {

    beforeEach(function () {
      loginPage.setEmail('bdd@tester.com');
      loginPage.setPassword('password');
      loginPage.submit();
    });

    it('debe redirigir a login cuando se ingresa una url inválida', function () {
      browser.get('http://sagd.app/invalid');
      expect(loginPage.getUrl()).toBe('http://sagd.app/login');
    });

    it('debe redirigir a login cuando se ingresa una url válida', function () {
      browser.get('http://sagd.app/empleado');
      expect(loginPage.getUrl()).toBe('http://sagd.app/login');
    });
  });

  describe('con las credenciales correctas', function () {

    beforeEach(function () {
      loginPage.setEmail('sistemas@zegucom.com.mx');
      loginPage.setPassword('test123');
      loginPage.submit();
    });

    it('debe redirigir a home cuando se ingresa una url inválida', function () {
      browser.get('/invalid');
      expect(loginPage.getUrl()).toBe('http://sagd.app/');
    });

    it('debe mantener la url cuando se ingresa una url válida', function () {
      browser.get('/empleado');
      expect(loginPage.getUrl()).toBe('http://sagd.app/empleado');
    });
  });
});
