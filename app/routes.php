<?php
//Rotas da Aplicação
$app->get("/", $authenticate($app), "home");
$app->get("/login", "login");
$app->get("/entrar", "entrar");
$app->get("/logout", "logout");
$app->get("/perfil", $authenticate($app), "perfil");
$app->get("/noticias", $authenticate($app), "noticias");

function home() {
    $app = Slim::getInstance();
    $app->render('inicial.php');
}
function login() {
    $app = Slim::getInstance();
    //$flash = $app->flash['erros'];
    $app->render('login.php');
}
function entrar() {
    $app = Slim::getInstance();
    $email = 'romulo@gmail.com';
    $errors = null;
    
    if($email != 'romulo@gmail.com'){
        $errors['email'] = "Dados inv�lidos";
    }
    
    if (count($errors) > 0) {
        $app->flash('errors', $errors);
        $app->redirect('/dehbora/login');
    }
    
    $_SESSION['dehbora']['user'] = $email;
    
    if (isset($_SESSION['dehbora']['urlRedirect'])) {
       $tmp = $_SESSION['dehbora']['urlRedirect'];
       unset($_SESSION['dehbora']['urlRedirect']);
       $app->redirect('/dehbora'.$tmp);
    }

    $app->redirect('/dehbora');
}

function logout() {
    $app = Slim::getInstance();
    unset($_SESSION['dehbora']['user']);
    $app->view()->setData('user', null);
    $app->redirect('/dehbora/login');
}

function perfil() {
    $app = Slim::getInstance();
    echo "<h2>Esta é a página do Perfil</h2>";
}
function noticias() {
    $app = Slim::getInstance();
    echo "<h2>Esta é a página com notícias</h2>";
}