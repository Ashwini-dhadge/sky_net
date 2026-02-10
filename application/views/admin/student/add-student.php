<?php init_header(); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.css"
    rel="stylesheet">

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title"></h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-right d-none d-md-block">
                                <button type="button" class="btn btn-secondary waves-effect waves-light mb-0"
                                    onclick="window.history.back()">Back</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title m-b-20"><?= $title; ?></h4>
                                <hr>
                                <form class="repeater" enctype="multipart/form-data" method="post" id="user_form"
                                    action="<?= base_url() . "admin/Student/add" ?>" autocomplete="off">
                                    <div class="row">
                                        <input type="hidden" name="id" id="id" value="<?= (isset($id)) ? $id : '' ?>">
                                        <input type="hidden" name="role" id="role"
                                            value="<?= (isset($role)) ? $role : '' ?>">
                                        <div class="form-group col-md-12">
                                            <label>Full Name</label>
                                            <div>
                                                <input type="text" class="form-control" required
                                                    placeholder="Enter First Name" name="first_name"
                                                    value="<?= (isset($first_name)) ? $first_name : ''; ?>">
                                            </div>
                                        </div>

                                        <!-- <div class="form-group col-md-6">
                                            <label>Last Name</label>
                                            <div class="text">
                                                <input type="text" class="form-control" required
                                                    placeholder="Enter Last Name" name="last_name"
                                                    value="<?= (isset($last_name)) ? $last_name : ''; ?>">
                                            </div>
                                        </div> -->
                                        <div class="form-group col-md-6">
                                            <label>Email</label>
                                            <div>
                                                <input type="text" class="form-control" required
                                                    placeholder="Enter Email" name="email"
                                                    value="<?= (isset($email)) ? $email : ''; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Mobile No</label>
                                            <div class="text">
                                                <input type="number" class="form-control" required
                                                    placeholder="Enter Mobile No" name="mobile_no"
                                                    data-parsley-trigger="keyup" data-parsley-length="[10,12]"
                                                    value="<?= (isset($mobile_no)) ? $mobile_no : ''; ?>"
                                                    data-parsley-mobile_no="<?= (isset($id)) ? $id : '0'; ?>">

                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Password</label>
                                            <div class="text">
                                                <input type="text" class="form-control" required
                                                    placeholder="Enter Password" name="password"
                                                    value="<?= (isset($password)) ? $password : '123456'; ?>">

                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Profile Image</label>
                                            <div>
                                                <input type="file" class="form-control" name="image">
                                                <?= (isset($image)) ? '<img src="' . base_url() . USER_IMAGES . $image . '" width="80">' : ''; ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Status</label>
                                            <div>
                                                <input type="radio" required value="1" name="status"
                                                    <?= (isset($status) && $status == 1) ? 'checked' : ''; ?> checked>
                                                &nbsp;&nbsp;Active&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="radio" required value="0" name="status"
                                                    <?= (isset($status) && $status == 0) ? 'checked' : ''; ?>>
                                                &nbsp;&nbsp;In-Active
                                            </div>
                                        </div>


                                        <div class="col-md-12 mb-4">
                                            <input type="submit" class="btn btn-primary float-left" value="Submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
</div>
<!-- content -->
<?php init_footer(); ?>