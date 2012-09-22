<?php  
    class dsn{
        private $dsn = "mysql:host=dbmy0062.whservidor.com;dbname=studioveno1_2";
        private $user = "studioveno1_2";
        private $senha = "igor2705";
        private $pdo;
        private $configpdo = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                );
        
        function __construct() {
        }
        
        public function setDsn($dsn){
            $this->dsn = $dsn;
        }
        public function setUser($user){
            $this->user = $user;
        }
        public function setSenha($senha){
            $this->senha = $senha;
        }
        
        private function conectar(){
            if(empty($this->pdo)){
                $this->pdo = new PDO($this->dsn, $this->user, $this->senha, $this->configpdo);
                return $this->pdo;
            }
        }
    
        public function inserir(array $campos, $tabela){
            $coluna = implode(", ",  array_keys($campos));
            $valor = "'".implode("', '", array_values($campos))."'";
            
            $query = "INSERT INTO {$tabela} ({$coluna}) VALUES ({$valor})";
            
            $this->conectar()->exec($query);
        }
        
        public function consultar(array $select, $tabela, $where = null, $order = null, $limit = null){
            $where = ($where == null) ? null : "WHERE {$where}";
            if($select != "*"){
                $select = implode(", ", $select);
            } else {
                $select = "*";
            };
            
            $order = ($order == null) ? null : "ORDER BY {$order}";
            $limit = ($limit == null) ? null : "LIMIT {$limit}";
            
            $query = "SELECT {$select} FROM {$tabela} {$where} {$order} {$limit}";
            $result = $this->conectar()->query($query);
            return $result;
        }
        
        public function deletar($tabela, $where){
            $query = "DELETE FROM {$tabela} WHERE {$where}";
            
            $this->conectar()->exec($query);
        }
        
        public function atualizar($tabela, array $set, $where){
            foreach($set as $chave => $valor){
                $campos[] = "{$chave}='{$valor}'";
            };
            $campos = implode(", ", $campos);
            $query = "UPDATE {$tabela} SET {$campos} WHERE {$where}";
            
            $result = $this->conectar()->exec($query);
        }
}