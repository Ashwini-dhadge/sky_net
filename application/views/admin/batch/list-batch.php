<?php init_header(); ?>

<div class="main-content">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between ">
                        <h4 class="my-3 px-3">Batches</h4>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/Batch') ?>">Batches</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Listing</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light float-right batchModal"> Add Batch</a>
                                <p class="text-danger font-13 mb-1"><strong>Note:</strong> When this batch allocate any student then this batch cannot delete</p>
                                <h4 class="card-title"><?= $title ?></h4>
                                <?php $this->load->view(ADMIN . BATCH . 'table-batch'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="_batch"></div>
</div>
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/custom-js/batch.js?v=1.0.0"></script>
