<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/account.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare account object
$account = new Account($db);
 
// get id of account to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of account to be edited
//$account->id = $data->id;
 
// set account property values
$account->accountnumber = $data->accountnumber;
$account->name = $data->name;
$account->balance = $data->balance;
$account->equity = $data->equity;
$account->marginfree = $data->marginfree;
$account->marginlevel = $data->marginlevel;
$account->status = $data->status;
$account->data = $data->data;
 
// update the account
if($account->update()){
    echo '{';
        echo '"message": "Account was updated."';
    echo '}';
}
 
// if unable to update the account, tell the user
else{
    echo '{';
        echo '"message": "Unable to update account."';
    echo '}';
}
?>