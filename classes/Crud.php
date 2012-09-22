<?php  
    class Crud extends Connection{
        private $pdo;
        private $tabela;
        
        public function setTabela($tabela){
            $this->tabela = $tabela;
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
                $this->pdo = new Connection();
                return $this->pdo;
            }
        }
    
        public function inserir(array $campos){
            $coluna = implode(", ",  array_keys($campos));
            $valor = "'".implode("', '", array_values($campos))."'";
            
            $query = "INSERT INTO {$this->tabela} ({$coluna}) VALUES ({$valor})";
            
            $this->conectar()->exec($query);
        }
        
        public function consultar(array $select, $where = null, $order = null, $limit = null){
            $where = ($where == null) ? null : "WHERE {$where}";
            if($select != "*"){
                $select = implode(", ", $select);
            } else {
                $select = "*";
            };
            
            $order = ($order == null) ? null : "ORDER BY {$order}";
            $limit = ($limit == null) ? null : "LIMIT {$limit}";
            
            $query = "SELECT {$select} FROM {$this->tabela} {$where} {$order} {$limit}";
            $result = $this->conectar()->query($query);
            return $result;
        }
        
        public function deletar($where){
            $query = "DELETE FROM {$this->tabela} WHERE {$where}";
            
            $this->conectar()->exec($query);
        }
        
        public function atualizar(array $set, $where){
            foreach($set as $chave => $valor){
                $campos[] = "{$chave}='{$valor}'";
            };
            $campos = implode(", ", $campos);
            $query = "UPDATE {$this->tabela} SET {$campos} WHERE {$where}";
            
            $result = $this->conectar()->exec($query);
        }
}