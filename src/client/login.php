<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin ,Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

@$user->email = $data->email;
@$user->password = $data->password;

// query users
$stmt = $user->login();
//$num = $stmt->rowCount();
 
// check if more than 0 record found
if(!empty($user->email)){
 
    // users array
    $users_arr=array();
   // $users_arr["data"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
   // while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
       // extract($row);
 
        $dados_user=array(
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
            "level" => $user->level,
            "status" => $user->status,
			"username" => $user->username,
			"auth" => 1
        );
 
        //array_push($users_arr, $user_item);
   // }
	//array_merge(self::$users_arr, $users_arr)
    echo json_encode($dados_user);
}
 
else{
    echo json_encode(
        array("message" => "Erro na autenticaчуo")
    );
}
?>