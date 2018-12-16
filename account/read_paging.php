<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/account.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and account object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$account = new Account($db);
 
// query accounts
$stmt = $account->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num==0){
 
    // accounts array
    $accounts_arr=array();
    $accounts_arr["records"]=array();
    $accounts_arr["paging"]=array();
 
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
			"balance" => $balance,
            "equity" => $equity,
            "credit" => $credit,
            "marginfree" => $marginfree,
            "marginlevel" => $marginlevel,
			"status" => $status,
			"data" => $data
        );
 
        array_push($accounts_arr["records"], $account_item);
    }
 
 
    // include paging
    $total_rows=$account->count();
    $page_url="{$home_url}account/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $accounts_arr["paging"]=$paging;
 
    echo json_encode($accounts_arr);
}
 
else{
    echo json_encode(
        array("message" => "No accounts found.")
    );
}
?>