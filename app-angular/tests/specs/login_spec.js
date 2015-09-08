var loginPage, LoginPage;

LoginPage = require('./pages/login.page');

describe('la pagina de login', function () {

  beforeEach(function () {
    var width = 1366;
    var height = 768;
    browser.driver.manage().window().setSize(width, height);
    loginPage = new LoginPage();
    loginPage.get();
  });

  it('se debe de ver el titulo correcto', function () {
    expect(loginPage.getTitle()).toBe("Sistema Administrativo de Grupo Dicotech");
  });

  describe('con las credenciales incorrectas', function () {

    beforeEach(function () {
      browser.executeScript("window.localStorage.clear();");
      loginPage.setEmail('bdd@tester.com');
      loginPage.setPassword('password');
      loginPage.submit();
    });

    it('debe de mostrar un error', function () {
      loginPage.getLoginError().then(function (classes) {
        expect(classes).toContain('error');
      });
    });

    it('no debe de guardar ningun token', function () {
      var token = browser.executeScript("return window.localStorage.getItem('satellizer_token');");
      expect(token).toBe(null);
    });
  });

  describe('con las credenciales correctas', function () {

    beforeEach(function () {
      loginPage.login()
    });

    it('debe de redirigir al dashboard si las credenciales son correctas', function () {
      expect(loginPage.getUrl()).toBe('http://sagd.app/');
    });

    it('debe de guardar el token de autenticacion en el local storage', function () {
      var token = browser.executeScript("return window.localStorage.getItem('satellizer_token');");
      expect(token).not.toBe(null);
    });

    it('debe de guardar el empleado en el local storage', function () {
      var token = browser.executeScript("return window.localStorage.getItem('empleado');");
      expect(token).not.toBe(null);
    });
  });
});
