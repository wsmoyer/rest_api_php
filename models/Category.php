<?php 
class Category{

private $conn;

private $table = 'categories';

public $id;
public $category_name;
public $created_at;

public function __construct($db){
$this->conn = $db;
}
public function read(){
$query = 'SELECT * from '.$this->table.'
ORDER BY created_at DESC
';
$stmt = $this->conn->prepare($query);
$stmt->execute();

return $stmt;
}


    
}