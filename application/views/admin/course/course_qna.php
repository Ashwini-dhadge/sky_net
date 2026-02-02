<?php init_header(); ?>

<div class="main-content">
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">

                <h4 class="page-title"><?= $title ?></h4>

                <input type="hidden" id="course_id" value="<?= $course_id ?>">

                <table id="courseQnaTable" class="table table-striped dt-responsive" width="100%"></table>

            </div>
        </div>
    </div>
</div>

<!-- ANSWER MODAL -->
<div class="modal fade" id="answerModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Answer Question</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <p id="questionText"></p>
                <input type="hidden" id="qna_id">
                <textarea id="answerText" class="form-control" rows="5"></textarea>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="saveAnswer()">Save</button>
            </div>

        </div>
    </div>
</div>

<?php init_footer(); ?>

<script src="<?= base_url(); ?>assets/js/custom-js/course-qna.js"></script>