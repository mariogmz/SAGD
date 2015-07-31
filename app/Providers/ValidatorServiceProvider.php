<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Validator;

class ValidatorServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        /*
         * greater_than:field
         */
        Validator::extend('greater_than', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            return $value > $data[$parameters[0]];
        });
        Validator::replacer('greater_than', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
        });

        /*
         *
         */
        Validator::extend('less_than', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            return $value < $data[$parameters[0]];
        });
        Validator::replacer('less_than', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
