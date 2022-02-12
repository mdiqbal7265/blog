<?php include 'include/topbar.php'; ?>
<?php include 'include/main_sidebar.php'; ?>

<?php

if ($_GET['id'] && $_GET['action'] && $_GET['action'] == 'edit_post') {
    $id = $_GET['id'];
    $post = $auth->fetchPostById($id);
    if ($post == true) {
        $id = $post['id'];
        $title = $post['title'];
        $cat_id = $post['cat_id'];
        $author_id = $post['author_id'];
        $content = $post['content'];
        $old_image = $post['image'];
        $tag = explode(', ', $post['tag']);
        $status = $post['status'];
    } else {
        header('location: post.php');
    }
} else {
    header('location:post.php');
}


?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h4>Edit Your Post</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon btn-danger" href="#" id="edit_post_cancle"><i class="fas fa-times"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="#" method="post" enctype="multipart/form-data" id="update_post_form">
                                <input type="hidden" name="post_id" id="post_id" value="<?= $id; ?>">
                                <input type="hidden" name="" id="author_id" value="<?= $author_id; ?>">
                                <input type="hidden" name="old_image" id="old_image" value="<?= $old_image; ?>">
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" id="title" name="title" class="form-control" value="<?= $title; ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select class="form-control selectric" id="category" name="category">
                                            <?php foreach ($category as $value) : ?>
                                                <option value="<?= $value['id'] ?>" <?php
                                                                                    if ($cat_id == $value['id']) {
                                                                                        echo 'selected';
                                                                                    } else {
                                                                                        echo '';
                                                                                    } ?>><?= $value['category_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                                    <div class="col-sm-12 col-md-7">
                                        <textarea class="summernote-simple" id="content" name="content" placeholder="Write your content" required><?= $content; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumbnail</label>
                                    <div class="col-sm-12 col-md-7 col-lg-5">
                                        <div id="image-preview" class="image-preview">
                                            <label for="image-upload" id="image-label">Choose File</label>
                                            <input type="file" name="update_post_image" id="image-upload" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="../assets/img/upload/<?= $old_image ?>" alt="" class="img-thumbnail img-fluid">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tags</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control inputtags" id="tag" name="tags[]" value="<?php foreach ($tag as $tags) {
                                                                                                                            echo $tags;
                                                                                                                        }  ?>">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select class="form-control selectric" id="status" name="status">
                                            <option value="Publish" <?php
                                                                    if ($status == 'Publish') {
                                                                        echo 'selected';
                                                                    } else {
                                                                        echo '';
                                                                    } ?>>Publish</option>
                                            <option value="Draft" <?php
                                                                    if ($status == 'Draft') {
                                                                        echo 'selected';
                                                                    } else {
                                                                        echo '';
                                                                    } ?>>Draft</option>
                                            <option value="Pending" <?php
                                                                    if ($status == 'Pending') {
                                                                        echo 'selected';
                                                                    } else {
                                                                        echo '';
                                                                    } ?>>Pending</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="submit" name="submit" value="Update Post" class="btn btn-primary" id="update_post_btn">
                                        <!-- <button class="btn btn-primary">Create Post</button> -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include 'include/setting_sidebar.php'; ?>
</div>
<?php include 'include/footer.php'; ?>