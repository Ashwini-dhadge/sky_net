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
                    <div class="col-12 d-flex justify-content-between ">
                        <h4 class="my-3 px-3">Forum</h4>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/Forum/pending/') ?>">Forum</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Listing</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card ">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 from-group">
                                        <select id="statusFilter" class="form-control w-50">
                                            <option value="" selected>All</option>
                                            <option value="0" >Pending</option>
                                            <option value="1">Approved</option>
                                            <option value="2">Rejected</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-muted small">
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