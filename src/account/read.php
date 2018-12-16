<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin ,Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/account.php';
 
// instantiate database and account object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$account = new Account($db);
 
// query accounts
$stmt = $account->read();
//$num = $stmt->rowCount();
 
// check if more than 0 record found
if($stmt){
 
    // accounts array
    $accounts_arr=array();
    //$accounts_arr["data"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $account_item=array(
            "id" => $id,
			"accountnumber" => $accountnumber,
            "name" => $name,
			"credit" => $credit,
			"balance" => $balance,
			"equity" => $equity,
			"marginfree" => $marginfree,
			"marginlevel" => $marginlevel,
			"status" => $status,
			"data" => $data,
			"manager" => $manager,
			"client" => $client
        );
 
        array_push($accounts_arr, $account_item);
    }

    echo json_encode($accounts_arr);
}
 
else{
    echo json_encode(
        array("message" => "No accounts found.")
    );
}
?>