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
                    <div class="col-12 d-flex justify-content-between ">
                        <h4 class="my-3 px-3">Categories</h4>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/Category') ?>">Categories</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Listing</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light float-right categoryModal"> Add Category</a>
                                <?php $this->load->view(ADMIN . CAT . 'table-category'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="_category"></div>
</div>
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/custom-js/category.js?v=1.0.0"></script>