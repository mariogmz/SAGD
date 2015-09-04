describe('sagdapp login page', function(){


    beforeEach(function(){
      var width = 1366;
      var height = 768;
      browser.driver.manage().window().setSize(width, height);
      browser.get('http://sagd.app');
    });

    it('should have the correct title', function(){

      expect(browser.getTitle()).toEqual('Sistema Administrativo de Grupo Dicotech');
    });

    it('should redirect to login', function(){

      expect(browser.getCurrentUrl()).toEqual('http://sagd.app/login');
    });

    it("should redirect when the correct credentials are entered", function() {

      $('input[type="email"]').sendKeys('sistemas@zegucom.com.mx');
      $('input[type="password"]').sendKeys('test123');
      $('#acceder').click();

      expect(browser.getCurrentUrl()).toEqual('http://sagd.app/');
      expect($('a.empleado-style.nav').getText()).toMatch(/admin/i);
    });
});
