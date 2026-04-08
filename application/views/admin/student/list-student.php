<?php init_header(); ?>

<div class="main-content">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card  mb-4 mt-4">
                            <div class="card-body">

                                <a href="<?= base_url(ADMIN . 'Student/add_student'); ?>" class="btn btn-primary waves-effect waves-light float-right">Add Student</a>
                                <h4 class="card-title"><?= $title ?></h4>
                                <select id="student_type_filter" class="form-control" style="width:20%;">
                                    <option value="">All Students</option>
                                    <option value="1">Online Students</option>
                                    <option value="0">Offline Students</option>
                                </select>
                                <?php $this->load->view(ADMIN . STUDENT . 'table-student'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="assignCourseModal" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Assign Course</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" style="padding: 10px;" id="assignCourseModalBody">
                                <div class="text-center">
                                    <i class="fas fa-spinner fa-spin"></i> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="certificateModal" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Certification</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" style="padding: 10px;" id="certificateModalBody">
                                <div class="text-center">
                                    <i class="fas fa-spinner fa-spin"></i> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/custom-js/student.js"></script>