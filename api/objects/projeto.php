<?php
class Projeto{
  
    // database connection and table name
    private $conn;
    private $table_name = "projeto";
  
    // object properties
    public $id;
    public $nome;
    public $descricao;
    public $categoria_id;
    public $category_nome;
    public $created;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // le os projetos 
    function read(){
    
        // select all query
        $query = "SELECT
                    c.nome as categoria_nome, p.id, p.nome, p.descricao, p.categoria_id, p.dt_cadastro
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categorias c
                            ON p.categoria_id = c.id
                ORDER BY
                    p.dt_cadastro DESC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
}
?>