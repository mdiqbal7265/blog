<?php
session_start();
require_once 'classes/Authentication.php';
require_once 'classes/Helper.php';
$auth = new Authentication();
$helper = new Helper();
$db = new Database();

// Handle Admin Login
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = $helper->sanitize_data($_POST['email']);
    $password = $helper->sanitize_data($_POST['password']);

    $hash_password = sha1($password);

    $loggedIn = $auth->admin_login($email, $hash_password);

    if ($loggedIn != null) {
        if (!empty($_POST['remember'])) {
            setcookie("email", $email, time() + (30 * 24 * 60 * 60), '/');
            setcookie("password", $password, time() + (30 * 24 * 60 * 60), '/');
        } else {
            setcookie("email", "", 1, "/");
            setcookie("password", "", 1, "/");
        }
        echo 'admin_login';
        $_SESSION['email'] = $email;
    }
}

// Fetch Admin Details
$admin = $auth->admin_details($_SESSION['email']);

// Logout Request
if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    unset($_SESSION['email']);
    echo 'logout';
}

// Fetch All Category

if (isset($_POST['fetchCategory']) && $_POST['fetchCategory'] == 'fetchCategory') {
    $output = '';
    $category = $db->fetchCategory();
    $i = 1;
    foreach ($category as $value) {
        $output .= '<tr>
                        <td>' . $i++ . '</td>
                        <td>' . $value['category_name'] . '</td>
                        <td>' . $value['category_slug'] . '</td>
                        <td>' .
            ($value['status'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">InActive</span>') . '
                        </td>
                        <td>
                            <a href="#" class="btn btn-icon btn-primary btn-sm category_edit" data-toggle="tooltip" data-placement="top" title="Category Edit" id="' . $value['id'] . '"><i class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-icon btn-danger btn-sm category_delete" data-toggle="tooltip" data-placement="top" title="Category Delete" id="' . $value['id'] . '"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>';
    }

    echo $output;
}

// Add Category
if (isset($_POST['action']) && $_POST['action'] == 'add_category') {
    $name = $helper->sanitize_data($_POST['name']);
    $slug = $helper->genarate_slug($name);
    $status = $helper->sanitize_data($_POST['status']);

    $db->addCategory($name, $slug, $status);
}

// Delete Category
if (isset($_POST['action']) && $_POST['action'] == 'delete_category') {
    $id = $_POST['id'];

    $db->deleteCategory($id);
}

// Edit Category
if (isset($_POST['action']) && $_POST['action'] == 'edit_category') {
    $id = $_POST['id'];

    $data = $db->fetchCategoryById($id);
    echo json_encode($data);
}

// Add Category
if (isset($_POST['action']) && $_POST['action'] == 'update_category') {
    $id = $_POST['id'];
    $name = $helper->sanitize_data($_POST['name']);
    $slug = $helper->genarate_slug($name);
    $status = $helper->sanitize_data($_POST['status']);

    $db->updateCategory($name, $slug, $status, $id);
}

// Fetch Category for post
$category = $db->fetchCategory();

// Add Post By Ajax Request
if (isset($_FILES['image'])) {
    $folder = '../assets/img/upload/';

    if (isset($_FILES['image']['name']) && ($_FILES['image']['name'] != "")) {
        $filename = time() . '-' . $_FILES['image']['name'];
        $tmpname = $_FILES['image']['tmp_name'];
        $upload_path = $folder . $filename;
        move_uploaded_file($tmpname, $upload_path);
    }

    $tag = implode(',', $_POST['tags']);

    $data = array(
        'title' => $helper->sanitize_data($_POST['title']),
        'slug' => $helper->genarate_slug($_POST['title']),
        'cat_id' => $helper->sanitize_data($_POST['category']),
        'content' => $helper->sanitize_data($_POST['content']),
        'image' => $filename,
        'tag' => $tag,
        'status' => $helper->sanitize_data($_POST['status']),
        'author_id' => $admin['id']
    );

    $db->add_post($data);
}

// Fetch All Post

if (isset($_POST['fetchPost']) && $_POST['fetchPost'] == 'fetchPost') {
    $output = '';
    $post = $db->fetchPost('trash', 0);
    $i = 1;
    foreach ($post as $value) {
        $output .= '<tr>
                        <td>' . $i++ . '</td>
                        <td>
                            <a href="#">
                                <img alt="image" src="../assets/img/upload/' . $value['avater'] . '" class="rounded-circle" width="35" data-toggle="title" title="">
                                <span class="d-inline-block ml-1">' . $value['name'] . '</span>
                            </a>
                        </td>
                        <td>
                            ' . $value['title'] . '
                            <div class="table-links">
                            <a href="../' . $value['slug'] . '">View</a>
                            <div class="bullet"></div>
                            <a href="#">Edit</a>
                            <div class="bullet"></div>
                            <a href="#" class="text-danger dlt_post" id="' . $value['id'] . '">Trash</a>
                            </div>
                        </td>
                        <td>
                            <a href="#">' . $value['category_name'] . '</a>
                        </td>
                        <td>' . $helper->timeAgo($value['created_at']) . '</td>
                        <td>3,587</td>
                        <td>
                            ' . (($value['status'] == 'Pending') ? '<div class="badge badge-warning">Pending</div>' : (($value['status'] == 'Draft') ? '<div class="badge badge-danger">Draft</div>' : '<div class="badge badge-success">Publish</div>')) . '
                        </td>
                    </tr>';
    }

    echo $output;
}

// Fetch Trash Post
if (isset($_POST['action']) && $_POST['action'] == 'fetchTrashData') {
    $output = '';
    $post = $db->fetchPost('trash', 1);
    $i = 1;
    foreach ($post as $value) {
        $output .= '<tr>
                        <td>' . $i++ . '</td>
                        <td>
                            <a href="#">
                                <img alt="image" src="../assets/img/upload/' . $value['avater'] . '" class="rounded-circle" width="35" data-toggle="title" title="">
                                <span class="d-inline-block ml-1">' . $value['name'] . '</span>
                            </a>
                        </td>
                        <td>
                            ' . $value['title'] . '
                            <div class="table-links">
                            <a href="../' . $value['slug'] . '">View</a>
                            <div class="bullet"></div>
                            <a href="#">Edit</a>
                            <div class="bullet"></div>
                            <a href="#" class="text-danger dlt_post" id="' . $value['id'] . '">Trash</a>
                            </div>
                        </td>
                        <td>
                            <a href="#">' . $value['category_name'] . '</a>
                        </td>
                        <td>' . $helper->timeAgo($value['created_at']) . '</td>
                        <td>3,587</td>
                        <td>
                            ' . (($value['status'] == 'Pending') ? '<div class="badge badge-warning">Pending</div>' : (($value['status'] == 'Draft') ? '<div class="badge badge-danger">Draft</div>' : '<div class="badge badge-success">Publish</div>')) . '
                        </td>
                    </tr>';
    }

    echo $output;
}

// Fetch Draft Post
if (isset($_POST['action']) && $_POST['action'] == 'fetchDraftData') {
    $output = '';
    $post = $db->fetchPost('status', 'Draft', '0');
    $i = 1;
    foreach ($post as $value) {
        $output .= '<tr>
                        <td>' . $i++ . '</td>
                        <td>
                            <a href="#">
                                <img alt="image" src="../assets/img/upload/' . $value['avater'] . '" class="rounded-circle" width="35" data-toggle="title" title="">
                                <span class="d-inline-block ml-1">' . $value['name'] . '</span>
                            </a>
                        </td>
                        <td>
                            ' . $value['title'] . '
                            <div class="table-links">
                            <a href="../' . $value['slug'] . '">View</a>
                            <div class="bullet"></div>
                            <a href="#">Edit</a>
                            <div class="bullet"></div>
                            <a href="#" class="text-danger dlt_post" id="' . $value['id'] . '">Trash</a>
                            </div>
                        </td>
                        <td>
                            <a href="#">' . $value['category_name'] . '</a>
                        </td>
                        <td>' . $helper->timeAgo($value['created_at']) . '</td>
                        <td>3,587</td>
                        <td>
                            ' . (($value['status'] == 'Pending') ? '<div class="badge badge-warning">Pending</div>' : (($value['status'] == 'Draft') ? '<div class="badge badge-danger">Draft</div>' : '<div class="badge badge-success">Publish</div>')) . '
                        </td>
                    </tr>';
    }

    echo $output;
}

// Fetch Draft Post
if (isset($_POST['action']) && $_POST['action'] == 'fetchPendingData') {
    $output = '';
    $post = $db->fetchPost('status', 'Pending', '0');
    $i = 1;
    if ($post) {
        foreach ($post as $value) {
            $output .= '<tr>
                            <td>' . $i++ . '</td>
                            <td>
                                <a href="#">
                                    <img alt="image" src="../assets/img/upload/' . $value['avater'] . '" class="rounded-circle" width="35" data-toggle="title" title="">
                                    <span class="d-inline-block ml-1">' . $value['name'] . '</span>
                                </a>
                            </td>
                            <td>
                                ' . $value['title'] . '
                                <div class="table-links">
                                <a href="../' . $value['slug'] . '">View</a>
                                <div class="bullet"></div>
                                <a href="#">Edit</a>
                                <div class="bullet"></div>
                                <a href="#" class="text-danger dlt_post" id="' . $value['id'] . '">Trash</a>
                                </div>
                            </td>
                            <td>
                                <a href="#">' . $value['category_name'] . '</a>
                            </td>
                            <td>' . $helper->timeAgo($value['created_at']) . '</td>
                            <td>3,587</td>
                            <td>
                                ' . (($value['status'] == 'Pending') ? '<div class="badge badge-warning">Pending</div>' : (($value['status'] == 'Draft') ? '<div class="badge badge-danger">Draft</div>' : '<div class="badge badge-success">Publish</div>')) . '
                            </td>
                        </tr>';
        }

        echo $output;
    } else {
        echo "<h2 class='text-center text-secondary'>No post Available here!</h2>";
    }
}

// Delete Post

if (isset($_POST['action']) && $_POST['action'] == 'delete_post') {
    $id = $_POST['id'];

    $db->postAction($id, 1);
}

// All Post Count
$all_post = $db->postCount('trash', 0);
// Draft post Count
$draft_post = $db->postCount('status', 'Draft', '0');
// Pending Post Count
$pending_post = $db->postCount('status', 'Pending', '0');
// Trash Post Count
$trash_post = $db->postCount('trash', 1);
