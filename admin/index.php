<?php

session_start();
if (isset($_SESSION['email'])) {
    header('location: dashboard.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Admin | Login</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/bundles/bootstrap-social/bootstrap-social.css">
    <link rel="stylesheet" href="assets/bundles/izitoast/css/iziToast.min.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>
                            <div class="card-body">
                                <div id="alert"></div>
                                <form method="POST" id="login_form" action="#" class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email" tabindex="1" value="<?php if(isset($_COOKIE['email'])){echo $_COOKIE['email'];} ?>" required autofocus>
                                        <div class="invalid-feedback">
                                            Please fill in your email
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password" tabindex="2" value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['password'];} ?>" required>
                                        <div class="invalid-feedback">
                                            please fill in your password
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" id="login_btn" class="btn btn-primary btn-lg btn-block" name="login" value="Login" tabindex="4">
                                        <!-- <button type="submit" id="login_btn" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- General JS Scripts -->
    <script src="assets/js/app.min.js"></script>
    <!-- JS Libraies -->
    <!-- JS Libraies -->
    <script src="assets/bundles/izitoast/js/iziToast.min.js"></script>
    <!-- Page Specific JS File -->
    <!-- Template JS File -->
    <script src="assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="assets/js/custom.js"></script>
    <script>
        //   Handle Admin Login
        $("#login_btn").click(function(e) {
            e.preventDefault();
            $("#login_btn").val('Please Wait...');
            if ($("#email").val() == '') {
                $("#login_btn").val('Login');
                iziToast.error({
                    title: 'Email Empty!',
                    message: 'Email Field is required!',
                    position: 'topRight'
                });
            } else if ($("#password").val() == '') {
                $("#login_btn").val('Login');
                iziToast.error({
                    title: 'Password Empty!',
                    message: 'Password Field is required!',
                    position: 'topRight'
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: "../lib/admin.php",
                    data: $("#login_form").serialize() + '&action=login',
                    success: function(response) {
                        $("#login_form")[0].reset();
                        $("#login_btn").val('Login');
                        if (response == 'admin_login') {
                            iziToast.success({
                                title: 'Login Successfully!',
                                message: 'Wait just a second we redirect you to dashboard',
                                position: 'topRight'
                            });
                            window.setTimeout(function() {
                                window.location = 'dashboard.php';
                            }, 5000);
                        } else {
                            iziToast.error({
                                title: 'Login Failed!',
                                message: 'Your Email and password didn\'t matched our database',
                                position: 'topRight'
                            });
                        }
                    }
                });
            }


        })
    </script>
</body>


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->

</html>