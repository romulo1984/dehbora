<?php
//Rotas da Aplicação
$app->get("/", $authenticate($app), "home");
$app->get("/feeds/:id", $authenticate($app), "feeds");
$app->post("/feeds/add", $authenticate($app), "add_feed");
$app->delete("/feeds/detetar", $authenticate($app), "deletar_feed");
$app->get("/inicial", "inicial");
$app->post("/login", "login");
$app->get("/logout", "logout");
$app->get("/perfil", $authenticate($app), "perfil");
$app->post("/noticia/:titulo", $authenticate($app), "noticia");
$app->post("/noticia/avaliar/", $authenticate($app), "avaliar");
$app->get("/recomendacoes", $authenticate($app), "recomendacoes");

$app->post("/newuser", "newuser");

function recomendacoes(){
    $app = Slim::getInstance();
    $user = $app->view()->getData('user');
    $id_user = $user['id'];
    
    $a = new Crud();
    $a->setTabela("notas");
    $r_a = $a->consultar(array("id_noticia", "nota"), "id_user = $id_user", "id_noticia");
    $result = $r_a->fetchAll(PDO::FETCH_ASSOC);
    
    $notas = array();
    foreach($result as $r){
        $notas[$r["id_noticia"]] = $r['nota'];
    }
    
    $noticias = array_keys($notas);
    $noticias = implode(", ", $noticias);
    
    $b = new Crud();
    $b->setTabela("notas");
    $r_b = $b->consultar(array("id_user", "id_noticia", "nota"), "id_user <> $id_user AND id_noticia IN($noticias)", "id_noticia");
    $result_todos = $r_b->fetchAll(PDO::FETCH_ASSOC);
    
    $todos_users = array();
    foreach($result_todos as $r){
        $todos_users[$r['id_user']][$r['id_noticia']] = $r['nota'];
    }
    
    $comparacao = array();
    $ids_users_validos = array();
    foreach($todos_users as $key => $value){
        $comparacao[] = array_values(array_intersect_key($notas, $todos_users[$key]));
        $comparacao[] = array_values(array_intersect_key($todos_users[$key], $notas));
        
        $p = new Pearson($comparacao);
        $pearson = $p->calcula();
        
        if($pearson > 0.29){
            $ids_users_validos[] = $key;
        }
        
        $comparacao = array();
        $person = null;
    }
    
    $ids_v = implode(", ", array_values($ids_users_validos));
    
    $recomendacoes = new Crud();
    $recomendacoes->setTabela("notas");
    $ids_v_noticias = $recomendacoes->consultar(array("id_noticia"), "id_user IN($ids_v) AND nota > 2 AND id_noticia NOT IN($noticias)");
    
    $dados = null;
    if($ids_v_noticias == ""){
        $padrao = new Crud();
        $padrao->setTabela("notas");
        $ids_padrao = $padrao->consultar(array("id_noticia"), "id_user <> $id_user AND nota > 2 AND id_noticia NOT IN($noticias)");
        
        $ids = array();
        foreach($ids_padrao->fetchAll(PDO::FETCH_ASSOC) as $i){
            $ids[] = $i['id_noticia'];
        }
        
        $dehbora = implode(", ", array_values($ids));
        
        $n = new Crud();
        $n->setTabela("noticias");
        $n_result = $n->consultar(array("titulo, permalink, pubDate"), "id IN($dehbora)", "pubDate", "20");

        $dados = $n_result->fetchAll(PDO::FETCH_ASSOC);
    }else {
        $ids = array();
        foreach($ids_v_noticias->fetchAll(PDO::FETCH_ASSOC) as $i){
            $ids[] = $i['id_noticia'];
        }

        $dehbora = implode(", ", array_values($ids));

        //var_dump($ids_v_noticias); die;

        $n = new Crud();
        $n->setTabela("noticias");
        $n_result = $n->consultar(array("titulo, permalink, pubDate"), "id IN($dehbora)", "pubDate", "20");

        $dados = $n_result->fetchAll(PDO::FETCH_ASSOC);
    }    
    
    $app->render('recomendacoes.php', array('dados' => $dados));
    //echo_pre($dados);
}
function avaliar(){
    $app = Slim::getInstance();
    $user = $app->view()->getData('user');
    
    //print_r($_POST);die;
    $titulo = $_POST['dados']['titulo'];
    $permalink = $_POST['dados']['permalink'];
    $data = $_POST['dados']['data'];
    $nota = $_POST['nota'];
    
    //1 - Verifica se a notícia já foi cadastrada
    $b_noticia = new Crud();
    $b_noticia->setTabela("noticias");
    
    $noticia_result = $b_noticia->consultar(array("id"), "permalink = '".$permalink."'");
    $noticia_result = $noticia_result->fetch(PDO::FETCH_ASSOC);
    
    if($noticia_result == ""){
        //Se não existir esta notícia cadastrada, cadastra Notícia
        $add_noticia = new Crud();
        $add_noticia->setTabela("noticias");
        
        $add = $add_noticia->inserir(
                array(
                    "titulo" => $titulo,
                    "permalink" => $permalink,
                    "pubDate" => $data
                )
        );
        
        if($add){
            //Se adicionou com sucesso, retorna ID da notícia adicionada
            $id_noticia = $add_noticia->ultimoId();
        }else{
            //Se houver erro ao adicionar, retorna erro e encerra o script
            echo "Erro ao atribuir nota";
            exit;
        }
    }else{
        //Se já existir notícia, busca seu ID
        $id_noticia = $noticia_result['id'];
    }
    
    //2 - Verifica se já deu a nota
    $b_nota = new Crud();
    $b_nota->setTabela("notas");
    
    $nota_result = $b_nota->consultar(array("id"), "id_user = ".$user['id']." AND id_noticia = ".$id_noticia);
    $nota_result = $nota_result->fetch(PDO::FETCH_ASSOC);

    if($nota_result == ""){
        //Se não deu nota ainda, dá a nota
        $add_nota = new Crud();
        $add_nota->setTabela("notas");
        
        $nota_add = $add_nota->inserir(
                array(
                    "nota" => $nota,
                    "id_user" => $user['id'],
                    "id_noticia" => $id_noticia
                )
        );
        
        if(!$nota_add){
            //Se não conseguir add a nota, retorna um erro e encerra script
            echo "Erro ao atribuir nota";
            exit;
        }
        
    }else {
        //Se já deu, então atualiza a nota
        $atualiza_nota = new Crud();
        $atualiza_nota->setTabela("notas");
        
        $up_nota = $atualiza_nota->atualizar(
                array(
                    "nota" => $nota
                ),
                "id = ".$nota_result['id']
        );
        
        if($up_nota != 1){
            //Se não for possível atualizar a nota, retorna erro
            echo "Erro ao atribuir nota";
            exit;
        }
    }
    
    $app->redirect(URL_BASE.'/templates/avaliacao.php?permalink='.base64_encode($permalink).'&iduser='.$user['id']);
    
}
function newuser(){
    $app = Slim::getInstance();
    
    $user = new Usuario();
    
    $user->setNome($_POST['nome']);
    $user->setEmail($_POST['email']);
    $user->setSenha($_POST['senha'], $_POST['confirma_senha']);
    
    if($user->CriarUsuario()){
        $user->insereFeeds($user->idInserido);
        $user->primeiroLogin();
        $app->flash('sucesso', "Parabéns! Seu cadastro foi realizado com sucesso, e você já pode adicionar bases de notícias, avaliar e receber recomendações.");
        $app->flash('primeiro_uso', TRUE);
        $app->redirect(URL_BASE.'/');
    }else{
        $app->flash('errors', $user->erros);
        $app->redirect(URL_BASE.'/inicial');
    }
    
}
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
        $read->enable_cache(false);
        $read->set_feed_url($l[0]['url']);
        $read->set_url_replacements(array('a' => 'href', 'img' => 'src'));
        $read->strip_htmltags(array('a'));

        $read->init();
        $read->handle_content_type();
        $app->render('home.php', array('rss' => $read->get_items(), 'nome' => $l[0]['nome']));
    } else {
        echo "Esta página não existe";
    }
}
function add_feed(){
    $app = Slim::getInstance();
    
    $count_erro = 0;
    $erro_url = 0;
    
    if(!$_POST['nome']){
        $count_erro += 1;
    } elseif(!$_POST['url']){
        $count_erro += 1;
    } elseif(!preg_match('|^http(s)?://[a-z0-9-]+(\.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $_POST['url'])){
        $erro_url = 1;
    }
    
    if($count_erro > 0){
        $app->flash('errors', 'Os campos <strong>NOME</strong> e <strong>URL</strong> são obrigatórios!');
        $app->redirect(URL_BASE.'/');
        exit;
    }elseif($erro_url == 1){
        $app->flash('errors', 'O campo <strong>URL</strong> deve ser um URL válido. (o prefixo http:// é obrigatório)!');
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
function inicial() {
    $app = Slim::getInstance();
    
    if(isset($_SESSION['dehbora']['user'])){
        $app->redirect(URL_BASE);
    }else{
        $app->render('inicial.php');
    }
}
function login() {
    $app = Slim::getInstance();
    $login = new Login();

    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $ok = $login->valida($email, $senha);
    
    $errors = null;
    if($ok == false){
        $errors = "E-mail e/ou senha estão incorretos.";
    }
    
    if (count($errors) > 0) {
        $app->flash('erro-login', $errors);
        $app->redirect(URL_BASE.'/inicial');
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
    $app->redirect(URL_BASE.'/inicial');
}
function noticia($titulo){
    $app = Slim::getInstance();
    
    $dados_feed = $_POST;
    
    $app->render('noticia.php', array('dados_feed' => $dados_feed));
}