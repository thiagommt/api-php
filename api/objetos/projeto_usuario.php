<?php
class Projeto{
  
    // database connection and table name
    private $conn;
    private $table_name = "projetos";
  
    // object properties
    public $id_projeto;
    public $id_usuario;
    public $nome;
    public $descricao;
    public $disciplina;
    public $ano;
    public $semestre;
    public $linkgit;
    public $datacadastro;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function read($keywords){
    
        // select all query
        $query = "SELECT
                    p.id_projeto, p.nome, p.disciplina, p.descricao, p.ano, p.semestre, p.linkgit, p.datacadastro 
                FROM
                    " . $this->table_name . " p 
                 WHERE  p.id_usuario = ? ";             
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // bind id of product to be updated
        $stmt->bindParam(1, $keywords);

        // execute query
        $stmt->execute();
        
        return $stmt;
    }

    // create product
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    nome=:nome, descricao=:descricao, disciplina=:disciplina, ano=:ano, semestre=:semestre, linkgit=:linkgit, id_usuario=:id_usuario, datacadastro=:datacadastro";

        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->descricao=htmlspecialchars(strip_tags($this->descricao));
        $this->disciplina=htmlspecialchars(strip_tags($this->disciplina));
        $this->ano=htmlspecialchars(strip_tags($this->ano));
        $this->semestre=htmlspecialchars(strip_tags($this->semestre));
        $this->linkgit=htmlspecialchars(strip_tags($this->linkgit));
        $this->id_usuario=htmlspecialchars(strip_tags($this->id_usuario));
        $this->datacadastro=htmlspecialchars(strip_tags($this->datacadastro));
    
        // bind values
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":disciplina", $this->disciplina);
        $stmt->bindParam(":ano", $this->ano);
        $stmt->bindParam(":semestre", $this->semestre);
        $stmt->bindParam(":linkgit", $this->linkgit);
        $stmt->bindParam(":id_usuario", $this->id_usuario);
        $stmt->bindParam(":datacadastro", $this->datacadastro);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }
}
?>