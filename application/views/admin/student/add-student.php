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
                <div class="row">
                    <div class="col-12 d-flex justify-content-between ">
                        <h4 class="my-3 px-3">Students</h4>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/Student/') ?>">Students</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create / Edit</li>
                            </ol>
                        </nav>
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
                                            <input type="text"
                                                class="form-control"
                                                required
                                                id="full_name"
                                                placeholder="Enter Full Name"
                                                name="first_name"
                                                value="<?= (isset($first_name)) ? $first_name : ''; ?>">

                                            <small id="name_msg"></small>
                                        </div>


                                        <input type="hidden" id="user_id" name="user_id" value="<?= isset($id) ? $id : 0 ?>">
                                        <div class="form-group col-md-6">
                                            <label>Email</label>
                                            <input type="text"
                                                class="form-control"
                                                required
                                                placeholder="Enter Email"
                                                name="email"
                                                id="checkemail"
                                                value="<?= isset($email) ? $email : '' ?>">

                                            <small id="email_msg"></small>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Mobile No</label>
                                            <input type="text"
                                                class="form-control"
                                                required
                                                maxlength="10"
                                                placeholder="Enter Mobile No"
                                                name="mobile_no"
                                                id="mobile_no"
                                                value="<?= isset($mobile_no) ? $mobile_no : '' ?>">

                                            <small id="mobile_msg"></small>
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
                                                <?php if (!empty($image)) { ?>
                                                    <img src="<?= base_url(USER_PROFILE . $image) ?>" width="80">
                                                <?php } ?>
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


                                        <div class="form-group col-md-12">
                                            <button type="submit" id="submit_btn" class="btn btn-primary">
                                                Submit
                                            </button>
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
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let nameValid = false;
    let emailValid = false;
    let mobileValid = false;

    $("#submit_btn").prop("disabled", true);

    function checkSubmit() {
        if (nameValid && emailValid && mobileValid) {
            $("#submit_btn").prop("disabled", false);
        } else {
            $("#submit_btn").prop("disabled", true);
        }
    }


    $("#full_name").keyup(function() {

        let name = $(this).val().trim();
        let nameRegex = /^[A-Za-z ]+$/;

        if (name.length < 3) {
            $("#name_msg").html("Name must be at least 3 characters").css("color", "red");
            nameValid = false;
        } else if (!nameRegex.test(name)) {
            $("#name_msg").html("Only letters allowed").css("color", "red");
            nameValid = false;
        } else {
            $("#name_msg").html("Valid name").css("color", "green");
            nameValid = true;
        }

        checkSubmit();
    });


    $("#checkemail").keyup(function() {

        let email = $(this).val().trim();
        let user_id = $("#id").val();

        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(email)) {
            $("#email_msg").html("Invalid email format").css("color", "red");
            emailValid = false;
            checkSubmit();
            return;
        }

        $.ajax({
            url: "<?= base_url('admin/Student/check_email') ?>",
            type: "POST",
            data: {
                email: email,
                user_id: user_id
            },
            success: function(res) {

                if (res == "exists") {
                    $("#email_msg").html("Email already exists").css("color", "red");
                    emailValid = false;
                } else {
                    $("#email_msg").html("Email available").css("color", "green");
                    emailValid = true;
                }

                checkSubmit();
            }
        });

    });

    $("#mobile_no").keyup(function() {

        let mobile = $(this).val().trim();
        let user_id = $("#id").val();

        let mobileRegex = /^[6-9]\d{9}$/;

        if (!mobileRegex.test(mobile)) {
            $("#mobile_msg").html("Enter valid 10 digit mobile").css("color", "red");
            mobileValid = false;
            checkSubmit();
            return;
        }

        $.ajax({
            url: "<?= base_url('admin/Student/check_mobile') ?>",
            type: "POST",
            data: {
                mobile: mobile,
                user_id: user_id
            },
            success: function(res) {

                if (res == "exists") {
                    $("#mobile_msg").html("Mobile already exists").css("color", "red");
                    mobileValid = false;
                } else {
                    $("#mobile_msg").html("Mobile available").css("color", "green");
                    mobileValid = true;
                }

                checkSubmit();
            }
        });

    });


    $(document).ready(function() {

        let user_id = $("#id").val();

        if (user_id > 0) {
            nameValid = true;
            emailValid = true;
            mobileValid = true;
            checkSubmit();
        }

    });

    $("#mobile_no").on("keypress", function(e) {
        if (e.which < 48 || e.which > 57) {
            return false;
        }
    });
</script>