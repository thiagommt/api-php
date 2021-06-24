<?php
class Usuario{
  
    // database connection and table name
    private $conn;
    private $table_name = "usuarios";
  
    // object properties
    public $id_usuario;
    public $nome;
    public $email;
    public $senha;
    public $tipo_usuario;
    public $sexo;
    public $datacadastro;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

	function login(){
	  
        $query = "SELECT
                    u.id_usuario, u.nome 
                FROM
                    " . $this->table_name . " u 
                 WHERE  u.email = ? AND u.senha = ? "; 
	  
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	  
		// bind id of product to be updated
		$stmt->bindParam(1, $this->email);
        $stmt->bindParam(2, $this->senha);
	  
		// execute query
		$stmt->execute();
	  
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	  
		// set values to object properties
		$this->id_usuario = $row['id_usuario'];
		$this->nome = $row['nome'];
	}   

    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    nome=:nome, email=:email, senha=:senha, tipo_usuario=:tipo_usuario, sexo=:sexo, datacadastro=:datacadastro";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->senha=htmlspecialchars(strip_tags($this->senha));
        $this->tipo_usuario=htmlspecialchars(strip_tags($this->tipo_usuario));
        $this->sexo=htmlspecialchars(strip_tags($this->sexo));
        $this->datacadastro=htmlspecialchars(strip_tags($this->datacadastro));
    
        // bind values
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":senha", $this->senha);
        $stmt->bindParam(":tipo_usuario", $this->tipo_usuario);
        $stmt->bindParam(":sexo", $this->sexo);
        $stmt->bindParam(":datacadastro", $this->datacadastro);
    
        // execute query
        if($stmt->execute()){                       
            return true;
        }
    
        return false; 
    }

    function exists($email){

        $query = "SELECT
                    u.id_usuario 
                FROM
                    " . $this->table_name . " u 
                 WHERE  u.email = ?"; 
	  
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	  
		// bind id of product to be updated
		$stmt->bindParam(1, $email);
	  
		// execute query
		$stmt->execute();
        
        return $stmt;
    }
}
?>