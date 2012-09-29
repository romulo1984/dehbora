<?php
    class Login extends Connection {
        public $user = array();
        
        public function conecta(){
            $conn = new Connection();
            return $conn;
        }
        
        public function codificaSenha($senha){
            //return sha1($senha);
            return $senha;
        }
        
        public function valida($email, $senha){
            $senha = $this->codificaSenha($senha);
            $con = $this->conecta();

            $query = "SELECT * FROM users WHERE email = ? AND senha = ?";
            
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $senha);
            $stmt->execute();
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo_pre($result);
            die;
            
            if(count($result) > 0){
                $this->user = $result;
                return true;
            }else{
                return false;
            }
        }
        
        public function gravaSessao(){
            return $_SESSION['dehbora']['user'] = $this->user;
        }
        
        public function logout(){
            unset($_SESSION['dehbora']['user']);
        }
    }