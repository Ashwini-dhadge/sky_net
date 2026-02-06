<?php init_header(); ?>

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

                                    <!-- <div class="col-md-3">
                                        <label>Status</label>
                                        <select id="answerFilter" class="form-control">
                                            <option value="all">All</option>
                                            <option value="answered">Answered</option>
                                            <option value="unanswered">Unanswered</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Time</label>
                                        <select id="dateFilter" class="form-control">
                                            <option value="all">All Time</option>
                                            <option value="today">Today</option>
                                            <option value="yesterday">Yesterday</option>
                                            <option value="week">This Week</option>
                                            <option value="month">This Month</option>
                                            <option value="year">This Year</option>
                                        </select>
                                    </div> -->

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