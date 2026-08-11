<?php init_header(); ?>

<div class="main-content mb-5">
  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
  <div class="content-page">
    <!-- Start content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 d-flex justify-content-between ">
            <h4 class="my-3 px-3">Courses</h4>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
              <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/Course/') ?>">Courses</a></li>
                <li class="breadcrumb-item active" aria-current="page">Listing</li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card  mb-4 ">
              <div class="card-body">
                <a href="<?= base_url(ADMIN . 'Course/Course'); ?>" class="btn btn-primary waves-effect waves-light float-right">Add Course</a>
                <h4 class="card-title"><?= $title ?></h4>
                <select id="course_type_filter" class="form-control" style="width:20%;">
                  <option value="">All Courses</option>
                  <option value="1">Online Courses</option>
                  <option value="0">Offline Courses</option>
                </select>
                <?php $this->load->view(ADMIN . COURSE . 'table-course'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_footer(); ?>


<script src="<?= base_url(); ?>assets/js/custom-js/course.js"></script>