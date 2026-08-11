<?php init_header(); ?>

<div class="main-content">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <h4 class="mb-3">MCQs – <?= $title ?></h4>
                                    <div class=" d-flex justify-content-between ">
                                        <div class=" mb-3">
                                            <span class="" style="font-size: 12px;">
                                                <b>Course: </b> <?= $lesson['course_name']; ?>
                                            </span> &nbsp;<i class="fa fa-arrow-right text-danger"></i>

                                            <span class=" ml-1" style="font-size: 12px;">
                                                <b>Section: </b><?= $lesson['section_title']; ?>
                                            </span> &nbsp;<i class="fa fa-arrow-right text-danger"></i>

                                            <span class=" ml-1" style="font-size: 12px;">
                                                <b>Lesson: </b><?= $lesson['lesson_title']; ?>
                                            </span>
                                        </div>

                                        <div>
                                            <a href="<?= base_url(ADMIN . 'Lesson/downloadMcqXlsxTemplate/' . $lesson['id']); ?>"
                                                class="btn btn-secondary btn-sm">
                                                <i class="fa fa-file-excel"></i> Sample Template
                                            </a>

                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#uploadCsvModal">
                                                <i class="fa fa-upload"></i> Upload File
                                            </button>

                                            <button class="btn btn-danger btn-sm" onclick="openAddMcqModal()">
                                                <i class="fa fa-plus"></i> Add MCQ
                                            </button>

                                        </div>
                                    </div>
                                </div>



                                <h5 class="card-title mb-3">MCQ List</h5>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th>Question</th>
                                                <th width="15%">Correct Answer</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($mcqs)) { ?>
                                                <?php $i = 1;
                                                foreach ($mcqs as $mcq) { ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= htmlspecialchars($mcq['question']); ?></td>
                                                        <td>
                                                            <span class="badge badge-danger">
                                                                Option <?= $mcq['correct_option']; ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-warning btn-sm"
                                                                onclick='openEditMcqModal(<?= json_encode($mcq, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>)'>
                                                                <i class="fa fa-edit"></i>
                                                            </button>

                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="deleteMcq(<?= $mcq['id']; ?>, <?= $lesson['id']; ?>)">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">
                                                        No MCQs added yet
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <!-- ADD MCQ MODAL -->
                        <div class="modal fade" id="mcqModal" tabindex="-1">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">

                                    <form method="post" action="<?= base_url(ADMIN . 'Lesson/saveMcqBulk'); ?>">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mcqModalTitle">Add MCQs</h5>
                                            <button class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <input type="hidden" name="lesson_id" value="<?= $lesson['id']; ?>">
                                            <input type="hidden" name="mode" id="mcqMode" value="add">

                                            <div id="mcqRepeater"></div>

                                            <button type="button" class="btn btn-danger btn-sm"
                                                id="addMoreMcq">
                                                <i class="fa fa-plus"></i> Add Another MCQ
                                            </button>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-danger">
                                                <i class="fa fa-save"></i> Save
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                        <div id="mcqItemTemplate" class="d-none">
                            <div class="mcq-item border rounded p-3 mb-3">
                                <input type="hidden" name="id[]" value="">

                                <div class="form-group">
                                    <label>Question</label>
                                    <textarea name="question[]" class="form-control" rows="8" required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Option A</label>
                                        <input name="option_a[]" class="form-control option-input" data-option="A"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Option B</label>
                                        <input name="option_b[]" class="form-control option-input" data-option="B"
                                            required>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label>Option C</label>
                                        <input name="option_c[]" class="form-control option-input" data-option="C">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label>Option D</label>
                                        <input name="option_d[]" class="form-control option-input" data-option="D">
                                    </div>
                                </div>

                                <div class="form-group mt-2">
                                    <label>Correct Option</label>
                                    <select name="correct_option[]" class="form-control correct-option-select" required>
                                        <option value="">Select</option>
                                        <!-- <option value="A">Option A</option>
                                        <option value="B">Option B</option>
                                        <option value="C">Option C</option>
                                        <option value="D">Option D</option> -->
                                    </select>
                                </div>

                                <button type="button" class="btn btn-sm btn-danger removeMcq">
                                    <i class="fa fa-trash"></i> Remove
                                </button>
                            </div>
                            <hr>
                        </div>

                        <div class="modal fade" id="editMcqModal">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <form method="post" action="<?= base_url(ADMIN . 'Lesson/updateMcq'); ?>">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit MCQ</h5>
                                            <button class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <input type="hidden" name="id" id="edit_id">
                                            <input type="hidden" name="lesson_id" value="<?= $lesson['id']; ?>">

                                            <div class="form-group">
                                                <label>Question</label>
                                                <textarea name="question" id="edit_question" rows="8"
                                                    class="form-control" required></textarea>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Option A</label>
                                                    <input name="option_a" id="edit_a" class="form-control"
                                                        placeholder="Option A" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Option B</label>
                                                    <input name="option_b" id="edit_b" class="form-control"
                                                        placeholder="Option B" required>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label>Option C</label>
                                                    <input name="option_c" id="edit_c" class="form-control"
                                                        placeholder="Option C">
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label>Option D</label>
                                                    <input name="option_d" id="edit_d" class="form-control"
                                                        placeholder="Option D">
                                                </div>
                                            </div>

                                            <select name="correct_option" id="edit_correct" class="form-control mt-3"
                                                required>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-danger">Update</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- UPLOAD CSV MODAL -->
                        <div class="modal fade" id="uploadCsvModal" tabindex="-1">
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

                                            <!-- LEFT SIDE -->
                                            <div class="col-md-5">

                                                <div class="form-group">
                                                    <label>Course</label>
                                                    <input class="form-control" value="<?= $lesson['course_name'] ?>"
                                                        readonly>
                                                </div>

                                                <div class="form-group">
                                                    <label>Section</label>
                                                    <input class="form-control" value="<?= $lesson['section_title'] ?>"
                                                        readonly>
                                                </div>

                                                <div class="form-group">
                                                    <label>Lesson</label>
                                                    <input class="form-control" value="<?= $lesson['lesson_title'] ?>"
                                                        readonly>
                                                </div>

                                            </div>


                                            <!-- RIGHT SIDE -->
                                            <div class="col-md-7 border-left">

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div>
                                                        <label class="font-weight-bold d-block mb-1">Sample
                                                            Template</label>
                                                        <small class="text-muted">Download Excel template for this
                                                            lesson</small>
                                                    </div>

                                                    <a href="<?= base_url(ADMIN . 'Lesson/downloadMcqXlsxTemplate/' . $lesson['id']) ?>"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fa fa-file-excel"></i> Download Template
                                                    </a>
                                                </div>

                                                <hr>

                                                <form id="uploadMcqForm" enctype="multipart/form-data">

                                                    <input type="hidden" id="upload_lesson_id"
                                                        value="<?= $lesson['id']; ?>">

                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Upload MCQ Excel</label>
                                                        <input type="file" name="mcq_file" class="form-control"
                                                            accept=".xlsx" required>
                                                    </div>

                                                    <div class="progress mt-3" id="uploadProgressWrapper"
                                                        style="display:none;height:22px">

                                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                            id="uploadProgressBar" style="width:0%">
                                                            0%
                                                        </div>

                                                    </div>

                                                    <button type="submit" class="btn btn-danger mt-3" id="previewBtn">
                                                        <i class="fa fa-upload"></i> Upload & Preview
                                                    </button>

                                                </form>

                                            </div>

                                            <!-- PREVIEW TABLE -->
                                            <div class="col-md-12">

                                                <hr>

                                                <div id="importSummary" style="display:none;"></div>

                                                <div id="mcqPreviewSection" style="display:none;">

                                                    <div class="d-flex justify-content-between align-items-center mb-2">

                                                        <h5 class="mb-0">Preview MCQs</h5>

                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            id="downloadErrorExcelBtn" style="display:none;">
                                                            <i class="fa fa-download"></i> Download Error Excel
                                                        </button>

                                                    </div>

                                                    <div class="table-responsive"
                                                        style="max-height:450px; overflow:auto;">

                                                        <table class="table table-bordered table-hover table-sm">

                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th style="min-width:280px;">Question</th>
                                                                    <th>A</th>
                                                                    <th>B</th>
                                                                    <th>C</th>
                                                                    <th>D</th>
                                                                    <th>Correct</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="mcqPreviewTable"></tbody>

                                                        </table>

                                                    </div>

                                                    <div class="text-right mt-3">

                                                        <button class="btn btn-secondary" id="cancelPreviewBtn">
                                                            Cancel
                                                        </button>

                                                        <button class="btn btn-danger" id="revalidateBtn">
                                                            Revalidate
                                                        </button>

                                                        <button class="btn btn-primary" id="confirmUploadBtn">
                                                            Confirm Upload
                                                        </button>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer bg-light">

                                        <small class="text-muted mr-auto">
                                            Supported format: .xlsx | Columns A–F | Supports large imports
                                        </small>

                                        <button class="btn btn-secondary" data-dismiss="modal">
                                            Close
                                        </button>

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
<script>
    let mcqPreviewData = [];

    /* ===============================
    UPLOAD & PREVIEW EXCEL
    ================================= */

    $('#uploadMcqForm').on('submit', function (e) {

        e.preventDefault();

        let lessonId = $('#upload_lesson_id').val();

        if (!lessonId) {
            alert('Lesson not found');
            return;
        }

        let formData = new FormData(this);
        formData.append('lesson_id', lessonId);

        $('#uploadProgressWrapper').show();

        $('#uploadProgressBar')
            .removeClass('bg-danger bg-danger')
            .addClass('progress-bar-animated progress-bar-striped')
            .css('width', '0%')
            .text('0%');

        $('#mcqPreviewSection').hide();
        $('#importSummary').hide();

        $.ajax({

            url: "<?= base_url(ADMIN . 'Lesson/previewMcqXlsx') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,

            xhr: function () {

                let xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function (evt) {

                    if (evt.lengthComputable) {

                        let percent = Math.round((evt.loaded / evt.total) * 100);

                        $('#uploadProgressBar')
                            .css('width', percent + '%')
                            .text(percent + '%');

                    }

                }, false);

                return xhr;

            },

            danger: function (res) {

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
                    .addClass('bg-danger')
                    .css('width', '100%')
                    .text('Upload Complete');

                mcqPreviewData = data.data || [];

                renderSummary(data.summary);

                validateRows(mcqPreviewData);

            },

            error: function () {

                $('#uploadProgressBar')
                    .removeClass('progress-bar-animated')
                    .addClass('bg-danger')
                    .text('Upload failed');

                alert('Error uploading Excel file');

            }

        });

    });


    /* ===============================
    RENDER SUMMARY
    ================================= */

    function renderSummary(summary) {

        let html = `
<div class="alert alert-danger">
<b>Total Rows:</b> ${summary.total}
&nbsp; | &nbsp;
<b>Valid:</b> ${summary.valid}
&nbsp; | &nbsp;
<b>Invalid:</b> ${summary.invalid}
</div>
`;

        $('#importSummary').html(html).show();

    }


    /* ===============================
    VALIDATE ROWS
    ================================= */

    function validateRows(rows) {

        let html = '';
        let duplicateCheck = {};

        let valid = 0;
        let invalid = 0;

        rows.forEach(function (row, index) {

            row.question = $.trim(row.question || '');
            row.option_a = $.trim(row.option_a || '');
            row.option_b = $.trim(row.option_b || '');
            row.option_c = $.trim(row.option_c || '');
            row.option_d = $.trim(row.option_d || '');
            row.correct_option = $.trim((row.correct_option || '').toUpperCase());

            let errors = [];

            /* question required */

            if (row.question == '')
                errors.push('Question required');

            /* options required */

            let filledOptions = 0;

            if (row.option_a !== '') filledOptions++;
            if (row.option_b !== '') filledOptions++;
            if (row.option_c !== '') filledOptions++;
            if (row.option_d !== '') filledOptions++;

            if (filledOptions < 2) {
                errors.push('At least 2 options required');
            }

            /* correct option */

            if (['A', 'B', 'C', 'D'].indexOf(row.correct_option) === -1)
                errors.push('Correct option must be A,B,C or D');

            /* duplicate detection */

            let qKey = row.question.toLowerCase().replace(/\s+/g, ' ').trim();

            if (qKey != '') {

                if (duplicateCheck[qKey])
                    errors.push('Duplicate question in preview');

                duplicateCheck[qKey] = true;

            }

            row.errors = errors;

            if (errors.length > 0) {
                hasError = true;
                invalid++;
            } else {
                valid++;
            }

            let badge = errors.length ? 'danger' : 'danger';
            let status = errors.length ? errors.join(', ') : 'Valid';


            // PUT HERE ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓

            let correctOptionsHtml = '<option value="">Select</option>';

            if (row.option_a !== '') {
                correctOptionsHtml += `
          <option value="A" ${row.correct_option === 'A' ? 'selected' : ''}>
            A
          </option>
        `;
            }

            if (row.option_b !== '') {
                correctOptionsHtml += `
          <option value="B" ${row.correct_option === 'B' ? 'selected' : ''}>
            B
          </option>
        `;
            }

            if (row.option_c !== '') {
                correctOptionsHtml += `
          <option value="C" ${row.correct_option === 'C' ? 'selected' : ''}>
            C
          </option>
        `;
            }

            if (row.option_d !== '') {
                correctOptionsHtml += `
          <option value="D" ${row.correct_option === 'D' ? 'selected' : ''}>
            D
          </option>
        `;
            }


            html += `
        <tr class="${errors.length ? 'table-danger' : ''}" data-index="${index}">
          <td>${row.row}</td>

          <td>
            <textarea class="form-control edit-question" rows="3">
              ${escapeHtml(row.question)}
            </textarea>
          </td>

          <td>
            <input type="text" class="form-control edit-a"
            value="${escapeHtml(row.option_a)}">
          </td>

          <td>
            <input type="text" class="form-control edit-b"
            value="${escapeHtml(row.option_b)}">
          </td>

          <td>
            <input type="text" class="form-control edit-c"
            value="${escapeHtml(row.option_c)}">
          </td>

          <td>
            <input type="text" class="form-control edit-d"
            value="${escapeHtml(row.option_d)}">
          </td>

          <td>
            <select class="form-control edit-correct">
              ${correctOptionsHtml}
            </select>
          </td>

          <td>
            <span class="badge badge-${badge}">
              ${status}
            </span>
          </td>
        </tr>
      `;
        });

        $('#mcqPreviewTable').html(html);
        $('#mcqPreviewSection').show();


        if (invalid > 0) {

            $('#downloadErrorExcelBtn').show();

            $('#confirmUploadBtn')
                .prop('disabled', true)
                .removeClass('btn-primary btn-danger')
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

        $('#mcqPreviewTable tr').each(function () {

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

    $(document).on('input', '.edit-a, .edit-b, .edit-c, .edit-d', function () {

        let row = $(this).closest('tr');

        let a = $.trim(row.find('.edit-a').val());
        let b = $.trim(row.find('.edit-b').val());
        let c = $.trim(row.find('.edit-c').val());
        let d = $.trim(row.find('.edit-d').val());

        let currentSelected = row.find('.edit-correct').val();

        let html = '<option value="">Select</option>';

        if (a !== '') {
            html += `<option value="A">A</option>`;
        }

        if (b !== '') {
            html += `<option value="B">B</option>`;
        }

        if (c !== '') {
            html += `<option value="C">C</option>`;
        }

        if (d !== '') {
            html += `<option value="D">D</option>`;
        }

        row.find('.edit-correct').html(html);

        // restore selected if still valid
        if (
            (currentSelected === 'A' && a !== '') ||
            (currentSelected === 'B' && b !== '') ||
            (currentSelected === 'C' && c !== '') ||
            (currentSelected === 'D' && d !== '')
        ) {
            row.find('.edit-correct').val(currentSelected);
        }

    });


    $('#revalidateBtn').click(function () {

        let rows = collectEditedRows();

        validateRows(rows);

    });



    $('#cancelPreviewBtn').click(function () {

        $('#mcqPreviewSection').hide();
        $('#mcqPreviewTable').html('');
        $('#importSummary').hide();

        mcqPreviewData = [];

    });



    $('#downloadErrorExcelBtn').click(function () {

        let rows = collectEditedRows();

        let errorRows = [];

        rows.forEach(function (row) {

            let errors = [];

            if ($.trim(row.question) == '')
                errors.push('Question required');

            let filledOptions = 0;

            if (row.option_a !== '') filledOptions++;
            if (row.option_b !== '') filledOptions++;
            if (row.option_c !== '') filledOptions++;
            if (row.option_d !== '') filledOptions++;

            if (filledOptions < 2) {
                errors.push('At least 2 options required');
            }

            if (['A', 'B', 'C', 'D'].indexOf($.trim(row.correct_option)) === -1)
                errors.push('Correct option must be A,B,C or D');

            row.errors = errors;

            if (errors.length)
                errorRows.push(row);

        });

        if (errorRows.length == 0) {

            alert('No error rows');

            return;

        }

        let form = $('<form>', {
            method: 'POST',
            action: "<?= base_url(ADMIN . 'Lesson/downloadErrorExcel') ?>"
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


    $('#confirmUploadBtn').click(function () {

        let rows = collectEditedRows();

        let hasError = false;

        rows.forEach(function (row) {

            let question = $.trim(row.question);
            let a = $.trim(row.option_a);
            let b = $.trim(row.option_b);
            let c = $.trim(row.option_c);
            let d = $.trim(row.option_d);
            let correct = $.trim((row.correct_option || '').toUpperCase());

            let filledOptions = 0;
            if (a !== '') filledOptions++;
            if (b !== '') filledOptions++;
            if (c !== '') filledOptions++;
            if (d !== '') filledOptions++;

            if (
                question === '' ||
                filledOptions < 2 || ['A', 'B', 'C', 'D'].indexOf(correct) === -1
            ) {
                hasError = true;
            }

            let correctMap = {
                A: a,
                B: b,
                C: c,
                D: d
            };
            if (correct && (!correctMap[correct] || correctMap[correct] === '')) {
                hasError = true;
            }

        });

        if (hasError) {
            alert('Please fix validation errors before upload.');
            validateRows(rows);
            return;
        }

        $('#confirmUploadBtn')
            .prop('disabled', true)
            .text('Uploading...');

        $.ajax({

            url: "<?= base_url(ADMIN . 'Lesson/saveMcqBulk') ?>",
            type: "POST",
            dataType: "json",

            data: {
                rows: JSON.stringify(rows)
            },

            danger: function (res) {

                if (res.status) {

                    alert(res.msg + ' | Inserted: ' + res.inserted);

                    location.reload();

                } else {

                    alert(res.msg || 'Upload failed');

                    $('#confirmUploadBtn')
                        .prop('disabled', false)
                        .text('Confirm Upload');

                }

            },

            error: function () {

                alert('Server error');

                $('#confirmUploadBtn')
                    .prop('disabled', false)
                    .text('Confirm Upload');

            }

        });

    });

    function escapeHtml(text) {

        return $('<div>').text(text).html();

    }
</script>
<script>
    // function updateCorrectOptions(mcqItem) {

    //     let select = mcqItem.find('.correct-option-select');
    //     let currentVal = select.val();

    //     select.html('<option value="">Select</option>');

    //     mcqItem.find('.option-input').each(function() {

    //         let value = $(this).val().trim();
    //         let option = $(this).data('option');

    //         if (value !== '') {

    //             select.append(
    //                 `<option value="${option}">
    //                 Option ${option}
    //             </option>`
    //             );
    //         }
    //     });

    //     // restore selected value if still exists
    //     if (select.find(`option[value="${currentVal}"]`).length) {
    //         select.val(currentVal);
    //     }
    // }
    function updateCorrectOptions(mcqItem) {

        let select = mcqItem.find('.correct-option-select');
        let currentVal = select.val();

        // clear all options first
        select.empty();

        // default option
        select.append('<option value="">Select</option>');

        mcqItem.find('.option-input').each(function () {

            let value = $(this).val().trim();
            let option = $(this).data('option');

            if (value !== '') {

                select.append(
                    `<option value="${option}">
                Option ${option}
            </option>`
                );
            }
        });

        // restore selected value if available
        if (select.find(`option[value="${currentVal}"]`).length) {
            select.val(currentVal);
        }
    }
    $(document).on('keyup change', '.option-input', function () {

        let mcqItem = $(this).closest('.mcq-item');
        updateCorrectOptions(mcqItem);

    });

    function openAddMcqModal() {
        $('#mcqMode').val('add');
        $('#mcqModalTitle').text('Add MCQs');
        $('#mcqRepeater').html($('#mcqItemTemplate').html());
        updateCorrectOptions($('#mcqRepeater .mcq-item'));
        $('#mcqModal').modal('show');
    }

    function openEditMcqModal(mcq) {
        $('#edit_id').val(mcq.id);
        $('#edit_question').val(mcq.question);
        $('#edit_a').val(mcq.option_a);
        $('#edit_b').val(mcq.option_b);
        $('#edit_c').val(mcq.option_c);
        $('#edit_d').val(mcq.option_d);
        $('#edit_correct').val(mcq.correct_option);
        updateEditCorrectOptions();
        $('#editMcqModal').modal('show');
    }
    $(document).on('keyup change', '#edit_a, #edit_b, #edit_c, #edit_d', function () {

        updateEditCorrectOptions();

    });

    function updateEditCorrectOptions() {

        $('#edit_correct option').prop('disabled', false);

        if ($('#edit_a').val().trim() === '') {
            $('#edit_correct option[value="A"]').prop('disabled', true);
        }

        if ($('#edit_b').val().trim() === '') {
            $('#edit_correct option[value="B"]').prop('disabled', true);
        }

        if ($('#edit_c').val().trim() === '') {
            $('#edit_correct option[value="C"]').prop('disabled', true);
        }

        if ($('#edit_d').val().trim() === '') {
            $('#edit_correct option[value="D"]').prop('disabled', true);
        }

        // reset selected if disabled
        let selected = $('#edit_correct').val();

        if ($('#edit_correct option:selected').prop('disabled')) {
            $('#edit_correct').val('');
        }
    }

    function deleteMcq(id, lessonId) {
        if (!confirm('Delete this MCQ?')) return;

        $.post("<?= base_url(ADMIN . 'Lesson/deleteMcq'); ?>", {
            id
        }, function (res) {
            if (res.status) {
                location.href = "<?= base_url(ADMIN . 'Lesson/mcq/'); ?>" + lessonId;
            }
        }, 'json');
    }



    $(document).on('click', '#addMoreMcq', function () {
        $('#mcqRepeater').append($('#mcqItemTemplate').html());
        $('#mcqRepeater').append(newItem);

        let lastItem = $('#mcqRepeater .mcq-item').last();

        updateCorrectOptions(lastItem);
    });

    $(document).on('click', '.removeMcq', function () {
        if ($('.mcq-item').length > 1) {
            $(this).closest('.mcq-item').remove();
        }
    });
</script>

<script>
    function deleteMcq(id, lessonId) {
        if (!confirm('Delete this MCQ?')) return;

        $.ajax({
            url: "<?= base_url(ADMIN . 'Lesson/deleteMcq'); ?>",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",
            danger: function (res) {
                if (res.status) {
                    location.href = "<?= base_url(ADMIN . 'Lesson/mcq/'); ?>" + lessonId;
                } else {
                    alert(res.message || 'Delete failed');
                }
            }
        });
    }
</script>