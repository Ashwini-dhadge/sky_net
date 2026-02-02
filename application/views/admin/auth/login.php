<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= PROJECTNAME ?? ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/icon.png">

    <!-- Bootstrap Css -->
    <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url(); ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>
<style>
.account-pages .logo-admin {
    border-bottom: 2px solid #cd9749;
}

.btn-primary {
    background-color: #CA151C;
    border-color: #CA151C;
}

.btn-primary:hover {
    color: #fff;
    background-color: #CA151C !important;
    border-color: #CA151C !important;
}
</style>

<body>


    <div class="home-btn d-none d-sm-block">
        <a href="index-2.html" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>

    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden shadow-sm rounded-lg">
                        <?php if ($msg = $this->session->flashdata('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button><?= $msg ?>
                        </div>
                        <?php endif ?>
                        <?php if ($msg = $this->session->flashdata('error')): ?>
                        <div class="alert alert-danger" role="alert"><button type="button" class="close"
                                data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button><?= $msg ?></div>
                        <?php endif ?>
                        <div class=" " style="">
                            <!-- <div class=" " style="background: #1A252F;"> -->
                            <div class="text-primary text-center p-4 ">
                                <!-- <h5 class="text-white font-size-20">Welcome Back !</h5>
                                <p class="text-white mb-4">Sign in to continue to .</p> -->
                                <a href="index-2.html" class="logo ">
                                    <img src="<?= base_url(); ?>assets/images/icon1.png" height="74" alt="logo"
                                        style="margin-left:-23px;margin-top:-10px;">
                                </a>
                            </div>

                        </div>

                        <div class="card-body p-4 ">
                            <div class="p-3">
                                <form class="form-horizontal m-t-30" method="post" action="<?= base_url('admin') ?>"
                                    enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="email" required
                                            placeholder="Enter username" multiple="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="userpassword">Password</label>
                                        <input type="password" class="form-control" id="password" required
                                            name="password" placeholder="Enter password">
                                    </div>
                                    <div class="form-group row m-t-20">
                                        <div class="col-sm-12 text-center">
                                            <button class="btn btn-primary w-md waves-effect waves-light"
                                                type="submit">Log
                                                In</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>

                    <div class="mt-5 text-center">
                        <!--    <p>Don't have an account ? <a href="pages-register.html" class="font-weight-medium text-primary"> Signup now </a> </p>-->
                        <p class="mb-0">© <script>
                            document.write(new Date().getFullYear())
                            </script> . <?= PROJECTNAME; ?> </p>
                    </div>


                </div>
            </div>
        </div>
        <script src="<?= base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/node-waves/waves.min.js"></script>

        <script src="<?= base_url(); ?>assets/js/app.js"></script>
        <script type="text/javascript">
        setInterval(function() {
            $('.alert').fadeOut("slow");
        }, 3000);
        </script>
</body>

</html>