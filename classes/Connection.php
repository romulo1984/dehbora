<?php
    class Connection extends PDO {
        private $dsn = 'mysql:dbname=dehbora;host=www.redetribuna.com.br';
        private $user = 'tribunaonline';
        private $password = 'tribunaonline1';
        public $handle = null;

        function __construct() {
            try {
                if ($this->handle == null) {
                    $dbh = parent::__construct( $this->dsn , $this->user , $this->password);
                    $this->handle = $dbh;
                    return $this->handle;
                }
            }
            catch (PDOException $e) {
                echo 'A conexão falhou: ' . $e->getMessage();
                return false;
            }
        }

        public function setDsn($dsn){
            $this->dsn = $dsn;
        }
        public function setUser($user){
            $this->user = $user;
        }
        public function setSenha($password){
            $this->password = $password;
        }
        
//        function __destruct() {
//            $this->handle = NULL;
//        }
}