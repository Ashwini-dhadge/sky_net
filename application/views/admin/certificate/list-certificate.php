<?php init_header(); ?>
<style>
    .select2-selection--multiple .select2-selection__choice {
        background-color: #CA151C !important;
        border: 1px solid #ec4561 !important;
        border-radius: 4px !important;
        padding: 0 7px !important;
        color: white !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #CA151C !important;
    }
</style>
<div class="main-content">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <!-- TABLE -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mt-4">
                            <div class="card-body">
                                <h4 class="card-title"><?= $title ?></h4>
                                <div class="d-flex align-items-center mb-2">
                                    <select id="filter_student" class="form-control select2 w-25 me-2">
                                        <option value="">Select Student</option>
                                        <?php foreach ($users as $c) { ?>
                                            <option value="<?= $c['id']; ?>">
                                                <?= $c['first_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>

                                    <button type="button" class="btn btn-primary ml-3" id="openCertificateModal">
                                        <i class="fas fa-award"></i> Certificate
                                    </button>
                                </div>
                                <?php $this->load->view(ADMIN . CERTIFICATE . 'table-certificate'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="certificateModal" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Certification</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" style="padding: 10px;" id="certificateModalBody">
                                <div class="text-center">
                                    <i class="fas fa-spinner fa-spin"></i> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php init_footer(); ?>

<script src="<?= base_url(); ?>assets/js/custom-js/certificate.js"></script>