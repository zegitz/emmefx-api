<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/account.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare account object
$account = new Account($db);
 
// get account id
$data = json_decode(file_get_contents("php://input"));
 
// set account id to be deleted
$account->id = $data->id;
 
// delete the account
if($account->delete()){
    echo '{';
        echo '"message": "Account was deleted."';
    echo '}';
}
 
// if unable to delete the account
else{
    echo '{';
        echo '"message": "Unable to delete account."';
    echo '}';
}
?>