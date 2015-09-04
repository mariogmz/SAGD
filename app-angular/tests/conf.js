var Jasmine2HtmlReporter = require('protractor-jasmine2-html-reporter');

exports.config = {
  framework: 'jasmine2',
  seleniumAddress: 'http://localhost:4444/wd/hub',
  specs: ['specs/*_spec.js'],
  capabilities: {
    'browserName': 'chrome'
  },
  onPrepare: function() {
    jasmine.getEnv().addReporter(new Jasmine2HtmlReporter({
      savePath: './tests/reports/',
      takeScreenshots: true,
      takeScreenshotsOnlyOnFailures: false
    }));
  }
};
