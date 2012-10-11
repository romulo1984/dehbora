<?php

class Usuario {
    
    public $nome;
    public $email;
    private $senha;
    private $confirma_senha;
    public $erros = array();
    public $idInserido;
    
    function __construct() {
    }

    public function emailExiste($email){
        //include('crud.php');
        $v = new Crud();
        $v->setTabela('users');
        $ok = $v->consultar(
                array('id'),
                "email = '$email'"
                )->fetchAll();
        
        if(count($ok) > 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function setNome($nome){
        if(strlen($nome) < 3 || strlen($nome) > 200){
            $this->erros[] = "O Nome deve ter no mínimo 3 e no máximo 200 caracteres.";
        }else{
            $this->nome = $nome;
        }
    }
    
    public function setEmail($email){
        if (!preg_match("/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$/i", $email)) {
            $this->erros[] = "Você deve informar um e-mail válido.";
        }elseif($this->emailExiste($email)){
            $this->erros[] = "Já existe um usuário cadastrado com este e-mail.";
        }else{
            $this->email = $email;
        }
    }
    
    public function setSenha($senha, $confirma_senha){
        if(strlen($senha) < 4){
            $this->erros[] = "A senha deve conter pelo menos 4 dígitos.";
        }elseif($senha != $confirma_senha){
            $this->erros[] = "A confirmação de senha não confere.";
        }else{
            $this->senha = sha1($senha);
        }
    }
    
    public function CriarUsuario(){
        if(count($this->erros) > 0){
            return false;
        }else{
            $v = new Crud();
            $v->setTabela('users');
            
            $ok = $v->inserir(
                array(
                    "nome" => $this->nome,
                    "email" => $this->email,
                    "senha" => $this->senha
                )
            );
            
            //echo_pre($ok); die;
            
            if($ok){
                $this->idInserido = $v->ultimoId();
                return true;
            }else{
                return false;
            }
        }
    }
    
    public function insereFeeds($idUser){
        $add_feed1 = new Crud();
        $add_feed1->setTabela('feeds');
        $add_feed1->inserir(
            array(
                "nome" => "Terra - Tecnologia",
                "url" => "http://rss.terra.com.br/0,,EI12879,00.xml",
                "publico" => 1,
                "id_user" => $idUser
            )
        );
        
        $add_feed2 = new Crud();
        $add_feed2->setTabela('feeds');
        $add_feed2->inserir(
            array(
                "nome" => "BBC News - Latin America",
                "url" => "http://feeds.bbci.co.uk/news/world/latin_america/rss.xml",
                "publico" => 1,
                "id_user" => $idUser
            )
        );
        
        $add_feed3 = new Crud();
        $add_feed3->setTabela('feeds');
        $add_feed3->inserir(
            array(
                "nome" => "Folha Vitória - Entretenimento",
                "url" => "http://www.folhavitoria.com.br/feed/entretenimento",
                "publico" => 1,
                "id_user" => $idUser
            )
        );
    }
    
    public function primeiroLogin(){
        $pL = new Crud();
        $pL->setTabela("users");
        $result = $pL->consultar(array("id","nome", "email"), "id = {$this->idInserido}");
        
        $_SESSION['dehbora']['user'] = $result->fetch(PDO::FETCH_ASSOC);
    }
    
}