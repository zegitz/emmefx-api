<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/account.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare account object
$account = new Account($db);
 
// set ID property of account to be edited
$account->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of account to be edited
$account->readOne();
 
// create array
$account_arr = array(
    "id" =>  $account->id,
	"accountnumber" => $account->accountnumber,
    "name" => $account->name,
    "credit" => $account->credit,
    "balance" => $account->balance,
    "equity" => $account->equity,
    "marginfree" => $account->marginfree,
	"marginlevel" => $account->marginlevel,
    "status" => $account->status,
    "data" => $account->data
	
 
);
 
// make it json format
print_r(json_encode($account_arr));
?>