<?php init_header(); ?>
<style>
    .btn-group .btn {
        border-radius: 4px !important;
        margin-right: 3px;
    }

    .badge {
        font-size: 12px;
        letter-spacing: .4px;
    }

    .table-hover tbody tr:hover {
        background: #f7fbff;
    }
</style>
<div class="main-content">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card mb-4 mt-4">
                            <div class="card-body">
                                <h4 class="card-title"><?= $title ?></h4>
                                <div class="mb-3 text-muted small">
                                    (Pending questions require Super Admin approval)
                                </div>
                                <?php $this->load->view(ADMIN . FORUM . 'table-pending'); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/custom-js/forum.js"></script>
