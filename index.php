<?php
// https://github.com/briannesbitt/Slim-ContextSensitiveLoginLogout/blob/master/index.php

require ("libs/autoloader.php"); //Autoload para as classes próprias
require ("libs/Simplepie/autoloader.php"); //Autoload para as Classes do SimplePie, para leitura de RSS
require ("libs/Slim/Slim.php"); //Micro-framework Slim, para gerenciamento de rotas e alguns Helpers
include ("app/funcoes.php"); //Funções próprias, como CSS, Javascript e Meta
include ("app/config.php"); //Configurações gerais do sistema, através de Constantes.

$autoloader = new Autoloader();
$app = new Slim();

$app->contentType('text/html; charset=utf-8');
$app->add(new Slim_Middleware_SessionCookie(
        array(
            'secret' => '98897qwer65465qwe9r79qw9e354as68dh56k6lks6df8g',
            'expires' => '60 minutes'
            )
        ));

$authenticate = function ($app) {
    return function () use ($app) {
        if (!isset($_SESSION['dehbora']['user'])) {
            $_SESSION['dehbora']['urlRedirect'] = $app->request()->getPathInfo();
            $app->flash('error', 'Você precisa se logar.');
            $app->redirect(URL_BASE.'/login');
        }
    };
};

$app->hook('slim.before.dispatch', function() use ($app) {
    $user = null;
    if(isset($_SESSION['dehbora']['user'])) {
        $user = $_SESSION['dehbora']['user'];
    }
    $app->view()->setData('user', $user);
});

require_once("app/routes.php");

$app->run();