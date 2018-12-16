<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate client object
include_once '../objects/client.php';
 
$database = new Database();
$db = $database->getConnection();
 
$client = new Client($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
 //echo $data;
// set client property values
$client->name = $data->name;
$client->email = $data->email;
$client->username = $data->username;
$client->password = $data->password;
$client->level = $data->level;
$client->data = time();
$client->status = $data->status;
 //echo $client->name;
// create the client
if($client->create()){
    echo '{';
        echo '"status": 1';
    echo '}';
}
 
// if unable to create the client, tell the client
else{
    echo '{';
        echo '"message": "Unable to create client."';
    echo '}';
}
?>