<?php
    class Login extends Connection {
        public $logado = null;
        public $user = array();
        
        public function conecta(){
            $conn = new Connection();
            return $conn;
        }
        
        public function verificaFb($fb_id){
            $con = $this->conecta();
            $query = 'SELECT * FROM users WHERE facebook_id = ?';
            
            $stmt = $con->prepare($query);
            $stmt->bindValue(1, $fb_id);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->user = $result;
            
            if(count($result) > 0){
                return true;
            }else{
                return false;
            }
        }
        
        public function grava($fb_id, $nome, $email, $image){
            $con = $this->conecta();
            $query = 'INSERT INTO users (nome, email, facebook_id, image_facebook) VALUES (?, ?, ?, ?)';
            
            $stmt = $con->prepare($query);
            $stmt->bindValue(1, $nome);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $fb_id);
            $stmt->bindValue(4, $image);
            $stmt->execute();
        }
        
        public function logar($fb_id, $nome, $email, $image){
            $ok = $this->verificaFb($fb_id);
            if($ok){
                $this->logado = true;
            }else {
                $this->grava($fb_id, $nome, $email, $image);
                $this->verificaFb($fb_id);
                $this->logado = true;
            }
        }
    }