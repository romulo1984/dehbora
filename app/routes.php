<?php
//Rotas da Aplicação
$app->get("/", $authenticate($app), "home");
$app->get("/feeds/:id", $authenticate($app), "feeds");
$app->post("/feeds/add", $authenticate($app), "add_feed");
$app->delete("/feeds/detetar", $authenticate($app), "deletar_feed");
$app->get("/login", "login");
$app->post("/entrar", "entrar");
$app->get("/logout", "logout");
$app->get("/perfil", $authenticate($app), "perfil");
$app->get("/noticias", $authenticate($app), "noticias");

//function home() {
//    $app = Slim::getInstance();
//    $app->render('home.php');
//}

function home() {
    $app = Slim::getInstance();
    $feeds = new Crud();
    $feeds->setTabela('feeds');
    
    $user = $app->view()->getData('user');
    
    $l = $feeds->consultar(
                array('id', 'nome', 'url', 'publico', 'id_categoria'),
                'id_user ='.$user['id'],
                'created DESC'
                )->fetchAll(PDO::FETCH_ASSOC);
    
    $url_feed_inicial = $l[0]['url'];
    
    $read = new SimplePie();
    $read->enable_cache(true);
    $read->set_feed_url($url_feed_inicial);

    //$read->enable_cache(false);
    $read->init();
    $app->render('home.php', array('rss' => $read->get_items()));
}
function feeds($id) {
    $app = Slim::getInstance();
    
    $app->view()->setData('id_feed_atual', $id);
    
    if(!is_numeric($id)){
        $errors = "A página não existe";
        $app->flash('errors', $errors);
        $app->redirect(URL_BASE.'/');
        exit;
    }
    
    $feeds = new Crud();
    $feeds->setTabela('feeds');
    
    $user = $app->view()->getData('user');
    
    $l = $feeds->consultar(
            array('nome', 'url', 'publico', 'id_categoria'),
            'id_user ='.$user['id'].' AND id ='.$id
         )->fetchAll(PDO::FETCH_ASSOC);

    if(count($l) > 0){
        $read = new SimplePie();
        $read->enable_cache(true);
        $read->set_feed_url($l[0]['url']);

        $read->init();
        $app->render('home.php', array('rss' => $read->get_items(), 'nome' => $l[0]['nome']));
    } else {
        echo "Esta página não existe";
    }
}

function add_feed(){
    $app = Slim::getInstance();
    
    $count_erro = 0;
    
    if(!$_POST['nome']){
        $count_erro += 1;
    } elseif(!$_POST['url']){
        $count_erro += 1;
    }
    
    if($count_erro > 0){
        $app->flash('errors', 'Os campos <strong>NOME</strong> e <strong>URL</strong> são obrigatórios!');
        $app->redirect(URL_BASE.'/');
        exit;
    }
    
    $nome = $_POST['nome'];
    $url = $_POST['url'];
    $user = $app->view()->getData('user');
    
    if(isset($_POST['publico'])){
        $publico = 1;
    }else {
        $publico = 0;
    }
    
    $add_feed = new Crud();
    $add_feed->setTabela('feeds');
    
    $a_f = $add_feed->inserir(
                array(
                    "nome" => $nome,
                    "url" => $url,
                    "publico" => $publico,
                    "id_user" => $user['id']
                )
            );
    
    if($a_f){
        $app->flash('sucesso', 'Feed Adicionado com Sucesso');
        $app->redirect(URL_BASE.'/');
    }else {
        $app->flash('errors', 'O Feed não pode ser adicionado');
        $app->redirect(URL_BASE.'/');
    }
}

function deletar_feed(){
    
}

function login() {
    $app = Slim::getInstance();
    
    if(isset($_SESSION['dehbora']['user'])){
        $app->redirect(URL_BASE);
    }else{
        $app->render('login.php');
    }
}
function entrar() {
    $app = Slim::getInstance();
    $login = new Login();

    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $ok = $login->valida($email, $senha);
    
    $errors = null;
    if($ok == false){
        $errors = "Dados inválidos";
    }
    
    if (count($errors) > 0) {
        $app->flash('errors', $errors);
        $app->redirect(URL_BASE.'/login');
        exit;
    }
    
    $login->gravaSessao();
    
    if (isset($_SESSION['dehbora']['urlRedirect'])) {
       $tmp = $_SESSION['dehbora']['urlRedirect'];
       unset($_SESSION['dehbora']['urlRedirect']);
       $app->redirect(URL_BASE.$tmp);
    }

    $app->redirect(URL_BASE);
}

function logout() {
    $app = Slim::getInstance();
    $l = new Login();
    $l->logout();
    $app->view()->setData('user', null);
    $app->redirect(URL_BASE.'/login');
}

function perfil() {
    $app = Slim::getInstance();
    echo "<h2>Esta é a página do Perfil</h2>";
    $user = $app->view()->getData('user');
    var_dump($user);
}