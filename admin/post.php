<?php include 'include/topbar.php'; ?>
<?php include 'include/main_sidebar.php'; ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card mb-0">
            <div class="card-body">
              <ul class="nav nav-pills">
                <li class="nav-item">
                  <a class="nav-link active" id="all_post" href="#">All <span class="badge badge-white"><?= $all_post; ?></span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="draft_post" href="#">Draft <span class="badge badge-primary"><?= $draft_post; ?></span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="pending_post" href="#">Pending <span class="badge badge-primary"><?= $pending_post ?></span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" id="trash_post">Trash <span class="badge badge-primary"><?= $trash_post; ?></span></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-12">
          <div class="card card-info">
            <div class="card-header">
              <h4>All Posts</h4>
              <div class="card-header-action">
                <a href="add_post.php" class="btn btn-primary">
                  Add Post
                </a>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th class="text-center" width="5%">
                        #
                      </th>
                      <th width="20%">Author</th>
                      <th width="25%">Title</th>
                      <th width="10%">Image</th>
                      <th width="10%">Category</th>
                      <th width="15%">Created At</th>
                      <th width="5%">Views</th>
                      <th width="10%">Status</th>
                    </tr>
                  </thead>
                  <tbody id="post_body">

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>




  <?php include 'include/setting_sidebar.php'; ?>
</div>
<?php include 'include/footer.php'; ?>