<?php init_header(); ?>

<div class="main-content">
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

  <?php init_footer(); ?>
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