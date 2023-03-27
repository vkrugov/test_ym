<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Laravel\Lumen\Routing\Router;

$router->group([
    'prefix' => 'user'
], function (Router $router) {
    $router->post('register', 'Auth\AuthController@register');
    $router->post('sign-in', 'Auth\AuthController@signIn');
    $router->post('recover-password', 'Auth\RecoverPasswordController@index');
    $router->options('reset-password/{token}', ['as' => 'password.reset']);
    $router->post('reset-password', 'Auth\ResetPasswordController@index');
    $router->group([
        'middleware' => 'auth:api'
    ], function (Router $router) {
        $router->get('self', 'Auth\AuthController@self');
        $router->post('logout', 'Auth\AuthController@logout');
        $router->get('companies', 'UserCompanyController@index');
        $router->post('companies', 'UserCompanyController@store');
    });
});
