<?php init_header(); ?> 
  
      <div class="main-content">
 <!-- ============================================================== -->
 <!-- Start right Content here -->
 <!-- ============================================================== -->
 <div class="content-page">
    <!-- Start content -->
    <div class="content">
       <div class="container-fluid">
          
           <div class="row">
              <div class="col-lg-12">
                    <div class="card  mb-4 mt-4">
                      <div class="card-body"> 
                        <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light float-right durationModal" > Add Duration</a>
                        <h4 class="card-title"><?= $title ?></h4>
                         <?php $this->load->view(ADMIN.'duration/table-duration'); ?>  
                      </div>
                  </div>
              </div>
          </div>
</div>
<div id="_duration"></div>
<?php init_footer(); ?>        
<script src="<?= base_url(); ?>assets/js/custom-js/duration.js?v=1.0.0"></script>