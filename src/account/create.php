<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate account object
include_once '../objects/account.php';
 
$database = new Database();
$db = $database->getConnection();
 
$account = new Account($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

// set account property values
$account->accountnumber = $data->accountnumber;
$account->name = $data->name;
$account->credit = $data->credit;
$account->balance = $data->balance;
$account->equity = $data->equity;
$account->marginfree = $data->marginfree;
$account->marginlevel = $data->marginlevel;
$account->status = $data->status;
$account->data = $data->data;
 
// create the account
if($account->create()){
    echo '{';
        echo '"message": "Account was created."';
    echo '}';
}
 
// if unable to create the account, tell the user
else{
    echo '{';
        echo '"message": "Unable to create account."';
		
    echo '}';
}
?>