<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$user = new User($db);
 
$data = json_decode(file_get_contents("php://input"));
// set ID property of user to be edited
$id = $data->id;
//$id = $_GET['id'];

// read the details of user to be edited
$user->levelOne($id);
 
// create array
$user_arr = array(
    "level" =>  $user->level
);
 
// make it json format
print_r(json_encode($user_arr));
?>