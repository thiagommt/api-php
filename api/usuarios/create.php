<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate usuario object
include_once '../objetos/usuario.php';
  
$database = new Database();
$db = $database->getConnection();
  
$usuario = new Usuario($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->nome) &&
    !empty($data->email) &&
    !empty($data->senha) &&
    !empty($data->sexo) &&
    !empty($data->tipo_usuario) &&
    !empty($data->datacadastro) 
){
  
    // set Usuario property values
    $usuario->nome = $data->nome;
    $usuario->email = $data->email;
    $usuario->senha = $data->senha;
    $usuario->sexo = $data->sexo;
    $usuario->tipo_usuario = $data->tipo_usuario;
    $usuario->datacadastro = date('Y-m-d');

    // query products
    $stmt = $usuario->exists($data->email);
    $num = $stmt->rowCount();

    // create the Usuario if not exists
    if ($num == 0) {
        if($usuario->create()) {
  
            // set response code - 201 created
            http_response_code(201);
      
            // tell the user
            echo json_encode(array("mensagem" => "Usuário criado com sucesso."));
        } else {
      
            // set response code - 503 service unavailable
            http_response_code(503);
      
            // tell the user
            echo json_encode(array("mensagem" => "Falha ao criar usuario."));
        }
    } else {
        // set response code - 400 bad request
        http_response_code(400);
  
        // tell the user
        echo json_encode(array("mensagem" => "Falha ao criar usuario. Email já vinculado a outro usuário!"));
    }

} else {
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("mensagem" => "Falha ao criar usuario. Verifique os dados!"));
}
?>