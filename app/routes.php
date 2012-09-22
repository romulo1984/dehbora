<?php
//Rotas da Aplicação
$app->get("/", "home");
$app->get("/portfolio", "listar");
$app->get("/configuracoes", "config");
$app->get("/usuarios", "user");
$app->get("/login", "login");
$app->put("/portfolio/:id", "update");
$app->post("/portfolio/add", "add_port");
$app->delete("/portfolio/:id", "delete_port");

$app->post("/configuracoes/add", "add_config");

$app->post("/login/entrar", "entrar");
$app->post("/logout", "logout");

//Rotas da API
$app->get("/api/portfolio", "consultaPortfolio");
$app->get("/api/portfolio/:id", "consultaPortfolioId");


//Funções de Rotas da Aplicação
function home() {
    $app = Slim::getInstance();
    $app->render("home.php");
}


?>
