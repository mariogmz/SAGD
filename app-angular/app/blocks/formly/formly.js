// app/blocks/formly/formly.js

(function (){
    'use strict';

    angular
      .module('blocks.formly')
      .decorator('formlyConfig', FormlyConfigDecorator);

    FormlyConfigDecorator.$inject = ['$delegate'];

    function FormlyConfigDecorator($delegate){

      var formlyConfigWrapper = $delegate;

      return wrap();

      function wrap(){

        /**
         * Common wrappers
         */
        formlyConfigWrapper.setWrapper([{
          name: 'label',
          templateUrl: 'app/templates/wrappers/label.html'
        }]);

        var commonWrappers = ['label'];

        angular.forEach(['radio', 'select'], function (fieldName){
          formlyConfigWrapper.setType({
            name: fieldName,
            templateUrl: 'app/templates/fields/' + fieldName,
            wrapper: commonWrappers
          });
        });

        formlyConfigWrapper.setType({
          name: 'input',
          templateUrl: 'app/templates/fields/input.html',
          wrapper: commonWrappers
        });

        formlyConfigWrapper.setType({
          name: 'checkbox',
          templateUrl: 'app/templates/fields/checkbox.html'
        });

        formlyConfigWrapper.templateManipulators.preWrapper.push(function ariaDescribedBy(template, options, scope){
          if (options.templateOptions && angular.isDefined(options.templateOptions.description) &&
            options.type !== 'radio' && options.type !== 'checkbox') {
            var el = angular.element('<a></a>');
            el.append(template);
            var modelEls = angular.element(el[0].querySelectorAll('[ng-model]'));
            if (modelEls) {
              el.append(
                '<p id="' + scope.id + '_description"' +
                'class="help-block"' +
                'ng-if="options.templateOptions.description">' +
                '{{options.templateOptions.description}}' +
                '</p>'
              );
              modelEls.attr('aria-describedby', scope.id + '_description');
              return el.html();
            } else {
              return template;
            }
          } else {
            return template;
          }
        });

        return formlyConfigWrapper;
      }

    }
  }()
)
;
