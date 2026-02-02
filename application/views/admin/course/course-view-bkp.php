 <?php init_header(); ?>

 <?php if (isset($course)) {
        $course = $course[0];
    }


    // echo "<pre>";print_r($course_duration);die();   
    ?>
 <style>
     .select2-selection--multiple .select2-selection__choice {
         background-color: #CA151C !important;
         border: 1px solid #ec4561 !important;
         border-radius: 4px !important;
         padding: 0 7px !important;
         color: white !important;
     }

     .select2-container--default .select2-results__option--highlighted[aria-selected] {
         background-color: #CA151C !important;
     }
 </style>
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
                                 <form class="repeater" action="<?= base_url(ADMIN . 'Course/Course'); ?>" method="post"
                                     enctype="multipart/form-data" enctype="multipart/form-data">
                                     <input type="hidden" name="id" id="id"
                                         value="<?= (isset($course)) ? $course['id'] : ''; ?>">
                                     <div class="row">
                                         <div class="form-group">
                                             <label for="example-text-input" class="col-form-label">Course Title</label>
                                             <div class="">
                                                 <input class="form-control" type="text"
                                                     value="<?= (isset($course)) ? $course['title'] : ''; ?>"
                                                     name="title" id="title" required>
                                             </div>
                                         </div>
                                         <div class="col-5">
                                             <div class="form-group ">
                                                 <label for="example-text-input" class=" col-form-label">Select
                                                     Category</label>
                                                 <div>
                                                     <select class="custom-select " id="category_id" name="category_id"
                                                         required>
                                                         <option value="">Select Category</option>
                                                         <?php foreach ($category as $key => $value) {
                                                                if ((isset($course['category_id']) && $course['category_id'] == $value['id'])) {
                                                                    $selected = "selected";
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                            ?>
                                                             <option value="<?= $value['id'] ?>" <?= $selected; ?>>
                                                                 <?= $value['category_name'] ?></option>
                                                         <?php } ?>
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="form-group ">
                                                 <label for="example-text-input" class="col-form-label">Select Course
                                                     Instructor</label>

                                                 <select class="custom-select form-control form-control-sm"
                                                     id="instructor_id" name="instructor_id" required>
                                                     <option disabled>Select Instructor</option>
                                                     <option value="101">John Doe</option>
                                                     <option value="102">Jane Smith</option>
                                                     <option value="103">Michael Johnson</option>
                                                     <option value="104">Emily Davis</option>
                                                     <option value="105">Richard Brown</option>
                                                 </select>

                                             </div>
                                             <div class="form-group ">
                                                 <label for="example-text-input" class="col-form-label">Select Course
                                                     Type</label>

                                                 <select class="custom-select form-control form-control-sm"
                                                     id="course_type" name="course_type" required>
                                                     <option value="" <?= (isset($course['course_type']) && $course['course_type'] == null) ? 'selected' : ''; ?>>Select Course Type</option>
                                                     <option value="0" <?= (isset($course['course_type']) && $course['course_type'] == 0) ? 'selected' : ''; ?>>Offline</option>
                                                     <option value="1" <?= (isset($course['course_type']) && $course['course_type'] == 1) ? 'selected' : ''; ?>>Online</option>
                                                 </select>

                                             </div>

                                             <div class="form-group ">
                                                 <label for="example-text-input" class=" col-form-label">Select
                                                     Skill</label>
                                                 <div>
                                                     <select class="custom-select " id="skill_id" name="skill_id[]" multiple
                                                         required>
                                                         <option value="">Select Select</option>
                                                         <?php foreach ($skill as $key => $value) {
                                                                if ((isset($course['skill_id']) && $course['skill_id'] == $value['id'])) {
                                                                    $selected = "selected";
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                            ?>
                                                             <option value="<?= $value['id'] ?>" <?= $selected; ?>>
                                                                 <?= $value['name'] ?></option>
                                                         <?php } ?>
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="form-group ">
                                                 <label>Select Language</label>
                                                 <div>
                                                     <select id="language" name="language" required
                                                         class="form-control select2">
                                                         <option value="">Language</option>
                                                         <option value="1"
                                                             <?= (isset($course) && $course['language'] == 1) ? 'selected' : ''; ?>>
                                                             English</option>
                                                         <option value="2"
                                                             <?= (isset($course) && $course['language'] == 2) ? 'selected' : ''; ?>>
                                                             Marathi</option>

                                                     </select>
                                                 </div>
                                             </div>

                                             <div class="form-group ">
                                                 <label>Course Image</label>
                                                 <div>
                                                     <input type="file" class="form-control" name="image" id="image">
                                                     <?= (isset($course)) ? '<img src="' . base_url() . COURSE_IMAGES . $course['image'] . '" width="80">' : ''; ?>
                                                 </div>
                                             </div>
                                             <div class="row">
                                                 <div class="form-group col-6">
                                                     <label>Certificate</label>
                                                     <div>
                                                         <input type="radio" required value="1" name="certificate"
                                                             <?= (isset($course) && $course['certificate'] == 1) ? 'checked' : ''; ?>
                                                             checked>
                                                         &nbsp;&nbsp;YES&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                         <input type="radio" required value="0" name="certificate"
                                                             <?= (isset($course) && $course['certificate'] == 0) ? 'checked' : ''; ?>>
                                                         &nbsp;&nbsp;NO
                                                     </div>
                                                 </div>
                                                 <div class="form-group col-6">
                                                     <label> Assessment</label>
                                                     <div>
                                                         <input type="radio" required value="1" name="assessment"
                                                             <?= (isset($course) && $course['assessment'] == 1) ? 'checked' : ''; ?>
                                                             checked>
                                                         &nbsp;&nbsp;YES&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                         <input type="radio" required value="0" name="assessment"
                                                             <?= (isset($course) && $course['assessment'] == 0) ? 'checked' : ''; ?>>
                                                         &nbsp;&nbsp;NO
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-7">
                                             <div class="form-group">
                                                 <label>Notes</label>
                                                 <div>
                                                     <textarea class="form-control summernote" rows="2" name="notes"
                                                         id="notes"><?= (isset($course)) ? $course['notes'] : ''; ?></textarea>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="form-group col-md-12">
                                             <label>Benefits</label>
                                             <div>
                                                 <textarea class="form-control summernote" rows="2" name="benefits"
                                                     id="benefits"><?= (isset($course)) ? $course['benefits'] : ''; ?></textarea>
                                             </div>
                                         </div>

                                         <div class="form-group col-md-6">
                                             <label>Status</label>
                                             <div>

                                                 <input type="radio" required value="1" name="status"
                                                     <?= (isset($course['status']) && $course['status'] == 1) ? 'checked' : ''; ?>
                                                     checked>
                                                 &nbsp;&nbsp;Active&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                 <input type="radio" required value="0" name="status"
                                                     <?= (isset($course['status']) && $course['status'] == 0) ? 'checked' : ''; ?>>
                                                 &nbsp;&nbsp;In-Active
                                             </div>
                                         </div>
                                         <div class="form-group col-md-6">
                                             <label>Is Free </label>
                                             <div>

                                                 <input type="radio" required value="1" name="is_free"
                                                     <?= (isset($course['is_free']) && $course['is_free'] == 1) ? 'checked' : ''; ?>>
                                                 &nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                 <input type="radio" required value="0" name="is_free"
                                                     <?= (isset($course['is_free']) && $course['is_free'] == 0) ? 'checked' : 'checked'; ?>>
                                                 &nbsp;&nbsp;No
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>


                             <hr>
                             <h4 class="mt-50 header-title m-b-20">Add Duration
                                 <input data-repeater-create type="button" class="btn btn-success mo-mt-2"
                                     value="Add" style="float: right;">
                             </h4>
                             <hr>
                             <div data-repeater-list="course">
                                 <?php if (isset($course_duration[0])): ?>
                                     <?php foreach ($course_duration as $key => $duration_format): ?>
                                         <div data-repeater-item class="row m-b-20">
                                             <input type="hidden" name="id" id="id"
                                                 value="<?= (isset($duration_format['id'])) ? $duration_format['id'] : ''; ?>">


                                             <div class="form-group col-lg-3">
                                                 <label for="duration_id">Duration</label>
                                                 <select id="duration_id" name="duration_id" required
                                                     class="form-control">
                                                     <option value="">Select</option>
                                                     <?php foreach ($duration as $key => $value) {
                                                            if ((isset($duration_format['duration_id']) && $duration_format['duration_id'] == $value['id'])) {
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                        ?>
                                                         <option value="<?= $value['id'] ?>" <?= $selected; ?>>
                                                             <?= $value['name'] ?></option>
                                                     <?php  }  ?>
                                                 </select>
                                             </div>
                                             <div class="form-group col-lg-2">
                                                 <label for="offer_type">Select Offer Type</label>
                                                 <select id="offer_type" name="offer_type" required class="form-control"
                                                     onchange="getplanamount(this.name)">
                                                     <option value="">Select</option>
                                                     <option value="1"
                                                         <?= (isset($duration_format['offer_type']) && $duration_format['offer_type'] == 1) ? 'selected' : ''; ?>>
                                                         Flat</option>
                                                     <option value="2"
                                                         <?= (isset($duration_format['offer_type']) && $duration_format['offer_type'] == 2) ? 'selected' : ''; ?>>
                                                         Percentage</option>
                                                 </select>
                                             </div>
                                             <div class="form-group col-lg-2">
                                                 <label>Offer Amount</label>
                                                 <input class="form-control" type="text"
                                                     value="<?= (isset($duration_format['offer_amount'])) ? $duration_format['offer_amount'] : ''; ?>"
                                                     name="offer_amount" id="offer_amount"
                                                     onkeyup="getplanamount(this.name)">
                                             </div>
                                             <div class="form-group col-lg-2">
                                                 <label>Original price</label>
                                                 <input class="form-control" type="text"
                                                     value="<?= (isset($duration_format['strike_thr_price'])) ? $duration_format['strike_thr_price'] : ''; ?>"
                                                     name="strike_thr_price" id="strike_thr_price"
                                                     onkeyup="getplanamount(this.name)">

                                             </div>
                                             <div class="form-group col-lg-2">
                                                 <label>Offer Price</label>
                                                 <input class="form-control" type="text"
                                                     value="<?= (isset($duration_format['price'])) ? $duration_format['price'] : ''; ?>"
                                                     name="price" id="price">
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


                                         <div class="form-group col-lg-3 ">
                                             <label for="duration_id">Duration</label>
                                             <select id="duration_id" name="duration_id" required
                                                 class="form-control">
                                                 <option value="">Select</option>
                                                 <?php foreach ($duration as $key => $value) { ?>

                                                     <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                 <?php  }  ?>
                                             </select>
                                         </div>
                                         <div class="form-group col-lg-2">
                                             <label for="offer_type">Select Offer Type</label>
                                             <select id="offer_type" name="offer_type" required
                                                 class="form-control">
                                                 <option value="">Select</option>
                                                 <option value="1"> Flat</option>
                                                 <option value="2">Percentage</option>
                                             </select>
                                         </div>
                                         <div class="form-group col-lg-2">
                                             <label>Offer Amount</label>
                                             <input class="form-control" type="text" value="" name="offer_amount"
                                                 id="offer_amount">
                                         </div>
                                         <div class="form-group col-lg-2">
                                             <label>Original price</label>
                                             <input class="form-control" type="text" value=""
                                                 name="strike_thr_price" id="strike_thr_price"
                                                 onkeyup="getplanamount(this.name)">

                                         </div>
                                         <div class="form-group col-lg-2">
                                             <label>Offer Price</label>
                                             <input class="form-control" type="text" value="" name="price"
                                                 id="price">
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
             <!-- end row -->
         </div>
         <!-- container-fluid -->
     </div>
 </div>
 <!-- content -->
 <?php init_footer(); ?>

 <script src="<?= base_url(); ?>assets/plugins/jquery-repeater/jquery.repeater.min.js">
 </script>
 <script src="<?= base_url(); ?>assets/pages/form-repeater.int.js"></script>
 <script src="https://cdn.ckeditor.com/4.15.0/full-all/ckeditor.js"></script>
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

     function getplanamount(name) {

         let str = name;
         const myArr = str.split("[");
         var offset = myArr[1]

         var offset_f = offset.replace("]", "");

         var offer_type = $('select[name="course[' + offset_f + '][offer_type]"]').val();
         var offer_amount = $('input[name="course[' + offset_f + '][offer_amount]"]').val();
         var strike_thr_packageAmount = $('input[name="course[' + offset_f + '][strike_thr_price]"]').val();
         // alert(offer_type);
         if (offer_type) {
             if (offer_type == 1) {
                 var amt = parseFloat(strike_thr_packageAmount - offer_amount);
                 $('input[name="course[' + offset_f + '][price]"]').val(amt);

             } else if (offer_type == 2) {
                 var amt = parseFloat(strike_thr_packageAmount - ((strike_thr_packageAmount * offer_amount) / 100));
                 $('input[name="course[' + offset_f + '][price]"]').val(amt);
             } else {
                 $('input[name="course[' + offset_f + '][price]"]').val(strike_thr_packageAmount);
             }

         } else {
             $('input[name="course[' + offset_f + '][price]"]').val(strike_thr_packageAmount);
         }
     }
 </script>