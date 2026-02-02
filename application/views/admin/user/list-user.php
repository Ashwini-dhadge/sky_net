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
                                <?php
                if ($role == 2) {
                ?>
                                <a href="<?= base_url(ADMIN . 'User/add_user'); ?>"
                                    class="btn btn-primary waves-effect waves-light float-right">Add Users</a>
                                <?php
                } elseif ($role == 4) {
                ?>
                                <a href="<?= base_url(ADMIN . 'User/add'); ?>"
                                    class="btn btn-primary waves-effect waves-light float-right">Add Instructor</a>
                                <?php

                }
                ?>
                                <h4 class="card-title"><?= $title ?></h4>
                                <?php $this->load->view(ADMIN . USER . 'table-user'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php init_footer(); ?>
            <script src="<?= base_url(); ?>assets/js/custom-js/user.js"></script>
            <!-- Plugins js -->