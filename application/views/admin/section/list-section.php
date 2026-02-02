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
                    <select id="filter_course" class="form-control select2">
                      <option value="">All Courses</option>
                      <?php foreach ($course as $c) { ?>
                        <option value="<?= $c['id']; ?>"><?= $c['title']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-8 text-right">
                    <a href="<?= base_url(ADMIN . 'Section/Section'); ?>"
                      class="btn btn-primary waves-effect waves-light float-right">Add Section</a>
                  </div>
                </div>
                <?php $this->load->view(ADMIN . SECTION . 'table_section'); ?>
              </div>
            </div>
          </div>
        </div>

      </div>
      <?php init_footer(); ?>
      <script src="<?= base_url(); ?>assets/js/custom-js/section.js"></script>