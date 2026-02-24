<?php init_header(); ?>
<div class="main-content">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title"><?= $title ?> Profile</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-right d-none d-md-block">
                                <button type="button" class="btn btn-secondary waves-effect waves-light mb-0" onclick="window.history.back()">Back</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm" style="border-radius:18px;">
                            <div class="card-body p-4">
                                <input type="hidden" name="action" id="action" value="2">
                                <?php $img = ($user['image']) ? $user['image'] : 'no-image.png'; ?>
                                <div class="d-flex align-items-center mb-4">
                                    <div class="mr-3">
                                        <img src="<?= base_url() . USER_IMAGES . $img ?>"
                                            style="width:85px;height:85px;object-fit:cover;border-radius:15px;">
                                    </div>
                                    <div>
                                        <h5 class="mb-1 font-weight-bold">
                                            <?= $user['first_name']; ?> <?= $user['last_name']; ?>
                                        </h5>

                                        <span class="badge <?= ($user['status']) ? 'badge-success' : 'badge-secondary' ?>"
                                            style="padding:6px 14px;border-radius:30px;font-size:12px;">
                                            <?= ($user['status']) ? "Active Account" : "Inactive Account"; ?>
                                        </span>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <div class="profile-info d-flex">
                                    <div class="mr-5">
                                        <small class="text-muted d-block">Email Address</small>
                                        <span class="font-weight-medium"><?= $user['email']; ?></span>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Mobile Number</small>
                                        <span class="font-weight-medium"><?= $user['mobile_no']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm" style="border-radius:18px;">
                            <div class="card-body p-4">
                                <ul class="nav nav-pills mb-4" role="tablist" style="gap:10px;">
                                    <li class="nav-item">
                                        <a class="nav-link active"
                                            data-toggle="tab"
                                            href="#home1"
                                            style="border-radius:25px;padding:8px 18px;">
                                            <i class="fas fa-info-circle mr-1"></i> Basic Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            data-toggle="tab"
                                            href="#profile1"
                                            style="border-radius:25px;padding:8px 18px;">
                                            <i class="fas fa-book mr-1"></i> My Courses
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            data-toggle="tab"
                                            href="#messages1"
                                            style="border-radius:25px;padding:8px 18px;">
                                            <i class="fas fa-comments mr-1"></i> My Discussion Forum
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            data-toggle="tab"
                                            href="#messages1"
                                            style="border-radius:25px;padding:8px 18px;">
                                            <i class="fas fa-question mr-1"></i> My QNA
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="home1">
                                        <div class="bg-light p-4" style="border-radius:15px;">
                                            <form method="post" id="imeno_form">
                                                <input type="hidden" name="id" id="id" value="<?= $user['id']; ?>">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label font-weight-semibold">
                                                        IMEI No
                                                    </label>
                                                    <div class="col-sm-6">
                                                        <input class="form-control"
                                                            type="text"
                                                            id="imei_no"
                                                            name="imei_no"
                                                            value="<?= $user['imei_no']; ?>">
                                                    </div>
                                                </div>
                                                <?php if ($user['role'] != 3) { ?>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label font-weight-semibold">
                                                            Commission %
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control"
                                                                type="text"
                                                                id="commsion_percentage"
                                                                name="commsion_percentage"
                                                                value="<?= $user['commsion_percentage']; ?>">
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="mt-3">
                                                    <button type="button"
                                                        class="btn btn-sm btn-success mr-2"
                                                        onclick="actionUsers(1)">
                                                        <i class="fas fa-check mr-1"></i> Update
                                                    </button>

                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="actionUsers(2)">
                                                        <i class="fas fa-trash mr-1"></i> Delete IMEI
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="profile1">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="font-weight-bold mb-0">Assigned Courses</h6>
                                            <a href="javascript:void(0);"
                                                title="Assign Course"
                                                class="btn btn-primary btn-sm openAssignModal"
                                                data-id="<?= $user['id'] ?>"
                                                style="border-radius:20px;padding:6px 16px;">
                                                <i class="fas fa-plus mr-1"></i> Assign Course
                                            </a>
                                        </div>
                                        <div class="modal fade" id="assignCourseModal" tabindex="-1">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content" style="border-radius:15px;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Assign Course</h5>
                                                        <button type="button"
                                                            class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body" id="assignCourseModalBody">
                                                        <div class="text-center py-4">
                                                            <i class="fas fa-spinner fa-spin"></i> Loading...
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-white p-3 rounded shadow-sm">
                                            <?php $this->load->view(ADMIN . USER . 'table-mycourse'); ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="messages1">
                                        <div class="bg-white p-3 rounded shadow-sm">
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#lesson" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">Lesson Video MCQ Solved</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active p-3" id="lesson" role="tabpanel">
                                        <table id="user_video_mcq_datatable" class="table table-striped dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
</div>



<!-- content -->
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/custom-js/user.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/student.js"></script>