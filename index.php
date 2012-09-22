<?php
require ("app/autoloader.php");
require ("libs/Slim/Slim.php");
include ("app/funcoes.php");
include ("app/config.php");

$autoloader = new Autoloader();
$app = new Slim();

$app->contentType('text/html; charset=utf-8');

require_once("app/routes.php");

$app->run();