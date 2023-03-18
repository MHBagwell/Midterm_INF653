<?php

class Author{
    //Variables
    private $conn;
    private $table = 'authors';

    public $id;
    public $author;

    // Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    //Read function
    public function read(){
        
        //create query
        $query = "SELECT
        id, author
        FROM
        " .$this->table. "
        ORDER BY
        id";

         // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        //Execute query
        $stmt->execute();

        return $stmt;
    }

    //Read single function
    public function read_single(){

        //create query
        $query = "SELECT
        id,
        author
        FROM
        " .$this->table. "
        WHERE 
        id = ?
        LIMIT 0,1";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        if(isset($row['id'])&& isset($row['author'])){
            $this->id = $row['id'];
            $this->author = $row['author'];
            return true;
        }else{
            return false;
        }
    }

    //Create Author
    public function create(){

        //create query
        $query = "INSERT INTO " .$this->table. " (author) 
        VALUES (:author)";

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->author = htmlspecialchars(strip_tags($this->author));

        //Bind data
        $stmt->bindParam(':author', $this->author);

        //execute query
        if($stmt->execute()) {
            return true;
        }else{
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    //Update function
    public function update(){

        //create query
        $query = "UPDATE " .$this->table. " 
        SET author = :author
        WHERE id = :id";

        //prepare statment
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->author = htmlspecialchars(strip_tags($this->author));

        //Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':author', $this->author);

        //execute query
        if($stmt->execute()){
            return true;
        }else{ 
            printf("Error: %s. \n", $stmt->error);
            return false;
        }
    }

    //Delete Function
    public function delete(){

        //create query
        $query = "DELETE FROM " .$this->table. "
        WHERE id = :id";

        //prepare statment
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindParam(':id', $this->id);

        //execute query
        if($stmt->execute()){
            return true;
        }else{ 
            printf("Error: %s. \n", $stmt->error);
            return false;
        }

    }

}
?>