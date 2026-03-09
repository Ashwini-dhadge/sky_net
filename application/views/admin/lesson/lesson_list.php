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
                    <select id="filter_course" class="form-control select2">
                      <option value="">All Courses</option>
                      <?php foreach ($course as $c) { ?>
                        <option value="<?= $c['id']; ?>"><?= $c['title']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <select id="filter_section" class="form-control select2">
                      <option value="">All Sections</option>
                    </select>
                  </div>

                  <div class="col-md-4 text-right">
                    <button class="btn btn-info" onclick="openMcqLessonModal()">
                      <i class="fa fa-upload"></i> Upload MCQ
                    </button>

                    <a href="<?= base_url(ADMIN . 'Lesson/AddLesson'); ?>" class="btn btn-primary waves-effect waves-light">
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
          <div class="modal-dialog modal-xl modal-dialog-scrollable">
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
                  <div class="col-md-5">
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

                  <div class="col-md-7 border-left">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <div>
                        <label class="font-weight-bold d-block mb-1">Sample Template</label>
                        <small class="text-muted">Download Excel template for selected lesson</small>
                      </div>
                      <button class="btn btn-primary btn-sm" id="downloadTemplateBtn" disabled>
                        <i class="fa fa-file-excel"></i> Download Template
                      </button>
                    </div>

                    <hr>

                    <form method="post" enctype="multipart/form-data" id="uploadMcqForm">
                      <input type="hidden" name="lesson_id" id="upload_lesson_id">

                      <div class="form-group">
                        <label class="font-weight-bold">Upload MCQ Excel</label>
                        <input type="file" name="mcq_file" class="form-control" accept=".xlsx" required>
                      </div>

                      <div class="progress mt-3" id="uploadProgressWrapper" style="display:none;height:22px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" id="uploadProgressBar" role="progressbar" style="width:0%">0%</div>
                      </div>

                      <button type="submit" class="btn btn-success mt-3" id="previewBtn">
                        <i class="fa fa-upload"></i> Upload & Preview
                      </button>
                    </form>
                  </div>
                  <div class="col-md-12">
                    <hr>

                    <div id="importSummary" style="display:none;"></div>

                    <div id="mcqPreviewSection" style="display:none;">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Preview MCQs</h5>
                        <button type="button" class="btn btn-danger btn-sm" id="downloadErrorExcelBtn" style="display:none;">
                          <i class="fa fa-download"></i> Download Error Excel
                        </button>
                      </div>

                      <div class="table-responsive" style="max-height:450px; overflow:auto;">
                        <table class="table table-bordered table-hover table-sm">
                          <thead class="thead-light">
                            <tr>
                              <th style="min-width:60px;">#</th>
                              <th style="min-width:280px;">Question</th>
                              <th style="min-width:150px;">A</th>
                              <th style="min-width:150px;">B</th>
                              <th style="min-width:150px;">C</th>
                              <th style="min-width:150px;">D</th>
                              <th style="min-width:120px;">Correct</th>
                              <th style="min-width:220px;">Status</th>
                            </tr>
                          </thead>
                          <tbody id="mcqPreviewTable"></tbody>
                        </table>
                      </div>

                      <div class="text-right mt-3">
                        <button type="button" class="btn btn-secondary" id="cancelPreviewBtn">Cancel</button>
                        <button type="button" class="btn btn-success" id="revalidateBtn">Revalidate</button>
                        <button type="button" class="btn btn-primary" id="confirmUploadBtn">Confirm Upload</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal-footer bg-light">
                <small class="text-muted mr-auto">
                  Supported format: .xlsx | Columns A–F | Supports large imports
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

<script>
  let mcqPreviewData = [];

  function openMcqLessonModal() {
    $('#mcqLessonModal').modal('show');
  }

  function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    return $('<div>').text(text).html();
  }

  function renderSummary(summary) {
    const html = `
			<div class="alert alert-success mb-3">
				<strong>Total Rows:</strong> ${summary.total} &nbsp; | &nbsp;
				<strong>Valid:</strong> ${summary.valid} &nbsp; | &nbsp;
				<strong>Invalid:</strong> ${summary.invalid}
			</div>
		`;
    $('#importSummary').html(html).show();
  }

  function validateRows(rows) {
    let hasError = false;
    let html = '';
    let total = rows.length;
    let valid = 0;
    let invalid = 0;
    let duplicateCheck = {};

    rows.forEach(function(row, index) {
      row.question = $.trim(row.question || '');
      row.option_a = $.trim(row.option_a || '');
      row.option_b = $.trim(row.option_b || '');
      row.option_c = $.trim(row.option_c || '');
      row.option_d = $.trim(row.option_d || '');
      row.correct_option = $.trim((row.correct_option || '').toUpperCase());

      let errors = [];

      if (row.question === '') errors.push('Question required');
      if (row.option_a === '' || row.option_b === '' || row.option_c === '' || row.option_d === '') {
        errors.push('All 4 options required');
      }
      if (['A', 'B', 'C', 'D'].indexOf(row.correct_option) === -1) {
        errors.push('Correct option must be A,B,C or D');
      }

      let qKey = row.question.toLowerCase().replace(/\s+/g, ' ').trim();
      if (qKey !== '') {
        if (duplicateCheck[qKey]) {
          errors.push('Duplicate question in preview');
        } else {
          duplicateCheck[qKey] = true;
        }
      }

      row.errors = errors;

      if (errors.length > 0) {
        hasError = true;
        invalid++;
      } else {
        valid++;
      }

      let badge = errors.length ? 'danger' : 'success';
      let status = errors.length ? errors.join(', ') : 'Valid';

      html += `
				<tr class="${errors.length ? 'table-danger' : ''}" data-index="${index}">
					<td>${row.row}</td>
					<td><textarea class="form-control edit-question" rows="3">${escapeHtml(row.question)}</textarea></td>
					<td><input type="text" class="form-control edit-a" value="${escapeHtml(row.option_a)}"></td>
					<td><input type="text" class="form-control edit-b" value="${escapeHtml(row.option_b)}"></td>
					<td><input type="text" class="form-control edit-c" value="${escapeHtml(row.option_c)}"></td>
					<td><input type="text" class="form-control edit-d" value="${escapeHtml(row.option_d)}"></td>
					<td>
						<select class="form-control edit-correct">
							<option value="">Select</option>
							<option value="A" ${row.correct_option === 'A' ? 'selected' : ''}>A</option>
							<option value="B" ${row.correct_option === 'B' ? 'selected' : ''}>B</option>
							<option value="C" ${row.correct_option === 'C' ? 'selected' : ''}>C</option>
							<option value="D" ${row.correct_option === 'D' ? 'selected' : ''}>D</option>
						</select>
					</td>
					<td><span class="badge badge-${badge}">${status}</span></td>
				</tr>
			`;
    });

    $('#mcqPreviewTable').html(html);
    $('#mcqPreviewSection').show();
    renderSummary({
      total: total,
      valid: valid,
      invalid: invalid
    });

    if (invalid > 0) {
      $('#downloadErrorExcelBtn').show();
      $('#confirmUploadBtn')
        .prop('disabled', true)
        .removeClass('btn-primary btn-success')
        .addClass('btn-secondary')
        .text('Fix Errors Before Upload');
    } else {
      $('#downloadErrorExcelBtn').hide();
      $('#confirmUploadBtn')
        .prop('disabled', false)
        .removeClass('btn-secondary')
        .addClass('btn-primary')
        .text('Confirm Upload');
    }

    mcqPreviewData = rows;
  }

  function collectEditedRows() {
    let rows = [];

    $('#mcqPreviewTable tr').each(function() {
      let index = $(this).data('index');
      let original = mcqPreviewData[index];

      rows.push({
        row: original.row,
        lesson_id: original.lesson_id,
        question: $(this).find('.edit-question').val(),
        option_a: $(this).find('.edit-a').val(),
        option_b: $(this).find('.edit-b').val(),
        option_c: $(this).find('.edit-c').val(),
        option_d: $(this).find('.edit-d').val(),
        correct_option: $(this).find('.edit-correct').val(),
        errors: []
      });
    });

    return rows;
  }

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
          res.data.forEach(function(s) {
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
          res.data.forEach(function(l) {
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
  });

  $('#downloadTemplateBtn').on('click', function() {
    const lessonId = $('#mcq_lesson_id').val();
    if (!lessonId) return;

    window.location.href = "<?= base_url(ADMIN . 'Lesson/downloadMcqXlsxTemplate/'); ?>" + lessonId;
  });

  $('#uploadMcqForm').on('submit', function(e) {
    e.preventDefault();

    let lessonId = $('#upload_lesson_id').val();

    if (!lessonId) {
      alert('Please select lesson');
      return;
    }

    let formData = new FormData(this);
    formData.append('lesson_id', lessonId);

    $('#uploadProgressWrapper').show();
    $('#uploadProgressBar')
      .removeClass('bg-success bg-danger')
      .addClass('progress-bar-animated progress-bar-striped')
      .css('width', '0%')
      .text('0%');

    $('#mcqPreviewSection').hide();
    $('#importSummary').hide();

    $.ajax({
      url: "<?= base_url(ADMIN . 'Lesson/previewMcqXlsx'); ?>",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      xhr: function() {
        let xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(evt) {
          if (evt.lengthComputable) {
            let percent = Math.round((evt.loaded / evt.total) * 100);
            $('#uploadProgressBar')
              .css('width', percent + '%')
              .text(percent + '%');
          }
        }, false);
        return xhr;
      },
      success: function(res) {
        let data = typeof res === 'object' ? res : JSON.parse(res);

        if (!data.status) {
          $('#uploadProgressBar')
            .removeClass('progress-bar-animated')
            .addClass('bg-danger')
            .text(data.msg || 'Upload failed');
          alert(data.msg || 'Upload failed');
          return;
        }

        $('#uploadProgressBar')
          .removeClass('progress-bar-animated')
          .addClass('bg-success')
          .css('width', '100%')
          .text('Upload Complete');

        mcqPreviewData = data.data || [];
        renderSummary(data.summary || {
          total: 0,
          valid: 0,
          invalid: 0
        });
        validateRows(mcqPreviewData);
      },
      error: function() {
        $('#uploadProgressBar')
          .removeClass('progress-bar-animated')
          .addClass('bg-danger')
          .text('Request failed');
        alert('Something went wrong while previewing the Excel file.');
      }
    });
  });

  $('#revalidateBtn').on('click', function() {
    let editedRows = collectEditedRows();
    validateRows(editedRows);
  });

  $('#cancelPreviewBtn').on('click', function() {
    $('#mcqPreviewSection').hide();
    $('#mcqPreviewTable').html('');
    $('#importSummary').hide();
    mcqPreviewData = [];
    $('#downloadErrorExcelBtn').hide();
  });

  $('#downloadErrorExcelBtn').on('click', function() {
    let editedRows = collectEditedRows();
    let errorRows = [];

    editedRows.forEach(function(row) {
      let errors = [];
      if ($.trim(row.question) === '') errors.push('Question required');
      if ($.trim(row.option_a) === '' || $.trim(row.option_b) === '' || $.trim(row.option_c) === '' || $.trim(row.option_d) === '') {
        errors.push('All 4 options required');
      }
      if (['A', 'B', 'C', 'D'].indexOf($.trim((row.correct_option || '').toUpperCase())) === -1) {
        errors.push('Correct option must be A,B,C or D');
      }
      row.errors = errors;
      if (errors.length > 0) {
        errorRows.push(row);
      }
    });

    if (errorRows.length === 0) {
      alert('No error rows found');
      return;
    }

    let form = $('<form>', {
      method: 'POST',
      action: "<?= base_url(ADMIN . 'Lesson/downloadErrorExcel'); ?>"
    });

    form.append($('<input>', {
      type: 'hidden',
      name: 'rows',
      value: JSON.stringify(errorRows)
    }));

    $('body').append(form);
    form.submit();
    form.remove();
  });

  $('#confirmUploadBtn').on('click', function() {
    let rows = collectEditedRows();

    let hasError = false;
    rows.forEach(function(row) {
      if (
        $.trim(row.question) === '' ||
        $.trim(row.option_a) === '' ||
        $.trim(row.option_b) === '' ||
        $.trim(row.option_c) === '' ||
        $.trim(row.option_d) === '' || ['A', 'B', 'C', 'D'].indexOf($.trim((row.correct_option || '').toUpperCase())) === -1
      ) {
        hasError = true;
      }
    });

    if (hasError) {
      alert('Please fix validation errors before upload.');
      validateRows(rows);
      return;
    }

    $('#confirmUploadBtn').prop('disabled', true).text('Uploading...');

    $.ajax({
      url: "<?= base_url(ADMIN . 'Lesson/saveMcqBulk'); ?>",
      type: "POST",
      dataType: "json",
      data: {
        rows: JSON.stringify(rows)
      },
      success: function(res) {
        if (res.status) {
          alert(res.msg + ' Inserted: ' + res.inserted);
          location.reload();
        } else {
          alert(res.msg || 'Upload failed');
          $('#confirmUploadBtn').prop('disabled', false).text('Confirm Upload');
        }
      },
      error: function() {
        alert('Something went wrong while saving MCQs.');
        $('#confirmUploadBtn').prop('disabled', false).text('Confirm Upload');
      }
    });
  });
</script>

<script src="<?= base_url(); ?>assets/js/custom-js/lesson.js"></script>