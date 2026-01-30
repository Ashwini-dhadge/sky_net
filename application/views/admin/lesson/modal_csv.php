  <div id="mcqModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog ">
        <div class="modal-content">
           <div class="modal-header">
              <h5 class="modal-title mt-0" id="myModalLabel"><?= $sub_title; ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
           </div>
          <form method="post" action="<?= base_url(ADMIN.'Import/importcsv')?>" id="categoryFrm" enctype="multipart/form-data">
            <div class="modal-body">
            
                 <h4>Important Notes</h4>CSV Import Download Click Here.. Button On The Table Video and for better Data import. below Question Set download add it.<hr>
               <ul class="list-group list-group-flush">
                      <li class="list-group-item">1)MCQ SAMPLE <a href="<?= base_url(); ?>admin/Import/download_mcq_csv">Download MCQ QUESTION Master </a></li>
                    </ul> 
              <form method="post" action="<?= base_url() ?>Import/importcsv" enctype="multipart/form-data">
                  <input type="file" name="userfile" ><br><br><br>
                    <input type="hidden" name="lesson_id" id="lesson_id" value="<?= $lesson_id ?>">
                    <input type="hidden" name="lesson_video_id" id="lesson_video_id" value="<?= $lesson_video_id ?>">
                  <input type="submit" name="submit" value="UPLOAD" class="btn btn-primary">

              </form>
            </div> 
          
          </form>
        </div>
        <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
  </div>