<?php

/**
 * Classe Crud responsável pela
 * @author Rômulo Guimarães <romulo1984@gmail.com>
 * @version 0.1
 * @copyright Copyright © 2012, Rômulo Guimarães.
 * @access public
 */
class Crud extends Connection {

    public $pdo;
    private $tabela;

    /**
     * Método para setar a tabela
     * @param type $tabela 
     */
    public function setTabela($tabela) {
        $this->tabela = $tabela;
    }

    /**
     * Método privado que retorna o objeto da conexão
     * @return type 
     */
    private function conectar() {
        if (empty($this->pdo)) {
            $this->pdo = new Connection();
            return $this->pdo;
        }
    }

    /**
     * Método de inserção de registro
     * @param array $campos Passe a coluna na chave do array e o dado a ser inserido no valor.
     * @return boolean Retorna true caso tenha inserido com sucesso e false em caso de erro.
     */
    public function inserir(array $campos) {
        $coluna = implode(", ", array_keys($campos));
        $valor = array_values($campos);
        $valorQuery = implode(", ", array_fill(0, count($valor), '?'));

        $query = "INSERT INTO {$this->tabela} ({$coluna}) VALUES ({$valorQuery})";

        $stmt = $this->conectar()->prepare($query);
        foreach ($valor as $k => $v) {
            $stmt->bindValue($k + 1, $v);
        }
        $stmt->execute() or die(print_r($stmt->errorInfo()));

        $count = $stmt->rowCount();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método para buscar registros
     * @param array $select
     * @param type $where
     * @param type $order
     * @param type $limit
     * @return type 
     */
    public function consultar(array $select, $where = null, $order = null, $limit = null) {
        $where = ($where == null) ? null : "WHERE {$where}";
        if ($select != "*") {
            $select = implode(", ", $select);
        } else {
            $select = "*";
        };

        $order = ($order == null) ? null : "ORDER BY {$order}";
        $limit = ($limit == null) ? null : "LIMIT {$limit}";

        $query = "SELECT {$select} FROM {$this->tabela} {$where} {$order} {$limit}";

        //echo $query; die;
        $result = $this->conectar()->query($query);
        return $result;
    }
    
    public function find($coluna, $valor){
        $query = "SELECT COUNT(id) FROM {$this->tabela} WHERE {$coluna} = '{$valor}'";
        
        $result = $this->conectar()->query($query);
        
        $qtd = $result->fetch(PDO::FETCH_ASSOC);
        
        return $qtd['COUNT(id)'];
    }
    
    /**
     * Método para deletar registros
     * @param type $where
     * @return boolean 
     */
    public function deletar($where) {
        $query = "DELETE FROM {$this->tabela} WHERE {$where}";

        if ($this->conectar()->exec($query) == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método para atualizar registros
     * @param array $set
     * @param type $where
     * @return boolean 
     */
    public function atualizar(array $set, $where) {
        foreach ($set as $chave => $valor) {
            $campos[] = "{$chave}='{$valor}'";
        };
        $campos = implode(", ", $campos);
        $query = "UPDATE {$this->tabela} SET {$campos} WHERE {$where}";

        if ($this->conectar()->exec($query) == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function ultimoId() {
        return $this->pdo->lastInsertId();
    }

}