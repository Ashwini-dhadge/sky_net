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
                        <a href="<?= base_url(ADMIN.'Course/Course'); ?>" class="btn btn-primary waves-effect waves-light float-right">Add Course</a>
                        
                          <h4 class="card-title"><?= $title ?></h4>
                         <?php $this->load->view(ADMIN.COURSE.'table-course'); ?>   
                      </div>
                  </div>
              </div>
          </div>
</div>
<?php init_footer(); ?>        
<script src="<?= base_url(); ?>assets/js/custom-js/course.js"></script>        
 