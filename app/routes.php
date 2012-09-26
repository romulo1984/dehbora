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
    $facebook = new Facebook(array(
        'appId'  => '419563918092035',
        'secret' => 'a03a80f9985a5d7bc9c38e2817f64aea',
    ));
    $fb = $facebook->getUser();
    if ($fb) {
        $logoutUrl = $facebook->getLogoutUrl();
    } else {
        $loginUrl = $facebook->getLoginUrl();
    }
    
    $app->redirect($loginUrl);
    
    if ($fb) {
        $user_fb = $facebook->api('/me');
        $l = new Login();
        $l->logar($user_fb['id'], $user_fb['name'], $user_fb['email'], 'https://graph.facebook.com/'.$user_fb["id"].'/picture');
    }else {
        $fb = null;
        $errors['erro'] = "Não foi possível conectar";
    }

    $errors = null;
    
    if($l->logado == false){
        $errors['email'] = "Não foi possível conectar";
    }
    
    if (count($errors) > 0) {
        $app->flash('errors', $errors);
        $app->redirect('/dehbora/login');
    }
    
    $_SESSION['dehbora']['user'] = $e->user;
    
    if (isset($_SESSION['dehbora']['urlRedirect'])) {
       $tmp = $_SESSION['dehbora']['urlRedirect'];
       unset($_SESSION['dehbora']['urlRedirect']);
       $app->redirect('/dehbora'.$tmp);
    }

    $app->redirect('/dehbora');
}

function logout() {
    $app = Slim::getInstance();
    $app->redirect($loginUrl);
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