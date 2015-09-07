var Jasmine2HtmlReporter = require('protractor-jasmine2-html-reporter');

exports.config = {
  framework: 'jasmine2',
  seleniumAddress: 'http://localhost:4444/wd/hub',
  baseUrl: "http://sagd.app",
  specs: ['specs/*_spec.js'],
  capabilities: {
    'browserName': 'chrome'
  },
  getPageTimeout : 20000,
  suites : {
    fuck : 'specs/routes_spec.js'
  },
  onPrepare: function() {
    jasmine.getEnv().addReporter(new Jasmine2HtmlReporter({
      savePath: './tests/reports/'
    }));
  }
};
