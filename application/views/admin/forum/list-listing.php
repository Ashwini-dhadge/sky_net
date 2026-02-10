<?php init_header(); ?>
<style>
    .q-card-pro {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 16px 18px;
        margin-bottom: 14px;
        transition: .15s;
    }

    .q-card-pro:hover {
        border-color: #c79e9e;
    }

    .q-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .q-title {
        font-size: 17px;
        font-weight: 600;
        color: #b75656;
    }

    .q-meta {
        font-size: 12px;
        color: #6b7280;
        margin-top: 3px;
    }

    .q-user {
        font-weight: 600;
    }

    .dot {
        display: inline-block;
        width: 3px;
        height: 3px;
        background: #9ca3af;
        border-radius: 50%;
        margin: 0 7px;
    }

    .q-desc {
        margin-top: 10px;
        font-size: 14px;
        color: #374151;
        line-height: 1.6;
    }

    .q-footer {
        margin-top: 12px;
        /* display: flex;
        justify-content: space-between; */
        align-items: center;
    }

    .tag-pill {
        background: #c9c9c9;
        color: #000000;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 11px;
        margin-right: 5px;
    }

    .q-actions .btn {
        margin-top: 2rem;
        border: #b75656 solid 1px;
        margin-right: 5px;
    }

    .vis-pill {
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
        cursor: pointer;
        border: 1px solid transparent;
    }

    .vis-pill.on {
        background: #ecfdf5;
        color: #047857;
        border-color: #a7f3d0;
    }

    .vis-pill.off {
        background: #f3f4f6;
        color: #374151;
        border-color: #e5e7eb;
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
                                <div class="row ">
                                    <div class="col-md-12 align-self-end">
                                        <?php if ($this->session->userdata('role') == 1) { ?>
                                            <button type="button" class="btn btn-primary float-right addQuestion" data-toggle="modal" data-target="#addQuestion">
                                                Add Question
                                            </button>
                                        <?php } ?>
                                    </div>

                                </div>
                                <?php $this->load->view(ADMIN . FORUM . 'table-listing'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addQuestion">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="fa fa-question mr-2"></i>
                                    Add Forum Question
                                </h5>
                                <button class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="questionForm">
                                    <div class="row">
                                        <div class="col-lg-6" style="border-right: 0.5 solid #ddd;">
                                            <div class="form-group mb-3">
                                                <label>Question</label>
                                                <textarea name="question" id="questionText" class="form-control" rows="2" placeholder="Enter Question" required></textarea>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Tags</label>
                                                <select class="custom-select" id="tags_input" name="tags_input[]"
                                                    multiple required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label>Description</label>
                                                <textarea name="description" id="description" class="form-control" rows="5" placeholder="description" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="submitQuestion">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_footer(); ?>
<script>
    $("#tags_input").select2({
        tags: true,
        tokenSeparators: [','],
        placeholder: "Type and press Enter to add tag",
        width: '100%'
    });
</script>
<script src="<?= base_url(); ?>assets/js/custom-js/forum.js"></script>