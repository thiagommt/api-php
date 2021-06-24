<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate projeto_usuario object
include_once '../objetos/projeto_usuario.php';
  
$database = new Database();
$db = $database->getConnection();
  
$projeto = new Projeto($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->nome) &&
    !empty($data->disciplina) &&
    !empty($data->ano) &&
    !empty($data->semestre) &&
    !empty($data->id_usuario) &&
    !empty($data->datacadastro) 
){
  
    // set product property values
    $projeto->nome = $data->nome;
    $projeto->descricao = $data->descricao;
    $projeto->disciplina = $data->disciplina;
    $projeto->ano = $data->ano;
    $projeto->semestre = $data->semestre;
    $projeto->linkgit = $data->linkgit;
    $projeto->id_usuario = $data->id_usuario;
    $projeto->datacadastro = date('Y-m-d');
  
    // create the projeto
    if($projeto->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("mensagem" => "Projeto criado com sucesso."));
    }
  
    // if unable to create the projeto, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("mensagem" => "Falha ao criar projeto."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("mensagem" => "Falha ao criar projeto. Verifique os dados!"));
}
?>