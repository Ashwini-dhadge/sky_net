 <br>
 <hr>

 <div class="table-responsive">
     <table id="pendingTable"
         class="table table-hover table-striped table-bordered dt-responsive nowrap"
         style="width:100%">
     </table>

 </div>

 <div class="modal fade" id="rejectModal" tabindex="-1">
     <div class="modal-dialog modal-md">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Reject Question</h5>
                 <button type="button" class="close" data-dismiss="modal">
                     &times;
                 </button>
             </div>
             <div class="modal-body">
                 <input type="hidden" id="reject_forum_id">

                 <label>Reason for rejection</label>
                 <textarea id="reject_reason" class="form-control" rows="4" placeholder="Enter reason..." required></textarea>
             </div>
             <div class="modal-footer">
                 <button class="btn btn-secondary" data-dismiss="modal">
                     Cancel
                 </button>

                 <button class="btn btn-danger" id="confirmReject">
                     Reject
                 </button>
             </div>
         </div>
     </div>
 </div>