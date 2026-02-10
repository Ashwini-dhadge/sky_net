<?php init_header(); ?>

<style>
    .select2-selection--multiple .select2-selection__choice {
        background-color: #CA151C !important;
        border: 1px solid #ec4561 !important;
        color: #fff !important;
    }
</style>

<div class="main-content">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title m-b-20"><?= $title; ?></h4>
                        <hr>
                        <form class="repeater" action="<?= base_url(ADMIN . 'Course/Course'); ?>" method="post"
                            enctype="multipart/form-data" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id"
                                value="<?= (isset($course)) ? $course['id'] : ''; ?>">

                            <div class="row">
                                <div class="col-12 col-md-5">
                                    <div class="form-group">
                                        <label class="col-form-label">Course Title</label>
                                        <input class="form-control" type="text"
                                            value="<?= (isset($course)) ? $course['title'] : ''; ?>" name="title"
                                            id="title" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Select Category</label>
                                        <select class="form-control select2" id="category_id" name="category_id"
                                            required>
                                            <option value="">Select Category</option>
                                            <?php foreach ($category as $key => $value) {
                                                $selected = (isset($course['category_id']) && $course['category_id'] == $value['id']) ? "selected" : "";
                                            ?>
                                                <option value="<?= $value['id'] ?>" <?= $selected; ?>>
                                                    <?= $value['category_name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Select Course Instructor</label>
                                        <select class="form-control select2 form-control-sm" id="instructor_id"
                                            name="instructor_id" required>

                                            <option value="">Select Instructor</option>

                                            <?php foreach ($instructors as $instructor): ?>
                                                <option value="<?= $instructor['id']; ?>"
                                                    <?= (isset($course['instructor_id']) && $course['instructor_id'] == $instructor['id']) ? 'selected' : ''; ?>>
                                                    <?= $instructor['first_name'] . ' ' . $instructor['last_name']; ?>
                                                </option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-form-label">Select Course Type</label>
                                        <select class="custom-select form-control-sm" id="course_type"
                                            name="course_type" required>
                                            <option value="">Select Course Type</option>
                                            <option value="0"
                                                <?= (isset($course['course_type']) && $course['course_type'] == 0) ? 'selected' : ''; ?>>
                                                Offline
                                            </option>
                                            <option value="1"
                                                <?= (isset($course['course_type']) && $course['course_type'] == 1) ? 'selected' : ''; ?>>
                                                Online
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Select Skill</label>
                                        <select class="custom-select" id="skill_id" name="skill_id[]" multiple required>
                                            <?php foreach ($skill as $value) {
                                                $selected = (isset($course['skill_id']) && $course['skill_id'] == $value['id']) ? "selected" : "";
                                            ?>
                                                <option value="<?= $value['id'] ?>" <?= $selected; ?>>
                                                    <?= $value['name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Language</label>
                                        <select id="language" name="language" required class="form-control select2">
                                            <option value="">Language</option>
                                            <option value="1"
                                                <?= (isset($course) && $course['language'] == 1) ? 'selected' : ''; ?>>
                                                English</option>
                                            <option value="2"
                                                <?= (isset($course) && $course['language'] == 2) ? 'selected' : ''; ?>>
                                                Marathi</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Course Image</label>
                                        <input type="file" class="form-control" name="image">
                                        <?= (isset($course)) ? '<img src="' . base_url(COURSE_IMAGES . $course['image']) . '" width="80">' : ''; ?>
                                    </div>
                                </div>

                                <div class="col-12 col-md-7">
                                    <div class="form-group">
                                        <label>Notes</label>
                                        <textarea class="form-control summernote" rows="2"
                                            name="notes"><?= (isset($course)) ? $course['notes'] : ''; ?></textarea>
                                    </div>
                                </div>

                                <!-- <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label>Benefits</label>
                                        <textarea class="form-control summernote" rows="2"
                                            name="benefits"><?= (isset($course)) ? $course['benefits'] : ''; ?></textarea>
                                    </div>
                                </div> -->

                                <div class="col-12 col-md-6">
                                    <div class="d-flex gap-2">
                                        <div class="mr-5">
                                            <div class="form-group">
                                                <label>Certificate</label><br>
                                                <input type="radio" value="1" name="certificate"
                                                    <?= (isset($course) && $course['certificate'] == 1) ? 'checked' : ''; ?>>
                                                YES
                                                <input type="radio" value="0" name="certificate"
                                                    <?= (isset($course) && $course['certificate'] == 0) ? 'checked' : ''; ?>>
                                                NO
                                            </div>
                                            <div class="form-group">
                                                <label>Assessment</label><br>
                                                <input type="radio" value="1" name="assessment"
                                                    <?= (isset($course) && $course['assessment'] == 1) ? 'checked' : ''; ?>>
                                                YES
                                                <input type="radio" value="0" name="assessment"
                                                    <?= (isset($course) && $course['assessment'] == 0) ? 'checked' : ''; ?>>
                                                NO
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-group">
                                                <label>Status</label><br>
                                                <input type="radio" value="1" name="status"
                                                    <?= (isset($course['status']) && $course['status'] == 1) ? 'checked' : ''; ?>>
                                                Active
                                                <input type="radio" value="0" name="status"
                                                    <?= (isset($course['status']) && $course['status'] == 0) ? 'checked' : ''; ?>>
                                                In-Active
                                            </div>
                                            <div class="form-group">
                                                <label>Is Free</label><br>
                                                <input type="radio" value="1" name="is_free"
                                                    <?= (isset($course['is_free']) && $course['is_free'] == 1) ? 'checked' : ''; ?>>
                                                Yes
                                                <input type="radio" value="0" name="is_free"
                                                    <?= (isset($course['is_free']) && $course['is_free'] == 0) ? 'checked' : ''; ?>>
                                                No
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <h4 class="header-title mt-4">Add Pricing</h4>
                            <hr>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Original Price</label>
                                    <input type="number" step="0.01" name="strike_thr_price" id="strike_thr_price"
                                        class="form-control" value="<?= $course_duration['strike_thr_price'] ?? ''; ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Offer Type</label>
                                    <select name="offer_type" id="offer_type" class="form-control" required>
                                        <option value="1"
                                            <?= (isset($course_duration) && $course_duration['offer_type'] == 1) ? 'selected' : ''; ?>>
                                            Flat
                                        </option>
                                        <option value="2"
                                            <?= (isset($course_duration) && $course_duration['offer_type'] == 2) ? 'selected' : ''; ?>>
                                            Percentage
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Offer Amount</label>
                                    <input type="number" step="0.01" name="offer_amount" id="offer_amount"
                                        class="form-control" value="<?= $course_duration['offer_amount'] ?? ''; ?>">
                                </div>



                                <div class="form-group col-md-3">
                                    <label>Final Price</label>
                                    <input type="number" step="0.01" name="price" id="price" class="form-control"
                                        readonly value="<?= $course_duration['price'] ?? ''; ?>">
                                </div>

                            </div>


                            <hr>

                            <h4 class="header-title mt-4">Add Download File Resources</h4>
                            <hr>

                            <div class="resource-repeater">

                                <div data-repeater-list="resources">

                                    <?php if (!empty($resources)): foreach ($resources as $res): ?>
                                            <div data-repeater-item class="card mb-3">
                                                <div class="card-body">

                                                    <input type="hidden" name="resource_id" value="<?= $res['id'] ?>">

                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <label>File Title</label>
                                                            <input type="text" name="file_notes" class="form-control"
                                                                value="<?= $res['file_notes'] ?>" required>
                                                        </div>

                                                        <div class="col-md-5">
                                                            <label>File</label>
                                                            <input type="file" name="file" class="form-control"
                                                                onchange="updatePreviewButton(this)">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label>&nbsp;</label><br>
                                                            <a href="<?= base_url(COURSE_RESOURCES . $res['file']) ?>"
                                                                class="btn btn-info preview-btn" target="_blank">
                                                                <i class="fas fa-eye"></i>
                                                            </a>

                                                            <button data-repeater-delete type="button"
                                                                class="btn btn-danger ml-1">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php endforeach;
                                    else: ?>

                                        <div data-repeater-item class="card mb-3">
                                            <div class="card-body">
                                                <div class="row">

                                                    <div class="col-md-5">
                                                        <label>File Title</label>
                                                        <input type="text" name="file_notes" class="form-control" required>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <label>File</label>
                                                        <input type="file" name="file" class="form-control"
                                                            onchange="updatePreviewButton(this)">
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label>&nbsp;</label><br>
                                                        <button type="button" class="btn btn-secondary preview-btn"
                                                            onclick="previewFile(this)">
                                                            <i class="fas fa-eye"></i>
                                                        </button>

                                                        <button data-repeater-delete type="button"
                                                            class="btn btn-danger ml-1">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    <?php endif; ?>

                                </div>

                                <button data-repeater-create type="button" class="btn btn-success mt-2">
                                    <i class="fas fa-plus"></i> Add Resource
                                </button>

                            </div>

                            <hr>

                            <button type="submit" class="btn btn-primary float-right mb-4">
                                Submit
                            </button>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php init_footer(); ?>

<script src="<?= base_url() ?>assets/plugins/jquery-repeater/jquery.repeater.min.js"></script>
<script src="https://cdn.ckeditor.com/4.15.0/full-all/ckeditor.js"></script>

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

<script type="text/javascript">
    CKEDITOR.replace('benefits', {
        height: '150px'
    });
    CKEDITOR.replace('notes', {
        height: '380px'
    });
</script>
<script type="text/javascript">
    $("#skill_id").select2({
        placeholder: "Select Skill",
        allowClear: true,
        width: '100%'
    });
</script>
<script>
    $(document).ready(function() {

        function calculateFinalPrice() {

            const offerType = $('#offer_type').val();
            let offerAmount = parseFloat($('#offer_amount').val());
            let originalPrice = parseFloat($('#strike_thr_price').val());

            // Default safety
            if (isNaN(originalPrice)) originalPrice = 0;
            if (isNaN(offerAmount)) offerAmount = 0;

            let finalPrice = originalPrice;

            if (offerType === '1') {
                // ===== FLAT =====
                if (offerAmount > originalPrice) {
                    offerAmount = originalPrice;
                    $('#offer_amount').val(offerAmount);
                }
                finalPrice = originalPrice - offerAmount;

            } else if (offerType === '2') {
                // ===== PERCENTAGE =====
                if (offerAmount > 100) {
                    offerAmount = 100;
                    $('#offer_amount').val(offerAmount);
                }
                finalPrice = originalPrice - ((originalPrice * offerAmount) / 100);
            }

            if (finalPrice < 0) finalPrice = 0;

            $('#price').val(finalPrice.toFixed(2));
        }

        // When offer type changes, reset offer amount
        $('#offer_type').on('change', function() {
            $('#offer_amount').val('');
            calculateFinalPrice();
        });

        // Recalculate on typing
        $('#offer_amount, #strike_thr_price').on('keyup change', function() {
            calculateFinalPrice();
        });

    });
</script>