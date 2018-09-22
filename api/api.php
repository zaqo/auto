<?php
/*http://www.tutorialsface.com/2016/02/simple-php-mysql-rest-api-sample-example-tutorial/*/     
require_once("Rest.inc.php");
     
class API extends REST {
     
    public $data = "";
  
    const DB_SERVER = "localhost";
    const DB_USER = "php";
    const DB_PASSWORD = "XiWgTVngtK2s886t";
    const DB = "auto";
     
    private $db = NULL;
 
    public function __construct(){
        parent::__construct();              // Init parent contructor
        $this->dbConnect();                 // Initiate Database connection
}
    
private function dbConnect(){
        $this->db = mysqli_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
		if (!$this->db) 
		{
				die("Database connection failed: " . mysqli_connect_error());
		}
        else
		{
            $db_select=mysqli_select_db($this->db,self::DB);
		if (!$db_select) 
		{
			die("Database selection failed: " . mysqli_error($this->db));
		}
}
}
     
    /*
     * Public method for access api.
     * This method dynmically call the method based on the query string
     *
     */
public function processApi(){
        $func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
        if((int)method_exists($this,$func) > 0)
            $this->$func();
        else
            $this->response('Error code 404, Page not found buddy :)',404);   // If the method not exist with in this class, response would be "Page not found".
}
private function hello(){
    echo str_replace("this","that","HELLO ARTEMIY! ;)");
 
}
 
private function test(){    
    // Cross validation if the request method is GET else it will return "Not Acceptable" status
    if($this->get_request_method() != "GET"){
        $this->response('',406);
    }
    $myDatabase= $this->db;// variable to access your database
    //$param=$this->_request['var'];
	$aValue[]=array();
	if ($result = $myDatabase->query("SELECT * FROM cars LIMIT 10")) {
    printf("Select returned %d rows.\n", $result->num_rows);
	//$this->response($result, 200); 
	while ($myrow = $result->fetch_array(MYSQLI_ASSOC))
	{
		$aValue[]["vin"]=$myrow["vin"];
		//$bValue[]=$myrow["b"];
	}
	
	$res=array_shift($aValue);
	$this->response($this->json($aValue), 200);
    /* free result set */
    $result->close();
}
    // If success everythig is good send header as "OK" return param
    //$this->response($param, 200);    
}
 
    /*
     *  Encode array into JSON
    */
    private function json($data){
        if(is_array($data)){
            return json_encode($data);
        }
    }
}
 
    // Initiiate Library
     
    $api = new API;
    $api->processApi();
?>