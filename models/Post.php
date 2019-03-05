<?php 
class Post{

private $conn;

private $table = 'posts';
private $row_limit = 5;
public $id;
public $category_id;
public $category_name;
public $title;
public $body;
public $author;
public $created_at;


public function __construct($db){
$this->conn = $db;
}
public function read(){
$query = 'SELECT p.id,p.category_id,p.title,p.body,p.author,p.created_at,c.category_name from '.$this->table.' p,categories c where c.id = p.category_id 
ORDER BY p.created_at DESC';
$stmt = $this->conn->prepare($query);
$stmt->execute();

return $stmt;
}

public function read_single(){
    $query = 'SELECT p.id,p.category_id,p.title,p.body,p.author,p.created_at,c.category_name from '.$this->table.' p,categories c where c.id = p.category_id and p.id = ? 
    LIMIT 0,1';

    $stmt = $this->conn->prepare($query);

$stmt->bindParam(1,$this->id);

    $stmt->execute();
    
$row = $stmt->fetch(PDO::FETCH_ASSOC);


$this->title = $row['title'];
$this->body = $row['body'];
$this->author = $row['author'];
$this->created_at = $row['created_at'];
$this->category_id = $row['category_id'];
$this->category_name = $row['category_name'];

}

public function create(){

$query = 'INSERT INTO  '.$this->table.' SET 
title = :title,
body = :body,
author = :author,
category_id = :category_id';
$stmt = $this->conn->prepare($query);

$this->title = htmlspecialchars(strip_tags($this->title));
$this->body = htmlspecialchars(strip_tags($this->body));
$this->author = htmlspecialchars(strip_tags($this->author));
$this->category_id = htmlspecialchars(strip_tags($this->category_id));

$stmt->bindParam(':title', $this->title);
$stmt->bindParam(':body', $this->body);
$stmt->bindParam(':author', $this->author);
$stmt->bindParam(':category_id', $this->category_id);

if($stmt->execute()){
    return true;
}

printf("Error: %s.\n",$stmt->error);
    return false;

}
public function update() {
    // Create query
    $query = 'UPDATE ' . $this->table . '
                          SET title = :title, body = :body, author = :author, category_id = :category_id
                          WHERE id = :id';
    // Prepare statement
    $stmt = $this->conn->prepare($query);
    // Clean data
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->body = htmlspecialchars(strip_tags($this->body));
    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->id = htmlspecialchars(strip_tags($this->id));
    // Bind data
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':body', $this->body);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':id', $this->id);
    // Execute query
    if($stmt->execute()) {
      return true;
    }
    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);
    return false;
}

public function delete(){

$query = 'DELETE FROM '.$this->table.' WHERE id = :id';

$stmt = $this->conn->prepare($query);

$this->id = htmlspecialchars(strip_tags($this->id));

$stmt->bindParam(':id', $this->id);

if($stmt->execute()) {
    return true;
  }
  // Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);
  return false;

}
    
}