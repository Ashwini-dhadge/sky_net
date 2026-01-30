<?php init_header(); ?>
<?php if (isset($lesson)) {
    $lesson = $lesson[0];
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
                                <form class="repeater" action="<?= base_url(ADMIN . 'Lesson/Lesson'); ?>" method="post"
                                    enctype="multipart/form-data" enctype="multipart/form-data">
                                    <input type="hidden" name="id" id="id"
                                        value="<?= (isset($lesson)) ? $lesson['id'] : ''; ?>">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="example-text-input" class=" col-form-label">Select
                                                Course</label>
                                            <div>
                                                <select class="custom-select " id="course_id" name="course_id" required>
                                                    <option value="">Select Course</option>
                                                    <?php foreach ($course as $key => $value) {
                                                        if ((isset($lesson['course_id']) && $lesson['course_id'] == $value['id'])) {
                                                            $selected = "selected";
                                                        } else {
                                                            $selected = "";
                                                        }
                                                    ?>
                                                        <option value="<?= $value['id'] ?>" <?= $selected; ?>>
                                                            <?= $value['title'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="example-text-input" class="col-form-label">Lesson Title</label>
                                            <div class="">
                                                <input class="form-control" type="text"
                                                    value="<?= (isset($lesson)) ? $lesson['title'] : ''; ?>"
                                                    name="title" id="title" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="example-text-input" class="col-form-label">Lesson Title</label>
                                            <div class="">
                                                <input class="form-control" type="text"
                                                    value="<?= (isset($lesson)) ? $lesson['title'] : ''; ?>"
                                                    name="title" id="title" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="example-text-input" class=" col-form-label">Select
                                                Course</label>
                                            <div>
                                                <select class="custom-select " id="course_id" name="course_id" required>
                                                    <option value="">Select Course</option>
                                                    <?php foreach ($course as $key => $value) {
                                                        if ((isset($lesson['course_id']) && $lesson['course_id'] == $value['id'])) {
                                                            $selected = "selected";
                                                        } else {
                                                            $selected = "";
                                                        }
                                                    ?>
                                                        <option value="<?= $value['id'] ?>" <?= $selected; ?>>
                                                            <?= $value['title'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Select Language</label>
                                            <div>
                                                <select id="language" name="language" required
                                                    class="form-control select2">
                                                    <option value="">Language</option>

                                                    <option value="1"
                                                        <?= (isset($lesson) && $lesson['language'] == 1) ? 'selected' : ''; ?>>
                                                        English</option>
                                                    <option value="2"
                                                        <?= (isset($lesson) && $lesson['language'] == 2) ? 'selected' : ''; ?>>
                                                        Marathi</option>
                                                    <option value="3"
                                                        <?= (isset($lesson) && $lesson['language'] == 3) ? 'selected' : ''; ?>>
                                                        Hindi</option>

                                                </select>
                                            </div>
                                        </div>
                                        <!--    <div class="form-group col-lg-6">
                                            <label for="duration_id">Duration</label> 
                                            <select id="duration_id" name="duration_id" required class="form-control">
                                              <option value="">Select</option>
                                               <?php foreach ($duration as $key => $value) {
                                                    if ((isset($lesson) && $lesson['duration_id'] == $value['id'])) {
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                ?>
                                                  <option value="<?= $value['id'] ?>"  <?= $selected; ?>><?= $value['name'] ?></option>
                                                  <?php  }  ?> 
                                            </select>
                                          </div>-->

                                        <!--    <div class="form-group col-md-6" >
                                          <label>Select offer Type</label>
                                          <div>
                                            <select id="offer_type" name="offer_type" required class="form-control select2" onchange="getplanamount()">
                                              <option value="">offer</option>
                                              <option value="1" <?= (isset($lesson) && $lesson['offer_type'] == 1) ? 'selected' : ''; ?>> Flat</option>
                                              <option value="2" <?= (isset($lesson) && $lesson['offer_type'] == 2) ? 'selected' : ''; ?>>Percentage</option>
                                              
                                            </select>
                                          </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>offer Amount</label>
                                            <div>
                                                    <input class="form-control" type="text" value="<?= (isset($lesson)) ? $lesson['offer_amount'] : ''; ?>" name="offer_amount" id="offer_amount" onkeyup="getplanamount()">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Original price</label>
                                            <div>
                                                    <input class="form-control" type="text" value="<?= (isset($lesson)) ? $lesson['strike_thr_price'] : ''; ?>" name="strike_thr_price" id="strike_thr_price"  onkeyup="getplanamount()">
                                            </div>
                                        </div>
                                       
                                        <div class="form-group col-md-6">
                                            <label>offer Price</label>
                                            <div>
                                                    <input class="form-control" type="text" value="<?= (isset($lesson)) ? $lesson['price'] : ''; ?>" name="price" id="price">
                                            </div>
                                        </div>-->
                                        <!--  
                                      <div class="form-group col-md-6">
                                          <label>Course Image</label>
                                          <div>
                                            <input  type="file" class="form-control"  name="image" id="image" >
                                            <?= (isset($lesson)) ? '<img src="' . base_url() . COURSE_IMAGES . $lesson['image'] . '" width="80">' : ''; ?>
                                         </div>
                                      </div> -->
                                        <div class="form-group col-md-12">
                                            <label>Importance</label>
                                            <div>
                                                <textarea class="form-control" name="importance"
                                                    id="importance"><?= (isset($lesson)) ? $lesson['importance'] : ''; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Benefits</label>
                                            <div>
                                                <textarea class="form-control" name="benefits"
                                                    id="benefits"><?= (isset($lesson)) ? $lesson['benefits'] : ''; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Status</label>
                                            <div>
                                                <input type="radio" required value="1" name="status"
                                                    <?= (isset($lesson['status']) && $lesson['status'] == 1) ? 'checked' : ''; ?>
                                                    checked>
                                                &nbsp;&nbsp;Active&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="radio" required value="0" name="status"
                                                    <?= (isset($lesson['status']) && $lesson['status'] == 0) ? 'checked' : ''; ?>>
                                                &nbsp;&nbsp;In-Active
                                            </div>
                                        </div>

                                    </div>
                                    <hr>
                                    <h4 class="mt-50 header-title m-b-20">Add Video
                                        <input data-repeater-create type="button" class="btn btn-success mo-mt-2"
                                            value="Add" style="float: right;">
                                    </h4>
                                    <hr>
                                    <div data-repeater-list="lesson">
                                        <?php if (isset($video_master[0])): ?>
                                            <?php foreach ($video_master as $key => $video): ?>
                                                <div data-repeater-item class="row m-b-20">
                                                    <input type="hidden" name="id" id="id"
                                                        value="<?= (isset($video)) ? $video['id'] : ''; ?>">

                                                    <div class="form-group col-lg-3">
                                                        <label>Video Title</label>
                                                        <input class="form-control" type="text"
                                                            value="<?= (isset($video)) ? $video['title'] : ''; ?>" name="title"
                                                            id="title" required>
                                                    </div>
                                                    <div class="form-group col-lg-3">
                                                        <label>Video Type</label>
                                                        <input type="text" class="form-control" name="video_type"
                                                            id="video_type"
                                                            value="<?= (isset($video)) ? $video['video_type'] : ''; ?>">

                                                    </div>
                                                    <div class="form-group col-lg-3">
                                                        <label>Duration</label>
                                                        <input type="text" class="form-control" name="duration" id="duration"
                                                            value="<?= (isset($video)) ? $video['duration'] : ''; ?>">
                                                    </div>
                                                    <div class="form-group col-lg-3">
                                                        <label>Is Final Video</label>
                                                        <div>
                                                            <input type="radio" required value="1" name="is_this_video_final"
                                                                <?= (isset($video['is_this_video_final']) && $video['is_this_video_final'] == 1) ? 'checked' : ''; ?>>
                                                            &nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" required value="0" name="is_this_video_final"
                                                                <?= (isset($video['is_this_video_final']) && $video['is_this_video_final'] == 0) ? 'checked' : ''; ?>>
                                                            &nbsp;&nbsp;No
                                                        </div>
                                                    </div>

                                                    <!--   <div class="form-group col-lg-6">
                                                    <label>Video Link</label>
                                                        <textarea  class="form-control" name="video_url" id="video_url"><?= (isset($video)) ? $video['video_url'] : ''; ?></textarea>
                                                                    
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                    <label>Video Link For Mobile</label>
                                                        <textarea  class="form-control" name="video_url_for_mobile_application" id="video_url_for_mobile_application"><?= (isset($video)) ? $video['video_url_for_mobile_application'] : ''; ?></textarea>
                                                    </div>-->
                                                    <div class="form-group col-lg-6">
                                                        <label>Video Vimeo code</label>
                                                        <input type="text" class="form-control" name="video_vimeo_code"
                                                            id="video_vimeo_code"
                                                            value="<?= (isset($video)) ? $video['video_vimeo_code'] : ''; ?>">

                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label>Video Against No of MCQ Question</label>
                                                        <input type="text" class="form-control" name="no_of_question"
                                                            id="no_of_question"
                                                            value="<?= (isset($video)) ? $video['no_of_question'] : ''; ?>">

                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="example-text-input" class="col-form-label">Video Against No
                                                            of MCQ Duration (HH:MM:SS)</label>
                                                        <div>
                                                            <input class="form-control" type="text"
                                                                value="<?= (isset($video)) ? $video['exam_duration'] : ''; ?>"
                                                                name="exam_duration" id="exam_duration" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="example-text-input" class="col-form-label">Video
                                                            thumbnail</label>
                                                        <div>
                                                            <input class="form-control" type="file" name="video_thumbnail"
                                                                id="video_thumbnail">
                                                            <?php
                                                            if (isset($video['video_thumbnail'])) {
                                                                echo "<img src='" . base_url(VIDEO_IMAGES) . $video['video_thumbnail'] . "'  width='50px'>";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-1 align-self-center">
                                                        <label for="delete"><br></label>
                                                        <button data-repeater-delete type="button"
                                                            class="btn btn-danger float-right" value="delete"><i
                                                                class="fas fa-trash-alt "></i></button>
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        <?php else: ?>
                                            <div data-repeater-item class="row m-b-20">
                                                <input type="hidden" name="id" id="id" value="">

                                                <div class="form-group col-lg-3">
                                                    <label>Video Title</label>
                                                    <input class="form-control" type="text" value="" name="title" id="title"
                                                        required>
                                                </div>
                                                <div class="form-group col-lg-3">
                                                    <label>Video Type</label>
                                                    <input type="text" class="form-control" name="video_type"
                                                        id="video_type" value="">

                                                </div>
                                                <div class="form-group col-lg-3">
                                                    <label>Duration</label>
                                                    <input type="text" class="form-control" name="duration" id="duration"
                                                        value="">
                                                </div>
                                                <div class="form-group col-lg-3">
                                                    <label>Is Final Video</label>
                                                    <div>

                                                        <input type="radio" required value="1" name="is_this_video_final"
                                                            <?= (isset($video['is_this_video_final']) && $video['is_this_video_final'] == 1) ? 'checked' : ''; ?>>
                                                        &nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" required value="0" name="is_this_video_final"
                                                            <?= (isset($video['is_this_video_final']) && $video['is_this_video_final'] == 0) ? 'checked' : ''; ?>checked>
                                                        &nbsp;&nbsp;No
                                                    </div>
                                                </div>

                                                <!-- <div class="form-group col-lg-3">
                                                    <label>Image</label>
                                                        <input  type="file" class="form-control"  name="video_thumbnail" id="video_thumbnail" >
                                                        
                                                    </div> -->
                                                <!--    <div class="form-group col-lg-6">
                                                    <label>Video Link</label>
                                                        <textarea  class="form-control" name="video_url" id="video_url"></textarea>
                                                                    
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                    <label>Video Link For Mobile</label>
                                                        <textarea  class="form-control" name="video_url_for_mobile_application" id="video_url_for_mobile_application"></textarea>
                                                    </div>-->
                                                <div class="form-group col-lg-6">
                                                    <label>Video Vimeo code</label>
                                                    <input type="text" class="form-control" name="video_vimeo_code"
                                                        id="video_vimeo_code"
                                                        value="<?= (isset($video)) ? $video['video_vimeo_code'] : ''; ?>">

                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label>Video Against No of MCQ Question</label>
                                                    <input type="text" class="form-control" name="no_of_question"
                                                        id="no_of_question"
                                                        value="<?= (isset($video)) ? $video['no_of_question'] : ''; ?>">

                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="example-text-input" class="col-form-label">Video Against No
                                                        of MCQ Duration (HH:MM:SS)</label>
                                                    <div>
                                                        <input class="form-control" type="text"
                                                            value="<?= (isset($video)) ? $video['exam_duration'] : ''; ?>"
                                                            name="exam_duration" id="exam_duration" required>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="example-text-input" class="col-form-label">Video
                                                        thumbnail</label>
                                                    <div>
                                                        <input class="form-control" type="file" name="video_thumbnail"
                                                            id="video_thumbnail" required>
                                                        <?php
                                                        if (isset($video['video_thumbnail'])) {
                                                            echo "<img src='" . base_url(VIDEO_IMAGES) . $video['exam_duration'] . "'>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 align-self-center">
                                                    <label for="delete"><br></label>
                                                    <button data-repeater-delete type="button"
                                                        class="btn btn-danger float-right" value="delete"><i
                                                            class="fas fa-trash-alt "></i></button>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>
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