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

function login(){
    $app = Slim::getInstance();
    session_start();
    if(isset($_SESSION['logado_admin'])){
        if($_SESSION['logado_admin'] == TRUE){
            $app->redirect(BASE.'admin');
        }
    }
    $app->render("login.php");
}

function entrar(){
    $app = Slim::getInstance();
    
    session_start();
    $user = $_POST['user'];
    $senha = $_POST['senha'];
    if($user == "admin" && $senha == "123456"){
        $_SESSION['logado_admin'] = TRUE;
        $app->redirect(BASE.'admin');
    }elseif(isset($_SESSION['logado_admin'])) {
        if($_SESSION['logado_admin'] == TRUE){
            $app->redirect(BASE.'admin');
        }
    }else{
        $app->redirect(BASE.'admin/login?login=false');
    }
}

function logout(){
    $app = Slim::getInstance();
    session_start();
    session_destroy();
    $app->redirect(BASE.'admin/login');
}

function listar(){
    $app = Slim::getInstance();
    $app->render("portfolio.php");
}

function config(){
    $app = Slim::getInstance();
    $app->render("configuracoes.php");
}

function user(){
    $app = Slim::getInstance();
    $app->render("usuarios.php");
}

function update($id){
    $app = Slim::getInstance();
    $p = $_POST;
    echo $id."<br />";
    echo $p['nome']."<br />";
    echo $p['email']."<br />";
    $method = $app->request()->getMethod();
    echo "<br />O método utilizado na requisição foi ".$method."<br />";
};

//Funções de Rotas da API
function consultaPortfolio(){
    $app = Slim::getInstance();
    $app->render("api/portfolio.php");
}

function consultaPortfolioId(){
    
}

function add_config(){
    $app = Slim::getInstance();
    
    $add = Doctrine::getTable('Config')->find(1);
    
    $add->logo = $_POST['logo'];
    $add->texto_one = $_POST['texto_one'];
    $add->texto_two = $_POST['texto_two'];
    $add->logo_menu = $_POST['logo_menu'];
    $add->cod_analytics = $_POST['cod_analytics'];
    $add->title_sobre = $_POST['title_sobre'];
    $add->pre_sobre = $_POST['pre_sobre'];
    $add->bloco_sobre_one = $_POST['bloco_sobre_one'];
    $add->bloco_sobre_two = $_POST['bloco_sobre_two'];
    $add->bloco_sobre_three = $_POST['bloco_sobre_three'];
    $add->title_contato = $_POST['title_contato'];
    $add->end_contato = $_POST['end_contato'];
    $add->cont_contato = $_POST['cont_contato'];
    $add->email_contato = $_POST['email_contato'];
    $add->title_portfolio = $_POST['title_portfolio'];
    $add->qtd_portfolio = $_POST['qtd_portfolio'];
    
    $add->save();
    $app->redirect(BASE.'admin/configuracoes?sucesso=true');
}

function add_port(){
    $app = Slim::getInstance();
    
    if($_FILES['img']['error'] == 0 && !empty($_POST['info'])){
        // Instanciamos o objeto Upload
        $handle = new Upload($_FILES['img']);
        $name = mt_rand();
        // Então verificamos se o arquivo foi carregado corretamente
        if($handle->uploaded){       
            // Definimos as configurações desejadas da imagem maior
            $handle->file_max_size           = '5120000';
            $handle->file_new_name_body      = $name;
            $handle->image_resize            = true;
            $handle->image_ratio_y           = true;
            $handle->image_x                 = 800;
            $handle->image_convert           = 'jpg';
            $handle->file_name_body_add      = '_large';
            $handle->mime_check              = true;

            // Definimos a pasta para onde a imagem maior será armazenada
            //$handle->Process(BASE.'admin/imagens/portfolio/large/');
            //$handle->Process('../../imagens/portfolio/large/');
            $handle->Process('../imagens/portfolio/large/');
            $large_image = $handle->file_dst_name;
            
            $handle->file_max_size           = '5120000';
            $handle->file_new_name_body      = $name;
            $handle->file_name_body_add      = '_thumb';
            $handle->image_resize            = true;
            $handle->image_ratio_y           = false;
            $handle->image_ratio_crop        = true;
            $handle->image_x                 = 102;
            $handle->image_y                 = 102;
            $handle->image_convert           = 'jpg';
            $handle->mime_check              = true;

            //$handle->Process('../../imagens/portfolio/thumbnails/');
            $handle->Process('../imagens/portfolio/thumbnails/');
            $thumb_image = $handle->file_dst_name;

            $handle->Clean();

            if ($handle->processed){
                //INSERI NO BANCO DE DADOS
                $port = new Portfolio();
                $port->thumb_img_portfolio = 'imagens/portfolio/thumbnails/'.$thumb_image;
                $port->big_img_portfolio = 'imagens/portfolio/large/'.$large_image;
                $port->info_portfolio =  $_POST['info'];
                $port->save();
                
                $app->redirect(BASE.'admin/portfolio?request=1');
            }else{
                $app->redirect(BASE.'admin/portfolio?request=2&msg='.$handle->error);
            }
        }
    }else{
        $app->redirect(BASE.'admin/portfolio?request=3&msg=Nenhuma descricao ou imagem nao selecionada!');
    }
}

function delete_port($id){
    $app = Slim::getInstance();
    
    $delete = Doctrine::getTable('Portfolio')->find($id);
    if($delete) {
        $delete->delete();
        $app->redirect(BASE.'admin/portfolio?request=4&msg=Imagem do portfolio excluida com sucesso!');
    }else{
        $app->redirect(BASE.'admin/portfolio?request=5&msg=A imagem do portfolio nao pode ser excluida!');
    }
}
?>
