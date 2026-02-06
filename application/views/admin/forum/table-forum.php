 <br>
 <hr>

 <div class="table-responsive">
     <table id="forumTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
     </table>
 </div>



 <div class="modal fade" id="answerModal" tabindex="-1">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">

             <div class="modal-header ">
                 <h5 class="modal-title">Answer Question</h5>
                 <button type="button" class="close text-white" data-dismiss="modal">
                     &times;
                 </button>
             </div>

             <div class="modal-body">

                 <input type="hidden" id="forum_id">

                 <div class="form-group">
                     <label><b>Question</b></label>
                     <div id="modal_question"
                         class="border rounded p-2 bg-light"></div>
                 </div>

                 <div class="form-group">
                     <label>Your Answer</label>
                     <textarea id="modal_answer"
                         class="form-control"
                         rows="6"
                         placeholder="Type answer here..."></textarea>
                 </div>

             </div>

             <div class="modal-footer">
                 <button class="btn btn-success" id="saveAnswer">
                     Save Answer
                 </button>

                 <button class="btn btn-secondary"
                     data-dismiss="modal">
                     Close
                 </button>
             </div>

         </div>
     </div>
 </div>