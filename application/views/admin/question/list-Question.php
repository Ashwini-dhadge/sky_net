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
                                <div class="row">
                                    <div class="col-md-4">
                                        <select id="filter_course" class="form-control select2">
                                            <option value="">All Courses</option>
                                            <?php foreach ($courses as $c) { ?>
                                                <option value="<?= $c['id']; ?>">
                                                    <?= $c['title']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="filter_unanswered">
                                            <label class="form-check-label" for="filter_unanswered">
                                                Unanswered First
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <?php $this->load->view(ADMIN . QUESTION . 'table-question'); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view(ADMIN . QUESTION . 'qnamodal'); ?>

<?php init_footer(); ?>

<script src="<?= base_url(); ?>assets/js/custom-js/question.js"></script>