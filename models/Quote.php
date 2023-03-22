<?php
    class Quote {
        //DB stuff
        private $conn;
        private $table = 'quotes';

        //Quote Properties
        public $id;
        public $quote;
        public $category;
        public $author;
        public $author_id;
        public $category_id;

        //Constructor with DB

        public function __construct($db) {
            $this->conn = $db;
        }

        //Read function
        public function read(){

            //create query
            $query = "SELECT
            quotes.id,
            quotes.quote,
            authors.author, 
            categories.category
            FROM
            " .$this->table. "
            LEFT JOIN
            authors ON quotes.author_id = authors.id
            LEFT JOIN
            categories ON quotes.category_id = categories.id";

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
            quotes.id,
            quotes.quote,
            authors.author,
            categories.category
            FROM
            ". $this->table. "
            LEFT JOIN
            authors ON quotes.author_id = authors.id
            LEFT JOIN
            categories ON quotes.category_id = categories.id
            WHERE 
            quotes.id = ?
            LIMIT 1 OFFSET 0";

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
                $this->quote = $row['quote'];
                $this->author = $row['author'];
                $this->category = $row['category'];
                return true;
            }else{
                echo json_encode(array('message' => 'No Quotes Found'));
                return false;
            }
        }

        //create quote
        public function create(){

            //create query
            $query = "INSERT INTO ".$this->table." (quote, author_id, category_id) 
            VALUES (:quote, :author_id, :category_id)
            RETURNING id, quote, author_id, category_id";

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            //Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            //execute query
            if($stmt->execute()) {
                return $stmt->fetch()['id'];
            }else{
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        
        }

        //update function
        public function update(){
            
            //create query
            $query = "UPDATE " .$this->table. " 
            SET 
            quote = :quote,
            author_id = :author_id,
            category_id = :category_id
            WHERE 
            id = :id";

            // prepare Statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind Data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
            
            
            // execute query
            if($stmt->execute()){
                if($stmt->rowCount() == 0){
                    return false;
                }else{
                    return true;
                }
            }else{ 
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

        //Delete Function
        public function delete(){

            //create query
            $query = "DELETE FROM " .$this->table. "
            WHERE 
            id = :id";

            //prepare statment
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind data
            $stmt->bindParam(':id', $this->id);

            //execute query
            if($stmt->execute()){
                if($stmt->rowCount() == 0){
                    return false;
                }else{
                    return true;
                }
            }else{ 
                printf("Error: %s.\n", $stmt->error);
                return false;
            }

        }
    }
?>        