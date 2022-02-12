<?php


class Database
{
    private $dsn = "mysql:host=localhost;dbname=db_blog";
    private $dbuser = "root";
    private $dbpass = "";

    public $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->dbuser, $this->dbpass);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
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
    public function addCategory($name, $slug, $status)
    {
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
    public function deleteCategory($id)
    {
        $sql = "DELETE FROM category WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return true;
    }

    // Edit Category
    public function fetchCategoryById($id)
    {
        $sql = "SELECT * FROM category WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    // Update Category
    public function updateCategory($name, $slug, $status, $id)
    {
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


    // Add Post By Admin
    public function add_post(array $post)
    {
        $prep = array();
        foreach ($post as $key => $data) {
            $prep[':' . $key] = $data;
        }

        $sql = "INSERT INTO post (" . implode(', ', array_keys($post)) . ") VALUES (" . implode(', ', array_keys($prep)) . ")";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($prep);

        return true;
    }

    // Fetch Post
    public function fetchPost($column, $condition, $trash = "")
    {
        if ($trash != null) {
            $sql = "SELECT post.*,category.category_name,admin.name,admin.avater FROM post 
            INNER JOIN category ON post.cat_id = category.id 
            INNER JOIN admin ON post.author_id = admin.id WHERE post.$column = :condition AND post.trash = :trash ORDER BY post.id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['condition' => $condition, 'trash' => $trash]);
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $row;
        } else {
            $sql = "SELECT post.*,category.category_name,admin.name,admin.avater FROM post 
            INNER JOIN category ON post.cat_id = category.id 
            INNER JOIN admin ON post.author_id = admin.id WHERE post.$column = $condition ORDER BY post.id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $row;
        }
    }

    // Post Action
    public function postAction($id, $column, $value="", $deleted = "")
    {


        if ($deleted != null) {
            $sql = "DELETE FROM post WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            return true;
        } else {
            $sql = "UPDATE post SET $column = :value WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'value' => $value,
                'id' => $id
            ]);
            return true;
        }

        
    }

    // Post Count 

    public function postCount($column, $condition, $trash = "")
    {
        if ($trash != null) {
            $sql = "SELECT * FROM post WHERE $column = :condition AND trash = :trash";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['condition' => $condition, 'trash' => $trash]);

            $count = $stmt->rowCount();
            return $count;
        } else {
            $sql = "SELECT * FROM post WHERE $column = :condition";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['condition' => $condition]);

            $count = $stmt->rowCount();
            return $count;
        }
    }

    // fetch post by specific id
    public function fetchPostById($id)
    {
        $sql = "SELECT * FROM post WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    // Update Post By Admin

    public function update_post($title, $slug, $cat, $author, $content, $image, $tag, $status, $id)
    {

        $sql = "UPDATE post SET 
            title = :title, 
            slug = :slug, 
            cat_id = :cat, 
            author_id = :author, 
            content= :content, 
            image = :image, 
            tag = :tag,
            status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'title' => $title,
            'slug' => $slug,
            'cat' => $cat,
            'author' => $author,
            'content' => $content,
            'image' => $image,
            'tag' => $tag,
            'status' => $status,
            'id' => $id,
        ]);
        return true;
    }
}
