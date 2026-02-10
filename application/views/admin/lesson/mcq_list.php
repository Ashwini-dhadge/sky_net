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
                                        <span class="badge p-2 badge-primary" style="font-size: 12px;">
                                            Course: <?= $lesson['course_name']; ?>
                                        </span>

                                        <span class="badge p-2 badge-info ml-1" style="font-size: 12px;">
                                            Section: <?= $lesson['section_title']; ?>
                                        </span>

                                        <span class="badge p-2 badge-success ml-1" style="font-size: 12px;">
                                            Lesson: <?= $lesson['lesson_title']; ?>
                                        </span>
                                </div>

                                <div>
                                    <a href="<?= base_url(ADMIN . 'Lesson/downloadMcqXlsxTemplate/' . $lesson['id']); ?>"
                                        class="btn btn-secondary btn-sm">
                                        <i class="fa fa-file-excel"></i> Sample Template
                                    </a>

                                    <button class="btn btn-success btn-sm"
                                        data-toggle="modal"
                                        data-target="#uploadCsvModal">
                                        <i class="fa fa-upload"></i> Upload File
                                    </button>

                                    <button class="btn btn-primary btn-sm"
                                        onclick="openAddMcqModal()">
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
                                                    <span class="badge badge-success">
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

                                    <button type="button"
                                        class="btn btn-outline-primary btn-sm"
                                        id="addMoreMcq">
                                        <i class="fa fa-plus"></i> Add Another MCQ
                                    </button>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-success">
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
                                <input name="option_a[]" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Option B</label>
                                <input name="option_b[]" class="form-control" required>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label>Option C</label>
                                <input name="option_c[]" class="form-control">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label>Option D</label>
                                <input name="option_d[]" class="form-control">
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label>Correct Option</label>
                            <select name="correct_option[]" class="form-control" required>
                                <option value="">Select</option>
                                <option value="A">Option A</option>
                                <option value="B">Option B</option>
                                <option value="C">Option C</option>
                                <option value="D">Option D</option>
                            </select>
                        </div>

                        <button type="button"
                            class="btn btn-sm btn-danger removeMcq">
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
                                        <textarea name="question" id="edit_question" rows="8" class="form-control" required></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Option A</label>
                                            <input name="option_a" id="edit_a" class="form-control" placeholder="Option A" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Option B</label>
                                            <input name="option_b" id="edit_b" class="form-control" placeholder="Option B" required>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label>Option C</label>
                                            <input name="option_c" id="edit_c" class="form-control" placeholder="Option C">
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label>Option D</label>
                                            <input name="option_d" id="edit_d" class="form-control" placeholder="Option D">
                                        </div>
                                    </div>

                                    <select name="correct_option" id="edit_correct" class="form-control mt-3" required>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-success">Update</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                <!-- UPLOAD CSV MODAL -->
                <div class="modal fade" id="uploadCsvModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <form method="post" enctype="multipart/form-data" action="<?= base_url(ADMIN . 'Lesson/uploadMcqXlsx/' . $lesson['id']); ?>">

                                <div class="modal-header">
                                    <h5 class="modal-title">Upload MCQ CSV</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Select CSV File</label>
                                        <input type="file" name="mcq_file" class="form-control" accept=".xlsx" required>
                                        <small class="text-muted">
                                            Format: question, option_a, option_b, option_c, option_d, correct_option
                                        </small>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-success">
                                        <i class="fa fa-upload"></i> Upload
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Cancel
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

<?php init_footer(); ?>
<script>
    function openAddMcqModal() {
        $('#mcqMode').val('add');
        $('#mcqModalTitle').text('Add MCQs');
        $('#mcqRepeater').html($('#mcqItemTemplate').html());
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

        $('#editMcqModal').modal('show');
    }

    function deleteMcq(id, lessonId) {
        if (!confirm('Delete this MCQ?')) return;

        $.post("<?= base_url(ADMIN . 'Lesson/deleteMcq'); ?>", {
            id
        }, function(res) {
            if (res.status) {
                location.href = "<?= base_url(ADMIN . 'Lesson/mcq/'); ?>" + lessonId;
            }
        }, 'json');
    }



    $(document).on('click', '#addMoreMcq', function() {
        $('#mcqRepeater').append($('#mcqItemTemplate').html());
    });

    $(document).on('click', '.removeMcq', function() {
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
            success: function(res) {
                if (res.status) {
                    location.href = "<?= base_url(ADMIN . 'Lesson/mcq/'); ?>" + lessonId;
                } else {
                    alert(res.message || 'Delete failed');
                }
            }
        });
    }
</script>