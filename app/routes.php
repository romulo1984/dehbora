<?php
//Rotas da Aplicação
$app->get("/", "home");
$app->get("/teste", "teste");

//Funções de Rotas da Aplicação
function home() {
    $app = Slim::getInstance();
    $app->render("home.php");
}
function teste() {
    echo "Oi doidão";
}