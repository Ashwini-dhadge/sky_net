 <br>
 <br>
 <hr>

 <table class="table table-borderless" id="questionTable">
     <tbody id="questionBody">

         <tr>
             <td style="width:7%">
                 <small>Loading...</small>
             </td>
             <td>Loading questions...</td>
         </tr>

     </tbody>
 </table>
 <div id="forumPager" class="mt-3 mb-4 text-right"></div>

 <div class="modal fade" id="answerModal">
     <div class="modal-dialog modal-xl modal-dialog-scrollable">
         <div class="modal-content ">
             <div class="modal-header ">
                 <div>
                     <h4 class="modal-title mb-1">
                         <i class="fa fa-comments mr-2"></i>
                         Question Answers
                     </h4>

                     <div class="small">
                         <strong>Asked By:</strong>
                         <span id="askedByName" class="font-weight-bold text-primary"></span>
                     </div>
                 </div>

                 <button class="close " data-dismiss="modal">
                     &times;
                 </button>
             </div>
             <div class="px-4 pt-3 pb-2 border-bottom bg-light">
                 <div class="font-weight-bold text-muted small mb-1">
                     Question
                 </div>
                 <div id="modalQuestionText" class="p-3 rounded bg-white shadow-sm" style="font-size:15px;"> </div>
             </div>
             <div class="modal-body">
                 <div class="mb-3 text-right">
                     <button class="btn btn-success" id="openAnswerEditor">
                         <i class="fa fa-plus mr-1"></i>
                         Add Answer
                     </button>
                 </div>

                 <div class="card border-0 shadow-sm">
                     <div class="card-body">
                         <table id="answersTable" class="table table-hover table-striped table-bordered" style="width:100%">
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <div class="modal fade" id="answerEditorModal">
     <div class="modal-dialog modal-xl">
         <div class="modal-content ">
             <div class="modal-header">
                 <h5 class="modal-title">
                     <i class="fa fa-pen mr-2"></i>
                     Write Answer
                 </h5>
                 <button class="close" data-dismiss="modal">&times;</button>
             </div>

             <div class="modal-body">
                 <textarea id="newAnswer"></textarea>
             </div>

             <div class="modal-footer">
                 <button class="btn btn-secondary"
                     data-dismiss="modal">
                     Cancel
                 </button>
                 <button class="btn btn-success px-4"
                     id="submitAnswerBtn">
                     <i class="fa fa-paper-plane mr-1"></i>
                     Submit Answer
                 </button>
             </div>

         </div>
     </div>
 </div>


 <script src="https://cdn.ckeditor.com/4.15.0/full-all/ckeditor.js"></script>

 <script>
     CKEDITOR.replace('newAnswer', {
         height: 220,

     });
 </script>