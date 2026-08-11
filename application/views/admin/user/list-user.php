<?php init_header(); ?>
<style>
    .student-name-wrap {
        white-space: normal !important;
        word-break: break-word;
        display: block;
        line-height: 18px;
    }
</style>

<div class="main-content">
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between ">
                        <h4 class="my-3 px-3">Users</h4>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/User/') ?>">Users</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Listing</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card  mb-4">
                            <div class="card-body">
                                <?php
                                if ($role == 2) {
                                ?>
                                    <a href="<?= base_url(ADMIN . 'User/add_user/2'); ?>"
                                        class="btn btn-primary float-right">Add Users</a>
                                <?php
                                } elseif ($role == 4) {
                                ?>
                                    <a href="<?= base_url(ADMIN . 'User/add_user/4'); ?>"
                                        class="btn btn-primary float-right">Add Instructor</a>
                                <?php
                                }
                                ?>
                                <!-- <h4 class="card-title"><?= $title ?></h4> -->
                                <?php $this->load->view(ADMIN . USER . 'table-user'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/custom-js/user.js"></script>
<!-- Plugins js -->