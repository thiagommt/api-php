<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../config/database.php';
include_once '../objetos/projeto_usuario.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$projeto = new Projeto($db);
  
// get keywords
$keywords=isset($_GET["id"]) ? $_GET["id"] : "";

// query products
$stmt = $projeto->read($keywords);
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    $projetos_arr=array();
    $projetos_arr["projetos"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $projeto_item=array(
            "id_projeto," => $id_projeto,
            "nome" => $nome,
            "descricao" => html_entity_decode($descricao),
            "disciplina" => $disciplina,
            "ano" => $ano,
            "semestre" => $semestre,
            "linkgit" => $linkgit,
            "datacadastro" => $datacadastro
        );
      
        array_push($projetos_arr["projetos"], $projeto_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($projetos_arr);
}else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("mensagem" => "Nenhum projeto encontrado.")
    );
}