<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET;POST");
header("Access-Control-Max-Age: 3600");
header("Referrer-Policy: origin");
header("Access-Control-Allow-Headers: Origin, Content-Type, Access-Control-Allow-Origin ,Access-Control-Allow-Headers, Authorization, X-Requested-With");
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));
$id = $data->id;
if($_GET){
$id = $_GET['id'];}
// read the details of user to be edited
$user->readOne($id);
 
// create array
if($user->name){
$user_arr = array(
    "id" =>  $id,
    "name" => $user->name,
    "email" => $user->email,
    "password" => $user->password,
    "level" => $user->level,
    "data" => $user->data,
	"status" => $user->status,
	"username" => $user->username
);
print_r(json_encode($user_arr));
}else{
	  echo '{';
        echo '"message": "Unable to find user."';
    echo '}';
}
?>