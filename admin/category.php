<?php include 'include/topbar.php'; ?>
<?php include 'include/main_sidebar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-4">
                    <!-- Add Category -->
                    <div class="card card-primary" id="add_card">
                        <form action="#" method="post" id="add_category_form">
                            <div class="card-header">
                                <h4 id="card-title">Add Category</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" name="name" id="category_name" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <div class="control-label">Status</div>
                                    <div class="custom-switches-stacked mt-2">
                                        <label class="custom-switch">
                                            <input type="radio" name="status" value="1" class="custom-switch-input" checked="">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Active</span>
                                        </label>
                                        <label class="custom-switch">
                                            <input type="radio" name="status" value="0" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">InActive</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <input type="submit" id="add_category_btn" name="add_category" value="Add Category" class="btn btn-primary btn-block">
                            </div>
                        </form>
                    </div>
                    <!-- Add Category -->
                    <!-- Edit Category -->
                    <div class="card card-info" style="display: none;" id="edit_card">
                        <form action="#" method="post" id="edit_category_form">
                            <div class="card-header">
                                <h4 id="card-title">Update Category</h4>
                                <div class="card-header-action">
                                    <a class="btn btn-icon btn-danger" href="#" id="update_cancle"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="id" id="edit_id">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" name="name" id="edit_category_name" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <div class="control-label">Status</div>
                                    <div class="custom-switches-stacked mt-2">
                                        <label class="custom-switch">
                                            <input type="radio" id="status" name="status" value="1" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Active</span>
                                        </label>
                                        <label class="custom-switch">
                                            <input type="radio" id="status" name="status" value="0" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">InActive</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <input type="submit" id="edit_category_btn" name="edit_category" value="Update Category" class="btn btn-primary btn-block">
                            </div>
                        </form>
                    </div>
                    <!-- Edit Category -->
                </div>
                <div class="col-12 col-md-8 col-lg-8">
                    <div class="card card-success">
                        <div class="card-header">
                            <h4>ALL Category</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon btn-danger" href="#" id="refresh"><i class="fas fa-undo-alt"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-striped dataTable no-footer" id="table-1" role="grid" aria-describedby="table-1_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="text-center sorting_asc" tabindex="0" aria-controls="table-1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="
                              #
                            : activate to sort column descending" style="width: 24.4375px;">
                                                            SI
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="table-1" rowspan="1" colspan="1" aria-label="Task Name: activate to sort column ascending" style="width: 149.078px;">Name</th>
                                                        <th class="sorting" tabindex="0" aria-controls="table-1" rowspan="1" colspan="1" aria-label="Due Date: activate to sort column ascending" style="width: 89.0938px;">Slug</th>
                                                        <th class="sorting" tabindex="0" aria-controls="table-1" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 108.266px;">Status</th>
                                                        <th class="sorting" tabindex="0" aria-controls="table-1" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 73.1875px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="category_body">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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