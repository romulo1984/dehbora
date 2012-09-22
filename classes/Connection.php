<?php
    class Connection extends PDO {
        private $dsn = 'mysql:dbname=dehbora1_2;host=dbmy0020.whservidor.com';
        private $user = 'dehbora1_2';
        private $password = 'dehbora180382';
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
                echo 'Connection failed: ' . $e->getMessage( );
                return false;
            }
        }

        function __destruct() {
            $this->handle = NULL;
        }
}