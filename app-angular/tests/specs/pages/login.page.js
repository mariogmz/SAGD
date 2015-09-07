var LoginPage = function() {
  var emailInput = element(by.model('vm.email'));
  var passwordInput = element(by.model('vm.password'));
  var submitButton = element(by.css('#acceder'));
  var loginError = element(by.css('form'));


  this.get = function() {
    browser.get('/login');
  }

  this.setEmail = function(email) {
    emailInput.sendKeys(email);
  }

  this.setPassword = function(password) {
    passwordInput.sendKeys(password);
  }

  this.getLoginError = function() {
    return loginError.getAttribute('class');
  }

  this.getTitle = function() {
    return browser.getTitle();
  }

  this.submit = function() {
    submitButton.click();
  }

  this.getUrl = function() {
    return browser.getCurrentUrl();
  }
}

module.exports = LoginPage;
