<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$user = new User($db);
 
// query users
$stmt = $user->levels();
 
// check if more than 0 record found
if($stmt){
 
    $users_arr=array();
    //$users_arr["data"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
 
        $user_item=array(
            "id" => $id,
            "level" => $level
        );
 
        array_push($users_arr, $user_item);
    }
 
    echo json_encode($users_arr);
}
 
else{
    echo json_encode(
        array("message" => "No levels found.")
    );
}
?>