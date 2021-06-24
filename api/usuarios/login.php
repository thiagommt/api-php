<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objetos/usuario.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare Usuario object
$usuario = new Usuario($db);
  
// set ID property of record to read
$usuario->email = isset($_GET['email']) ? $_GET['email'] : die();
$usuario->senha = isset($_GET['senha']) ? $_GET['senha'] : die();
  
// read the details of Usuario to be edited
$usuario->login();
  
if($usuario->id_usuario!=null){
    // create array
    $usuario_arr = array(
        "id_usuario" =>  $usuario->id_usuario,
        "nome" => $usuario->nome, 
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($usuario_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user Usuario does not exist
    echo json_encode(array("mensagem" => "Usuario não existe."));
}
?>