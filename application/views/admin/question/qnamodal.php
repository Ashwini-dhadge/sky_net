<div class="modal fade" id="qnaModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header ">
                <h5 class="modal-title">
                    <i class="fas fa-question-circle mr-1"></i> Answer Question
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="qna_id">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Asked By</label>
                        <div id="askedByBox" class="border rounded p-2 "></div>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Answered By</label>
                        <div id="answeredByBox" class="border rounded p-2 "></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Question</label>
                    <div id="questionText" class="border rounded p-3 bg-light"></div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Your Answer</label>
                    <textarea id="answerText" class="form-control" rows="5"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success" onclick="saveAnswer()">
                    <i class="fas fa-save mr-1"></i> Save Answer
                </button>
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.15.0/full-all/ckeditor.js"></script>
<script>
    CKEDITOR.replace('answerText', {
        height: 220
    });
</script>