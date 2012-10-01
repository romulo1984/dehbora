<?php

class Login extends Connection {

    public $user = array();

    public function conecta() {
        $conn = new Connection();
        return $conn;
    }

    private function codificaSenha($senha) {
        return sha1($senha);
        //return $senha;
    }
    
    public function valida($email, $senha) {
        $senha = $this->codificaSenha($senha);
        $con = $this->conecta();

        $query = "SELECT id, nome, email FROM users WHERE email = ? AND senha = ?";

        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $senha);
        $stmt->execute();

        $count = $stmt->rowCount();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($count == 0){
            return false;
        }else{
            $this->user = $result;
            return true;
        }
    }

    public function gravaSessao() {
        $_SESSION['dehbora']['user'] = $this->user;
    }

    public function logout() {
        unset($_SESSION['dehbora']['user']);
    }

}