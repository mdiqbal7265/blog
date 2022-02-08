<?php
session_start();
require_once 'classes/Authentication.php';
require_once 'classes/Helper.php';
$auth = new Authentication();
$helper = new Helper();
$db = new Database();

// Handle Admin Login
if(isset($_POST['action']) && $_POST['action'] == 'login'){
    $email = $helper->sanitize_data($_POST['email']);
    $password = $helper->sanitize_data($_POST['password']);

    $hash_password = sha1($password);

    $loggedIn = $auth->admin_login($email, $hash_password);

    if($loggedIn != null){
        if(!empty($_POST['remember'])){
            setcookie("email",$email, time()+(30*24*60*60),'/');
            setcookie("password",$password, time()+(30*24*60*60),'/');
        }else{
            setcookie("email","",1,"/");
            setcookie("password","",1,"/");
        }
        echo 'admin_login';
        $_SESSION['email'] = $email;
    }
}

// Fetch Admin Details
$admin = $auth->admin_details($_SESSION['email']);

// Logout Request
if(isset($_POST['action']) && $_POST['action'] == 'logout'){
    unset($_SESSION['email']);
    echo 'logout';
}

// Fetch All Category

if(isset($_POST['fetchCategory']) && $_POST['fetchCategory'] == 'fetchCategory'){
    $output = '';
    $category = $db->fetchCategory();
    $i = 1;
    foreach($category as $value){
        $output .= '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$value['category_name'].'</td>
                        <td>'.$value['category_slug'].'</td>
                        <td>'.
                            ($value['status'] == 1 ? '<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">InActive</span>').'
                        </td>
                        <td>
                            <a href="#" class="btn btn-icon btn-primary btn-sm category_edit" data-toggle="tooltip" data-placement="top" title="Category Edit" id="'.$value['id'].'"><i class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-icon btn-danger btn-sm category_delete" data-toggle="tooltip" data-placement="top" title="Category Delete" id="'.$value['id'].'"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>';
    }

    echo $output;
}

// Add Category
if(isset($_POST['action']) && $_POST['action'] == 'add_category'){
    $name = $helper->sanitize_data($_POST['name']);
    $slug = $helper->genarate_slug($name);
    $status = $helper->sanitize_data($_POST['status']);

    $db->addCategory($name,$slug,$status);

}

// Delete Category
if(isset($_POST['action']) && $_POST['action'] == 'delete_category'){
    $id = $_POST['id'];

    $db->deleteCategory($id);
}

// Edit Category
if(isset($_POST['action']) && $_POST['action'] == 'edit_category'){
    $id = $_POST['id'];

    $data = $db->fetchCategoryById($id);
    echo json_encode($data);
}

// Add Category
if(isset($_POST['action']) && $_POST['action'] == 'update_category'){
    $id = $_POST['id'];
    $name = $helper->sanitize_data($_POST['name']);
    $slug = $helper->genarate_slug($name);
    $status = $helper->sanitize_data($_POST['status']);

    $db->updateCategory($name,$slug,$status,$id);

}



?>