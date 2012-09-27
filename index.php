<?php
// https://github.com/briannesbitt/Slim-ContextSensitiveLoginLogout/blob/master/index.php

require ("libs/autoloader.php");
require ("libs/Slim/Slim.php");
include ("app/funcoes.php");
include ("app/config.php");

$autoloader = new Autoloader();
$app = new Slim();

$app->contentType('text/html; charset=utf-8');
$app->add(new Slim_Middleware_SessionCookie(array('secret' => '98897qwer65465qwe9r79qw9e354as68dh56k6lks6df8g')));

$authenticate = function ($app) {
    return function () use ($app) {
        if (!isset($_SESSION['dehbora']['user']['facebook_id'])) {
            $_SESSION['dehbora']['urlRedirect'] = $app->request()->getPathInfo();
            $app->flash('error', 'Você precisa se logar.');
            $app->redirect('/dehbora/login');
        }
    };
};

$app->hook('slim.before.dispatch', function() use ($app) {
    $user = null;
    if(isset($_SESSION['dehbora']['user']['facebook_id'])) {
        $user = $_SESSION['dehbora']['user'];
    }
    $app->view()->setData('user', $user);
});

require_once("app/routes.php");

$app->run();