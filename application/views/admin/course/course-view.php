<?php init_header(); ?>
<style>
._status {
    cursor: pointer;
}

.btn-sm {
    margin: 0px 2px;
}
</style>

<div class="main-content">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">

                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title"><?= $title ?></h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-right d-none d-md-block">
                                <button type="button" class="btn btn-secondary mb-0"
                                    onclick="window.history.back()">Back</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">
                                    <?= $course['title']; ?> Details
                                    <span class="d-print-none">
                                        <a href="<?= base_url(ADMIN . 'Course/Course/' . $course['id']); ?>"
                                            class="btn btn-primary btn-sm float-right">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </span>
                                </h4>
                                <hr>

                                <div class="row">
                                    <div class="col-lg-5">
                                        <?php $img = ($course['image']) ? $course['image'] : 'no-image.png'; ?>
                                        <img src="<?= base_url(COURSE_IMAGES . $img); ?>" width="80%" alt="">
                                    </div>
                                    <div class="col-lg-7">
                                        <h4 class="header-title mb-3">Course Basic</h4>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th class="p-1">Category</th>
                                                    <td class="p-1"><?= $course['category_name']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="p-1">Title</th>
                                                    <td class="p-1"><?= $course['title']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="p-1">Course Type</th>
                                                    <td class="p-1">
                                                        <?= ($course['course_type'] == 1)
                                                            ? '<span class="badge badge-info">Online</span>'
                                                            : '<span class="badge badge-warning">Offline</span>'; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="p-1">Language</th>
                                                    <td class="p-1">
                                                        <?= ($course['language'] == 1) ? 'English' : 'Marathi'; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="p-1">Skill</th>
                                                    <td class="p-1"><?= $course['name']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="p-1">Certificate</th>
                                                    <td class="p-1"><?= ($course['certificate'] == 1) ? 'YES' : 'NO'; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="p-1">Assessment</th>
                                                    <td class="p-1"><?= ($course['assessment'] == 1) ? 'YES' : 'NO'; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-12 mt-3" style="overflow-y: overlay;">
                                        <h4><u>Benefits</u></h4>
                                        <p><?= $course['benefits']; ?></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4 mt-4">
                            <div class="card-body">

                                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#durationTab">
                                            Duration
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#sectionTab">
                                            Section
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#lessonTab">
                                            Lesson
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#qnaTab">
                                            Q & A
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#resourceTab">
                                            Resources & Downloads
                                        </a>
                                    </li>
                                </ul>


                                <div class="tab-content mt-3">

                                    <div class="tab-pane fade show active" id="durationTab">
                                        <div class="card shadow-sm">
                                            <div class="card-body">

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="mb-0">Course Duration & Pricing</h5>
                                                </div>

                                                <input type="hidden" id="d_id" value="<?= $course['id']; ?>">

                                                <table id="duration_dataTable"
                                                    class="table table-bordered table-striped dt-responsive w-100">
                                                </table>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="sectionTab">
                                        <div class="card shadow-sm">
                                            <div class="card-body">

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="mb-0">Course Sections</h5>

                                                    <a href="<?= base_url(ADMIN . 'Section/Section?course_id=' . $course['id']); ?>"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-plus mr-1"></i> Add Section
                                                    </a>
                                                </div>

                                                <input type="hidden" id="section_course_id"
                                                    value="<?= $course['id']; ?>">
                                                <input type="hidden" id="section_view_type" value="1">

                                                <table id="Sections_datatable"
                                                    class="table table-bordered table-striped dt-responsive w-100">
                                                </table>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="lessonTab">
                                        <div class="card shadow-sm">
                                            <div class="card-body">

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="mb-0">Lessons</h5>

                                                    <a href="<?= base_url(ADMIN . 'Lesson/addlesson?course_id=' . $course['id']); ?>"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-plus mr-1"></i> Add Lesson
                                                    </a>
                                                </div>

                                                <input type="hidden" id="course_id" value="<?= $course['id']; ?>">
                                                <input type="hidden" id="course_view_type" value="1">

                                                <?php $this->load->view(ADMIN . COURSE . 'table-lesson'); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="qnaTab">
                                        <div class="card shadow-sm">
                                            <div class="card-body">

                                                <h5 class="mb-3">Questions & Answers</h5>

                                                <input type="hidden" id="course_id" value="<?= $course['id']; ?>">

                                                <!-- <div class="row text-center mb-4">
                                                    <div class="col-md-4">
                                                        <div class="card border-0 shadow-sm py-3">
                                                            <h6 class="text-muted">Total Questions</h6>
                                                            <h4 id="qna_total" class="mb-0">0</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="card border-0 shadow-sm py-3">
                                                            <h6 class="text-muted">Answered</h6>
                                                            <h4 id="qna_answered" class="mb-0 text-success">0</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="card border-0 shadow-sm py-3">
                                                            <h6 class="text-muted">Pending</h6>
                                                            <h4 id="qna_pending" class="mb-0 text-warning">0</h4>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <table id="courseQnaTable"
                                                    class="table table-bordered table-striped dt-responsive w-100">
                                                </table>

                                            </div>
                                        </div>

                                        <div class="modal fade" id="answerModal">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Answer Question</h5>
                                                        <button class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="main_instructor_id"
                                                            value="<?= loginId(); ?>">

                                                        <label>Answer by</label>
                                                        <select id="answer_by" class="form-control mb-2">
                                                            <?php foreach ($instructors as $value) { ?>
                                                            <option value="<?= $value['id'] ?>">
                                                                <?= $value['first_name'] . ' ' . $value['last_name'] ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>

                                                        <p id="questionText" class="font-weight-bold"></p>
                                                        <input type="hidden" id="qna_id">

                                                        <textarea id="answerText" class="form-control" rows="5"
                                                            placeholder="Type your answer..."></textarea>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary" onclick="saveAnswer()">
                                                            <i class="fas fa-save mr-1"></i> Save Answer
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="resourceTab">
                                        <div class="card shadow-sm">
                                            <div class="card-body">

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="mb-0">Resources & Downloads</h5>

                                                    <a href="<?= base_url(ADMIN . 'Course/Course/' . $course['id']); ?>"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit mr-1"></i> Edit Course
                                                    </a>
                                                </div>

                                                <table id="resourceTable"
                                                    class="table table-bordered table-striped dt-responsive w-100">
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
    </div> 
</div> 

<?php init_footer(); ?>

<script src="<?= base_url(); ?>assets/js/custom-js/course.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/lesson-list.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/section-list.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/course-qna.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/course-resource.js"></script>
<script>
$(document).ajaxComplete(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>