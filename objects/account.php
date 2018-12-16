<?php
class Account{
 
    // database connection and table name
    private $conn;
    private $table_name = "accounts";
 
    // object properties
    public $id;
	public $accountnumber;
    public $name;
    public $credit;
    public $equity;
    public $marginfree;
    public $marginlevel;
    public $status;
	public $data;
	
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
    
        // select all query
        $query = "SELECT * FROM ". $this->table_name ." ORDER BY id DESC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create product
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    accountnumber=:accountnumber ,
					name=:name ,
					balance=:balance ,
					equity=:equity ,
					marginfree=:marginfree ,
					marginlevel=:marginlevel , 
					status=:status ,
					data=:data
					";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
   
        // sanitize
		$this->accountnumber=htmlspecialchars(strip_tags($this->accountnumber));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->balance=htmlspecialchars(strip_tags($this->balance));
        $this->equity=htmlspecialchars(strip_tags($this->equity));
        $this->marginfree=htmlspecialchars(strip_tags($this->marginfree));
        $this->marginlevel=htmlspecialchars(strip_tags($this->marginlevel));
		$this->status=htmlspecialchars(strip_tags($this->status));
		$this->data=htmlspecialchars(strip_tags($this->data));
    
        // bind values
		$stmt->bindParam(":accountnumber", $this->accountnumber);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":balance", $this->balance);
        $stmt->bindParam(":equity", $this->equity);
        $stmt->bindParam(":marginfree", $this->marginfree);
        $stmt->bindParam(":marginlevel", $this->marginlevel);
		$stmt->bindParam(":status", $this->status);
		$stmt->bindParam(":data", $this->data);
	
	
        // execute query
        if($stmt->execute()){
            return true;
        }else{
		//echo "\nPDOStatement::errorInfo():\n";
		//$arr = $stmt->errorInfo();
		//	print_r($arr);
        return false;}
        
    }

    // used when filling up the update product form
    function readOne(){
    
        // query to read single record
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " 

                WHERE
                    id = ?
                LIMIT
                    0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
		$this->accountnumber = $row['accountnumber'];
        $this->name = $row['name'];
        $this->balance = $row['balance'];
        $this->equity = $row['equity'];
        $this->marginfree = $row['marginfree'];
        $this->marginlevel = $row['marginlevel'];
		$this->status = $row['status'];
        $this->data = $row['data'];
    }
    
    // update the product
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name,
                    balance = :balance,
                    equity = :equity,
                    marginfree = :marginfree,
					marginlevel = :marginlevel,
                    status = :status,
                    data = :data
                WHERE
                    accountnumber = :accountnumber";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->balance=htmlspecialchars(strip_tags($this->balance));
        $this->equity=htmlspecialchars(strip_tags($this->equity));
        $this->marginfree=htmlspecialchars(strip_tags($this->marginfree));
		$this->marginlevel=htmlspecialchars(strip_tags($this->marginlevel));
		$this->status=htmlspecialchars(strip_tags($this->status));
		$this->data=htmlspecialchars(strip_tags($this->data));
        $this->accountnumber=htmlspecialchars(strip_tags($this->accountnumber));
    
        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':balance', $this->balance);
        $stmt->bindParam(':equity', $this->equity);
        $stmt->bindParam(':marginfree', $this->marginfree);
		$stmt->bindParam(':marginlevel', $this->marginlevel);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':data', $this->data);
        $stmt->bindParam(':accountnumber', $this->accountnumber);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
    
    // delete the product
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // search accounts
    function search($keywords){
    
        // select all query
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " 
                WHERE
                    `accountnumber` LIKE :keyword
                ORDER BY
                   `id` DESC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
    
        // bind
        $stmt->bindParam(':keyword', $keywords,PDO::PARAM_STR);

    
        // execute query
        $stmt->execute();

        return $stmt;
    }

    // read products with pagination
    public function readPaging($from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " 
                ORDER BY id DESC
                LIMIT ?, ?";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }

    // used for paging products
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }
}
?>