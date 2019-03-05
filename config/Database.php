<?php 
class Database{
private $host = 'localhost';

private $db_name = 'my_blog';

private $db_user = 'root';

private $db_pass = 'root';
private $conn;

public function connect(){
$this->conn = null;

try{
$this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name,$this->db_user,$this->db_pass);  
$this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOExeption $e){

echo 'Connection Error'.$e->getMessage();
}
return $this->conn;
}

}
