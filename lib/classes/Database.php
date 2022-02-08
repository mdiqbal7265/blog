<?php 


class Database{
    private $dsn = "mysql:host=localhost;dbname=db_blog";
    private $dbuser = "root";
    private $dbpass = "";

    public $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->dbuser, $this->dbpass);
        } catch (PDOException $e) {
            echo "Error: ".$e->getMessage();
        }

        return $this->conn;
    }

    // Fetch Category
    public function fetchCategory()
    {
        $sql = "SELECT * FROM category ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

    // Add Category
    public function addCategory($name,$slug,$status){
        $sql = "INSERT INTO category (category_name,category_slug,status) VALUES (:name, :slug, :status)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'slug' => $slug,
            'status' => $status,
        ]);

        return true;
    }

    // Delete Category
    public function deleteCategory($id){
        $sql = "DELETE FROM category WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=> $id]);
        return true;
    }

    // Edit Category
    public function fetchCategoryById($id){
        $sql = "SELECT * FROM category WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    // Update Category
    public function updateCategory($name,$slug,$status,$id){
        $sql = "UPDATE category SET category_name = :name, category_slug = :slug, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'slug' => $slug,
            'status' => $status,
            'id' => $id
        ]);

        return true;
    }


}






?>