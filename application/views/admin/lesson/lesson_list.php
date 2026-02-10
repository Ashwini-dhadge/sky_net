<?php init_header(); ?>

<div class="main-content mb-5">
  <div class="content-page">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card mt-4">
              <div class="card-body">
                <h4 class="card-title"><?= $title ?></h4>
                <div class="row">
                  <div class="col-md-4">
                    <!-- <label>Filter Course</label> -->
                    <select id="filter_course" class="form-control select2">
                      <option value="">All Courses</option>
                      <?php foreach ($course as $c) { ?>
                        <option value="<?= $c['id']; ?>"><?= $c['title']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <!-- <label>Filter Section</label> -->
                    <select id="filter_section" class="form-control select2">
                      <option value="">All Sections</option>
                    </select>
                  </div>
                  <div class="col-md-4 text-right">
                    <button class="btn btn-info"
                      onclick="openMcqLessonModal('upload')">
                      <i class="fa fa-upload"></i> Upload MCQ
                    </button>
                    <a href="<?= base_url(ADMIN . 'Lesson/AddLesson'); ?>"
                      class="btn btn-primary waves-effect waves-light">
                      Add Lesson
                    </a>
                  </div>
                </div>
                <?php $this->load->view(ADMIN . LESSON . 'table_lesson'); ?>
              </div>
            </div>
          </div>
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
                  <input type="hidden" name="course_id" id="course_id">
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


        <div class="modal fade" id="mcqLessonModal" tabindex="-1">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">

              <div class="modal-header bg-light">
                <h5 class="modal-title">
                  <i class="fa fa-question-circle text-primary"></i>
                  Upload MCQs for Lesson
                </h5>
                <button class="close" data-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body">
                <div class="row">

                  <div class="col-md-6">

                    <div class="form-group">
                      <label>Select Course</label>
                      <select id="mcq_course_id" class="form-control select2" style="width:100%;">
                        <option value="">-- Select Course --</option>
                        <?php foreach ($course as $c) { ?>
                          <option value="<?= $c['id']; ?>"><?= $c['title']; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Select Section</label>
                      <select id="mcq_section_id" class="form-control select2" style="width:100%;">
                        <option value="">-- Select Section --</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Select Lesson</label>
                      <select id="mcq_lesson_id" class="form-control select2" style="width:100%;">
                        <option value="">-- Select Lesson --</option>
                      </select>
                    </div>

                  </div>

                  <div class="col-md-6 border-left">

                    <div class="mb-3">
                      <label class="font-weight-bold">Sample Template</label>
                      <p class="text-muted small mb-2">
                        Download Excel template for selected lesson
                      </p>
                      <button class="btn btn-primary btn-sm"
                        id="downloadTemplateBtn"
                        disabled>
                        <i class="fa fa-file-excel"></i> Download Template
                      </button>
                    </div>

                    <hr>

                    <form method="post"
                      enctype="multipart/form-data"
                      id="uploadMcqForm">

                      <input type="hidden" name="lesson_id" id="upload_lesson_id">

                      <div class="form-group">
                        <label class="font-weight-bold">Upload MCQ Excel</label>
                        <input type="file"
                          name="mcq_file"
                          class="form-control"
                          accept=".xlsx"
                          required>
                      </div>

                      <button class="btn btn-success mt-2">
                        <i class="fa fa-upload"></i> Upload MCQs
                      </button>

                    </form>

                  </div>
                </div>
              </div>

              <div class="modal-footer bg-light">
                <small class="text-muted mr-auto">
                  Supported format: .xlsx | Columns A–F
                </small>
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
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
  $('#mcq_course_id').on('change', function() {
    const courseId = $(this).val();

    $('#mcq_section_id').html('<option value="">Loading...</option>');
    $('#mcq_lesson_id').html('<option value="">-- Select Lesson --</option>');
    $('#downloadTemplateBtn').prop('disabled', true);

    if (!courseId) {
      $('#mcq_section_id').html('<option value="">-- Select Section --</option>');
      return;
    }

    $.post(
      "<?= base_url(ADMIN . 'Lesson/getSectionsByCourse'); ?>", {
        course_id: courseId
      },
      function(res) {
        let html = '<option value="">-- Select Section --</option>';
        if (res.status) {
          res.data.forEach(s => {
            html += `<option value="${s.id}">${s.title}</option>`;
          });
        }
        $('#mcq_section_id').html(html);
      },
      'json'
    );
  });

  $('#mcq_section_id').on('change', function() {
    const sectionId = $(this).val();

    $('#mcq_lesson_id').html('<option value="">Loading...</option>');
    $('#downloadTemplateBtn').prop('disabled', true);

    if (!sectionId) {
      $('#mcq_lesson_id').html('<option value="">-- Select Lesson --</option>');
      return;
    }

    $.post(
      "<?= base_url(ADMIN . 'Lesson/getLessonsBySection'); ?>", {
        section_id: sectionId
      },
      function(res) {
        let html = '<option value="">-- Select Lesson --</option>';
        if (res.status) {
          res.data.forEach(l => {
            html += `<option value="${l.id}">${l.title}</option>`;
          });
        }
        $('#mcq_lesson_id').html(html);
      },
      'json'
    );
  });

  $('#mcq_lesson_id').on('change', function() {
    const lessonId = $(this).val();

    if (!lessonId) {
      $('#downloadTemplateBtn').prop('disabled', true);
      return;
    }

    $('#downloadTemplateBtn').prop('disabled', false);

    $('#upload_lesson_id').val(lessonId);
    $('#uploadMcqForm').attr(
      'action',
      "<?= base_url(ADMIN . 'Lesson/uploadMcqXlsx/'); ?>" + lessonId
    );
  });

  $('#downloadTemplateBtn').on('click', function() {
    const lessonId = $('#mcq_lesson_id').val();
    if (!lessonId) return;

    window.location.href =
      "<?= base_url(ADMIN . 'Lesson/downloadMcqXlsxTemplate/'); ?>" + lessonId;
  });

  function openMcqLessonModal() {
    $('#mcqLessonModal').modal('show');
  }
</script>
<script src="<?= base_url(); ?>assets/js/custom-js/lesson.js"></script>