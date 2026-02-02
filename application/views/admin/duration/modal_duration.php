<style>
  @media (min-width: 992px){  .modal-lg, .modal-xl { max-width: 1000px;  }  }
  b, strong { font-weight: 600;}
  #_cate_image,#_parent_cate{display: none;}
</style>
<?php
//print_r($product);die;
?>
<!-- Inventory modal content -->
  <div id="durationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog ">
        <div class="modal-content">
           <div class="modal-header">
              <h5 class="modal-title mt-0" id="myModalLabel"><?= $sub_title; ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
           </div>
          <form method="post" action="<?= base_url(ADMIN.'DurationMaster/add')?>" id="categoryFrm" enctype="multipart/form-data">
            <div class="modal-body">
              <input type="hidden" name="id" id="id" value="<?= ($duration)? $duration['id'] : '' ?>">
              <div class="form-group col-md-12">
                <label>Duration</label>
                <div>
                  <input  type="text" class="form-control" required placeholder=" Duration Name" name="name" value="<?= ($duration)? $duration['name'] : ''; ?>">
                </div>
              </div>
                <div class="form-group col-md-12">
                <label>Number of Days</label>
                <div>
                  <input  type="number" class="form-control" required placeholder=" Number of Days" name="no_of_days" value="<?= ($duration)? $duration['no_of_days'] : ''; ?>">
                </div>
              </div>
                
               

            
           

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
              <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
<script src="<?= base_url(); ?>assets/js/custom-js/duration.js?v=1.0.0"></script>
