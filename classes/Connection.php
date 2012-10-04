<?php
    class Connection extends PDO{
        private $datasource;
        private $dbname;
        private $host;
        private $user;
        private $password;
        public $handle = null;

        function __construct() {
            try {
                if ($this->handle == null) {
                    $dbConfig = new DbConfig();
                    $this->setDatasource($dbConfig->default['datasource']);
                    $this->setDbName($dbConfig->default['dbname']);
                    $this->setHost($dbConfig->default['host']);
                    $this->setUser($dbConfig->default['user']);
                    $this->setPassword($dbConfig->default['password']);
                    
                    $dbh = parent::__construct( "$this->datasource:dbname=$this->dbname;host=$this->host" , $this->user , $this->password);
                    $this->handle = $dbh;
                    return $this->handle;
                }
            }
            catch (PDOException $e) {
                echo 'A conexão falhou: ' . $e->getMessage();
                return false;
            }
        }

        public function setDatasource($datasource){
            $this->datasource = $datasource;
        }
        public function setHost($host){
            $this->host = $host;
        }
        public function setDbName($dbname){
            $this->dbname = $dbname;
        }
        public function setUser($user){
            $this->user = $user;
        }
        public function setPassword($password){
            $this->password = $password;
        }
}