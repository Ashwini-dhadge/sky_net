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
                                        <h4><u>Notes</u></h4>
                                        <p><?= $course['notes']; ?></p>
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
                                            <div class="modal fade" id="videoModal" tabindex="-1">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header ">
                                                            <h5 class="modal-title">Add Video</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                &times;
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="lessonForm" enctype="multipart/form-data">
                                                                <input type="hidden" name="course_id" id="course_id" value="<?= $course['id']; ?>">
                                                                <input type="hidden" name="section_id" id="section_id">
                                                                <input type="hidden" name="lesson_id" id="lesson_id">
                                                                <div class="row" style="display:none;">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group mb-3">
                                                                            <select class="form-control select2" id="section">
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div id="video-repeater">
                                                                    <div data-repeater-list="videos">
                                                                        <div data-repeater-item class="video-card mb-3 p-3 template"
                                                                            style="display:none; border-bottom: 1px dashed #c0c0c0;">

                                                                            <div class="d-flex justify-content-between mb-2">
                                                                                <h6 class="video-card-title mb-0">Video Details</h6>
                                                                                <button data-repeater-delete type="button"
                                                                                    class="btn btn-sm btn-outline-danger">✕</button>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-3 text-center">
                                                                                    <div class="thumb-box border p-2">
                                                                                        <img class="video-thumb-preview w-100"
                                                                                            style="height:150px; object-fit:contain; display:none;">
                                                                                    </div>
                                                                                    <input type="file" accept="image/*" name="video_thumbnail"
                                                                                        class="video-thumb-input form-control mt-2">
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <div class="form-group">
                                                                                        <label>Video Title</label>
                                                                                        <input type="text" name="video_title" class="form-control" required>
                                                                                    </div>
                                                                                    <div class="form-row">
                                                                                        <div class="form-group col-md-7">
                                                                                            <label>Vimeo Code</label>
                                                                                            <input type="text" name="vimo_code" class="form-control">
                                                                                        </div>
                                                                                        <div class="form-group col-md-5">
                                                                                            <label>Type</label>
                                                                                            <select name="video_type" class="form-control">
                                                                                                <option value="thoratical">Theoretical</option>
                                                                                                <option value="practical">Practical</option>
                                                                                                <option value="both">Both</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <button data-repeater-create type="button" class="btn btn-success mt-3">+ Add Video</button>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                                                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="qnaTab">
                                        <div class="card shadow-sm">
                                            <div class="card-body">

                                                <h5 class="mb-3">Questions & Answers</h5>

                                                <input type="hidden" id="course_id" value="<?= $course['id']; ?>">

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

                                                    <button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#resourceModal">
                                                        <i class="fas fa-plus mr-1"></i> Add Resource
                                                    </button>
                                                </div>

                                                <table id="resourceTable"
                                                    class="table table-bordered table-striped dt-responsive w-100">
                                                </table>

                                            </div>
                                        </div>
                                        <div class="modal fade" id="resourceModal">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Answer Question</h5>
                                                        <button class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                                                        <form action="<?= base_url(ADMIN . 'Course/updateResources/' . $course['id']) ?>"
                                                            method="POST"
                                                            enctype="multipart/form-data">

                                                            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">

                                                            <div class="resource-repeater">

                                                                <div data-repeater-list="resources">

                                                                    <div data-repeater-item class="card mb-3">
                                                                        <div class="card-body">
                                                                            <div class="row">

                                                                                <div class="col-md-5">
                                                                                    <label>File Title</label>
                                                                                    <input type="text"
                                                                                        name="file_notes"
                                                                                        class="form-control"
                                                                                        required>
                                                                                </div>

                                                                                <div class="col-md-5">
                                                                                    <label>File</label>
                                                                                    <input type="file"
                                                                                        name="file"
                                                                                        class="form-control"
                                                                                        onchange="updatePreviewButton(this)">

                                                                                </div>

                                                                                <div class="col-md-2">
                                                                                    <label>&nbsp;</label><br>

                                                                                    <button type="button"
                                                                                        class="btn btn-secondary preview-btn"
                                                                                        onclick="previewFile(this)">
                                                                                        <i class="fas fa-eye"></i>
                                                                                    </button>

                                                                                    <button data-repeater-delete
                                                                                        type="button"
                                                                                        class="btn btn-danger ml-1">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </button>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <button data-repeater-create
                                                                    type="button"
                                                                    class="btn btn-success mt-2">
                                                                    <i class="fas fa-plus"></i> Add Resource
                                                                </button>

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fas fa-save mr-1"></i> Save Resources
                                                                </button>
                                                            </div>

                                                        </form>

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
    </div>
</div>

<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/custom-js/course.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/lesson-list.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/section-list.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/course-qna.js"></script>
<script src="<?= base_url(); ?>assets/js/custom-js/course-resource.js"></script>
<script src="<?= base_url() ?>assets/plugins/jquery-repeater/jquery.repeater.min.js"></script>
<script>
    $(document).on('change', '.video-thumb-input', function() {
        const input = this;
        const preview = $(this).closest('.col-md-3').find('.video-thumb-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result).show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    });


    $('#video-repeater').repeater({
        initEmpty: <?= empty($lesson_videos) ? 'true' : 'false' ?>,

        show: function() {
            $(this).find('.video-thumb-preview')
                .attr('src', '')
                .hide();

            $(this).find('.video-thumb-input').val('');

            $(this).find('input[name="id"]').remove();
            $(this).find('input[name="old_thumbnail"]').remove();

            $(this).slideDown();
        },

        hide: function(deleteElement) {
            if (confirm('Are you sure you want to remove this video?')) {
                $(this).slideUp(deleteElement);
            }
        }
    });
</script>

<script>
    $(document).ready(function() {

        $('.resource-repeater').repeater({
            initEmpty: false,
            show: function() {
                $(this).slideDown();
            },
            hide: function(deleteElement) {
                if (confirm('Remove this resource?')) {
                    $(this).slideUp(deleteElement);
                }
            }
        });

        function updatePreviewButton(input) {
            const row = input.closest('[data-repeater-item]');
            const btn = row.querySelector('.preview-btn');

            if (input.files.length) {
                btn.className = 'btn btn-info preview-btn';
            }
        }

        function previewFile(btn) {
            const file = btn.closest('[data-repeater-item]')
                .querySelector('input[type=file]').files[0];

            if (!file) return alert('Select file');

            window.open(URL.createObjectURL(file));
        }


    });
</script>
<script>
    function updatePreviewButton(input) {
        const row = input.closest('[data-repeater-item]');
        const btn = row.querySelector('.preview-btn');
        if (!input.files.length) return;
        btn.className = 'btn btn-info preview-btn';
    }

    function previewFile(btn) {
        const file = btn.closest('[data-repeater-item]')
            .querySelector('input[type=file]').files[0];
        if (!file) return alert('Select file');
        window.open(URL.createObjectURL(file));
    }
</script>