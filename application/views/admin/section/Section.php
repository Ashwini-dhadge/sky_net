<?php init_header(); ?>
<?php
// for edit mode convert into single row
if (!empty($section)) {
    $section = $section;
}

//echo "<pre>";print_r($parentstaff);die();   
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.css"
    rel="stylesheet">

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title"></h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-right d-none d-md-block">
                                <button type="button" class="btn btn-secondary waves-effect waves-light mb-0"
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
                                <form class="repeater"
                                    action="<?= base_url(ADMIN . 'Section/Section'); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" id="id"
                                        value="<?= isset($section['id']) ? $section['id'] : ''; ?>">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="example-text-input" class=" col-form-label">Select
                                                Course</label>
                                            <div>
                                                <select class="form-control select2" id="course_id" name="course_id" required>
                                                    <option value="">Select Course</option>

                                                    <?php foreach ($course as $c) { ?>
                                                        <option value="<?= $c['id']; ?>" <?= (!empty($section) && $section['course_id'] == $c['id']) ? "selected" : "" ?>
                                                            <?= (!empty($selected_course_id) && $selected_course_id == $c['id']) ? "selected" : "" ?>>
                                                            <?= $c['title']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="example-text-input" class="col-form-label">Section Title</label>
                                            <div class="">
                                                <input class="form-control" type="text"
                                                    value="<?= isset($section['title']) ? $section['title'] : ''; ?>
"
                                                    name="title" id="title" required>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <div>
                                                <textarea class="form-control" name="description" id="benefits">
    <?= isset($section['description']) ? $section['description'] : ''; ?>
                                                </textarea>

                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group col-md-12"><br>
                                        <div class="form-group form-group mb-0 text-right">
                                            <button type="submit"
                                                class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
</div>
<!-- content -->
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/plugins/jquery-repeater/jquery.repeater.min.js"></script>
<script src="<?= base_url(); ?>assets/pages/form-repeater.int.js"></script>
<script src="https://cdn.ckeditor.com/4.15.0/full-all/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<!-- Include Moment.js CDN -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js">
</script>
<script type="text/javascript">
    $('#exam_duration').datetimepicker({
        format: 'HH:mm:ss',

    });

    function getplanamount() {
        var offer_type = $('#offer_type').val();
        var offer_amount = parseFloat($('#offer_amount').val());
        var strike_thr_packageAmount = parseFloat($('#strike_thr_price').val());

        if (offer_type) {
            if (offer_type == 1) {
                var amt = parseFloat(strike_thr_packageAmount - offer_amount);
                $('#price').val(amt);
            } else if (offer_type == 2) {
                var amt = parseFloat(strike_thr_packageAmount - ((strike_thr_packageAmount * offer_amount) / 100));
                $('#price').val(amt);
            } else {
                $('#price').val(strike_thr_packageAmount);
            }
        } else {
            $('#price').val(strike_thr_packageAmount);
        }

    }
    CKEDITOR.replace('benefits', {
        height: '150px'
    });
    CKEDITOR.replace('importance', {
        height: '100px'
    });
</script>