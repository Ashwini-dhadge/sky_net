<?php init_header(); ?> 
  
      <div class="main-content">
 <!-- ============================================================== -->
 <!-- Start right Content here -->
 <!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
       <div class="container-fluid">
          <div class="page-title-box">
         <div class="row align-items-center">
            <div class="col-sm-6">
               <h4 class="page-title">Lesson Video </h4>
            </div>
            <div class="col-sm-6">
             <div class="float-right d-none d-md-block">
                <button type="button" class="btn btn-secondary waves-effect waves-light mb-0" onclick="window.history.back()">Back</button>
             </div>
            </div>
         </div>
      </div>
           <div class="row">
              <div class="col-lg-12">
                <div class="card  mb-4 mt-4">
                      <div class="card-body"> 
                        <!-- <a href="<?= base_url(ADMIN.'Video/video'); ?>" class="btn btn-primary waves-effect waves-light float-right">Add Video</a> -->
                        
                          <h4 class="card-title">Table MCQ Aginst</h4><br><hr>
                          <input type="hidden" name="lesson_video_id" id="lesson_video_id" value="<?= $lesson_video_id; ?>">
                          <input type="hidden" name="lesson_id" id="lesson_id" value="<?= $lesson_id; ?>">
                         <table id="mcq_csvtable" class="table table-striped dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;" >
                        </table> <br>

                      </div>
                  </div>
              </div>
          </div>
          <?php

          if(count($question)):

           ?>
           <div class="row">
              <div class="col-lg-12">
                <div class="card  mb-4 mt-4">
                      <div class="card-body"> 
                   
                          <h4 class="card-title">MCQ Question Not Uploaded</h4><br><hr>
                        
                         <table class="table table-striped dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;" >
                          <tr>
                            <th>No</th>
                            <th>skill id</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Explan</th>
                            <th>Option 1</th>
                            <th>Option 2</th>
                            <th>Option 3</th>
                            <th>Option 4</th>
                            <th>Option 5</th>
                            <th>Reasons</th>

                          </tr>
                      <?php
                         foreach ($question as $key => $value) {
                                if($value['reason']){
                       ?>
                       <tr>
                         <td><?= $key++; ?></td>
                         <td><?=  $value['skill_id']; ?></td>
                         <td><?=  $value['question']; ?></td>
                         <td><?=  $value['answer']; ?></td>
                         <td><?=  $value['explantion']; ?></td>
                         <td><?=  $value['option_1']; ?></td>
                         <td><?=  $value['option_2']; ?></td>
                         <td><?=  $value['option_3']; ?></td>
                         <td><?=  $value['option_4']; ?></td>
                        <td><?=  $value['option_5']; ?></td>
                        <td><?=  $value['reason']; ?></td>


                       </tr>
                        <?php
                           }
                         }
                         ?>
                        </table> <br>

                      </div>
                  </div>
              </div>
          </div>
         <?php
              endif;
          ?>
</div>
<div id="_edit_mcq"></div>
<?php init_footer(); ?>        
<script src="<?= base_url(); ?>assets/js/custom-js/video.js"></script>        
 <script src="<?= base_url(); ?>assets/js/custom-js/mcq.js"></script> 