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
            <div class="card mt-4">
              <div class="card-body">
                <h4 class="card-title"><?= $title ?></h4>
                <div class="row">
                  <div class="col-md-4">
                    <!-- <label>Filter Course</label> -->
                    <select id="filter_course" class="form-control select2">
                      <option value="">All Courses</option>
                      <?php foreach ($course as $c) { ?>
                        <option value="<?= $c['id']; ?>"><?= $c['title']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <!-- <label>Filter Section</label> -->
                    <select id="filter_section" class="form-control select2">
                      <option value="">All Sections</option>
                    </select>
                  </div>

                  <div class="col-md-4 text-right">
                    <a href="<?= base_url(ADMIN . 'Lesson/AddLesson'); ?>"
                      class="btn btn-primary waves-effect waves-light">
                      Add Lesson
                    </a>
                  </div>
                </div>

                <?php $this->load->view(ADMIN . LESSON . 'table_lesson'); ?>
              </div>
            </div>
          </div>
        </div>
        <?php init_footer(); ?>
        <script src="<?= base_url(); ?>assets/js/custom-js/lesson.js"></script>