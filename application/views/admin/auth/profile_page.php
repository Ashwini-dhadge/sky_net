<?php init_header(); ?>
<style>

.profile-image-wrapper{
    position:relative;
    display:inline-block;
}

.form-control{
    border-radius:10px;
    height:45px;
}

.card{
    border:none;
    border-radius:15px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

.btn-primary{
    border-radius:10px;
    height:45px;
    font-weight:600;
}

.nav-tabs .nav-link{
    margin:10px
}

.nav-tabs .nav-link.active{
    background:#4e73df;
    color:#fff !important;
}

</style>
<div class="main-content">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title"><?= $title ?> Profile
                            </h4>
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
                    <!-- Column -->
                    <div class="col-lg-3 col-xlg-3 col-md-3 " style="margin-left:10px; ">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30"> <img src="<?= base_url(USER_PROFILE . $details[0]['image']) ?>"
                                        class="img-circle" width="150" />
                                    <h4 class="card-title" style="margin-top: 10px;"><?= $details[0]['first_name'] ?>
                                        <?= $details[0]['last_name']; ?>
                                    </h4>
                                    <h6 class="card-subtitle"><?= $details[0]['email']; ?></h6>
                                </center>
                            </div>
                            <div>
                                <hr>
                            </div>
                            <div class="card-body"> <small class="text-muted">Email address </small>
                                <h6><?= $details[0]['email']; ?></h6> <small class="text-muted p-t-30 db">Phone</small>
                                <h6><?= $details[0]['mobile_no']; ?></h6> <small class="text-muted p-t-30 db">Status:
                                    <span
                                        class="text-success fw-bold"><?= $details[0]['status'] == 1 ? 'Active' : 'Inactive'; ?></span></small>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-8 col-md-8">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <!-- <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home"
                                        role="tab">Timeline</a> </li> -->
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile"
                                        role="tab">Profile</a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings"
                                        role="tab">Settings</a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">

                                <!--second tab-->
                                <div class="tab-pane active" id="profile" role="tabpanel">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Full Name</strong>
                                                <br>
                                                <p class="text-muted">
                                                    <?= $details[0]['first_name'] . ' ' . $details[0]['last_name']; ?>
                                                </p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong>
                                                <br>
                                                <p class="text-muted"><?= $details[0]['mobile_no']; ?></p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
                                                <br>
                                                <p class="text-muted"><?= $details[0]['email']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane active" id="settings" role="tabpanel">
                                    <div class="card-body">

                                        <form id="profile_form" enctype="multipart/form-data">
                                            <div class="row">

                                                <div class="col-md-12 text-center mb-4">

                                                    <div class="profile-image-wrapper">

                                                        <img id="previewImage"
                                                            src="<?= base_url(USER_PROFILE . $details[0]['image']) ?>"
                                                            class="rounded-circle shadow" width="140" height="140"
                                                            style="object-fit:cover;border:5px solid #f1f1f1;">

                                                    </div>

                                                    <div class="mt-3">
                                                        <input type="file" name="image" id="image" class="form-control">
                                                    </div>

                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Full Name</label>

                                                        <input type="text" name="first_name" class="form-control"
                                                            value="<?= $details[0]['first_name']; ?>" required>
                                                    </div>
                                                </div>

                                              
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Email Address</label>

                                                        <input type="email" name="email" class="form-control"
                                                            value="<?= $details[0]['email']; ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Mobile Number</label>
                                                        <input type="number" name="mobile_no" class="form-control"
                                                            value="<?= $details[0]['mobile_no']; ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>New Password</label>
                                                        <input type="password" name="password" class="form-control"
                                                            placeholder="Leave blank if not changing">
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mt-3 text-right">
                                                    <button type="submit" id="saveBtn" class="btn btn-primary px-5">
                                                        <i class="fa fa-save"></i>
                                                        Update Profile
                                                    </button>

                                                </div>

                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_footer(); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></script>
<script>

$(document).ready(function () {

    // IMAGE PREVIEW
    $('#image').change(function () {

        let reader = new FileReader();

        reader.onload = function (e) {
            $('#previewImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);

    });


    // FORM SUBMIT
    $('#profile_form').submit(function (e) {

        e.preventDefault();

        let formData = new FormData(this);

        $('#saveBtn').html(
            '<i class="fa fa-spinner fa-spin"></i> Updating...'
        );

        $.ajax({

            url: "<?= base_url('admin/Dashboard/update_profile/' . loginId()) ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",

                success: function (response) {

                    console.log(response);

                    $('#saveBtn').html(
                        '<i class="fa fa-save"></i> Update Profile'
                    );

                    if (response.status == true) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        });

                        setTimeout(function () {
                            location.reload();
                        }, 1500);

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });

                    }

                },

                error: function (xhr, status, error) {

                    $('#saveBtn').html(
                        '<i class="fa fa-save"></i> Update Profile'
                    );

                    console.log(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'AJAX Error',
                        text: 'Check console response'
                    });

                }

            });

        });

    });

</script>