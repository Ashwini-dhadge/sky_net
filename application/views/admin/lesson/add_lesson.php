<?php init_header(); ?>
<?php if (isset($lesson)) {
    $lesson = $lesson[0];
} ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.css"
    rel="stylesheet">

<style>
    .video-card {
        border: 1px solid #e1e1e1;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: .2s;
    }

    .video-card:hover {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .video-card-title {
        font-weight: 600;
        color: #444;
    }

    .thumb-box {
        border-radius: 6px;
        background: #f7f7f7;
    }

    .btn-outline-danger {
        border-radius: 50%;
        line-height: 1;
    }

    .cke_notification {
        display: none;
    }
</style>

<div class="main-content">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">

                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <div class="float-right d-none d-md-block">
                                <button type="button" class="btn btn-secondary"
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
                                <form class="repeater" action="<?= base_url(ADMIN . 'Lesson/storelesson'); ?>"
                                    method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= isset($lesson) ? $lesson['id'] : ''; ?>">
                                    <div class="row">
                                        <div class="col-lg-4 col-12" style="border-right:1px dashed gray;">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label>Select Course</label>
                                                    <select class="form-control select2" name="course_id" required>
                                                        <option value="">Select Course</option>
                                                        <?php foreach ($course as $c) { ?>
                                                            <option value="<?= $c['id'] ?>"
                                                                <?php
                                                                if (isset($lesson) && $lesson['course_id'] == $c['id']) {
                                                                    echo "selected";
                                                                } elseif (isset($selected_course_id) && $selected_course_id == $c['id']) {
                                                                    echo "selected";
                                                                }
                                                                ?>>
                                                                <?= $c['title']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Select Section</label>
                                                    <select class="form-control select2" name="section_id" required>
                                                        <option value="">Select Section</option>
                                                        <?php foreach ($section as $s) { ?>
                                                            <option value="<?= $s['id'] ?>"
                                                                <?= (isset($lesson) && $lesson['section_id'] == $s['id']) ? 'selected' : '' ?>>
                                                                <?= $s['title']; ?>
                                                            </option>
                                                        <?php } ?>

                                                    </select>

                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Add Title</label>
                                                    <input class="form-control" type="text" name="tags" id="tags"
                                                        value="<?= isset($lesson) ? $lesson['title'] : ''; ?>"
                                                        placeholder="Enter title">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Sequence</label>
                                                    <input type="number" min="1" name="sequence"
                                                        value="<?= isset($lesson) ? $lesson['sequence'] : 1; ?>"
                                                        class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Select Tags</label>
                                                    <select class="custom-select" id="tags_input" name="tags_input[]"
                                                        multiple>
                                                        <?php if (!empty($lesson_tags)) {
                                                            foreach ($lesson_tags as $t) { ?>
                                                                <option value="<?= trim($t['sub_title_name']) ?>" selected>
                                                                    <?= trim($t['sub_title_name']) ?>
                                                                </option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-12">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label>Description</label>
                                                    <textarea class="form-control" name="description"
                                                        id="benefits"><?= isset($lesson) ? $lesson['description'] : ''; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="border:1px dashed gray;">
                                    <h5 class="mt-4 mb-3">Lesson Videos</h5>
                                    <div id="video-repeater">
                                        <div data-repeater-list="videos">
                                            <?php if (!empty($lesson_videos)) {
                                                foreach ($lesson_videos as $vid) { ?>
                                                    <div data-repeater-item class="video-card mb-3 p-3">
                                                        <div class="d-flex justify-content-between mb-2">
                                                            <h6 class="video-card-title mb-0">Video Details</h6>
                                                            <button data-repeater-delete type="button"
                                                                class="btn btn-sm btn-outline-danger">✕</button>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3 text-center">
                                                                <div class="thumb-box border p-2">
                                                                    <?php if ($vid['video_thumbnail']) { ?>
                                                                        <img class="video-thumb-preview w-100"
                                                                            src="<?= base_url('assets/uploads/thumbnails/video_thumbnails/' . $vid['video_thumbnail']); ?>"
                                                                            style="height:150px; object-fit:contain;">
                                                                    <?php } else { ?>
                                                                        <img class="video-thumb-preview w-100"
                                                                            style="height:150px; object-fit:contain; display:none;">
                                                                    <?php } ?>
                                                                </div>
                                                                <input type="file" accept="image/*" name="video_thumbnail"
                                                                    class="video-thumb-input form-control mt-2">
                                                                <input type="hidden" name="id" value="<?= $vid['id']; ?>">
                                                                <input type="hidden" name="old_thumbnail"
                                                                    value="<?= $vid['video_thumbnail']; ?>">
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <label>Video Title</label>
                                                                    <input type="text" name="video_title" class="form-control"
                                                                        value="<?= $vid['video_title']; ?>" required>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-7">
                                                                        <label>Vimeo Code</label>
                                                                        <input type="text" name="vimo_code" class="form-control"
                                                                            value="<?= $vid['vimo_code']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-5">
                                                                        <label>Type</label>
                                                                        <select name="video_type" class="form-control">
                                                                            <option value="thoratical"
                                                                                <?= ($vid['video_type'] == "thoratical") ? "selected" : "" ?>>Theoretical</option>
                                                                            <option value="practical"
                                                                                <?= ($vid['video_type'] == "practical") ? "selected" : "" ?>>Practical</option>
                                                                            <option value="both"
                                                                                <?= ($vid['video_type'] == "both") ? "selected" : "" ?>>Both</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php }
                                            } ?>
                                            <div data-repeater-item class="video-card mb-3 p-3 template"
                                                style="display:none;">

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
                                                            <input type="text" name="video_title" class="form-control">
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
                                        <button data-repeater-create type="button" class="btn btn-success mt-3">+ Add
                                            Another Video</button>
                                    </div>
                                    <div class="form-group col-md-12 text-right mt-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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

<?php init_footer(); ?>

<script src="<?= base_url(); ?>assets/plugins/jquery-repeater/jquery.repeater.min.js"></script>

<script src="https://cdn.ckeditor.com/4.15.0/full-all/ckeditor.js"></script>
<script>
    CKEDITOR.replace('benefits', {
        height: '170px'
    });
</script>

<script>
    $("#tags_input").select2({
        tags: true,
        tokenSeparators: [','],
        placeholder: "Type and press Enter to add tag",
        width: '100%'
    });

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

        const courseSelect = $('select[name="course_id"]');
        const sectionSelect = $('select[name="section_id"]');

        // Grab selected section from edit mode
        let selectedSection = sectionSelect.val();

        function loadSections(course_id, selected = null) {
            sectionSelect.html('<option value="">Loading...</option>').trigger('change');

            $.ajax({
                url: base_url + _admin + 'Lesson/getSectionsByCourse',
                type: 'POST',
                data: {
                    course_id: course_id
                },
                success: function(res) {

                    let response = JSON.parse(res);

                    if (!response.status) {
                        sectionSelect.html('<option value="">Select Section</option>');
                        return;
                    }

                    let options = '<option value="">Select Section</option>';

                    response.data.forEach(function(sec) {

                        let isSelected = (selected && selected == sec.id) ?
                            'selected' :
                            '';

                        options += `<option value="${sec.id}" ${isSelected}>${sec.title}</option>`;
                    });

                    sectionSelect.html(options).trigger('change');
                }
            });
        }

        courseSelect.on('change', function() {
            let course_id = $(this).val();

            if (!course_id) {
                sectionSelect.html('<option value="">Select Section</option>').trigger('change');
                return;
            }

            loadSections(course_id);
        });


        let existingCourse = courseSelect.val();

        if (existingCourse && selectedSection) {
            loadSections(existingCourse, selectedSection);
        }

    });
</script>