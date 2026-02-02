
        <!--  Modal content for the above example -->

        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="modalForm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Add News Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                      <form class="custom-validation repeater" action="" method="post" id="CategoryForm" >
                    <div class="modal-body">                          
                                    <input type="hidden" name="id" id="id" value="">

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 col-form-label">name</label>
                                            <div class="col-md-8">
                                               <input type="text" class="form-control" required placeholder="" id="name" name="name" value=""/>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-search-input" class="col-md-4 col-form-label">Is Active </label>
                                            <div class="col-md-8">
                                                <?php 
                                              //  echo "<pre>";
                                              //  print_r($parentcategory); die();
                                                ?>
                                                 <select class="custom-select select2"  name="is_active" id="is_active"  required  style="width: 50%;">
                                                       <option value="1">Yes</option>      
                                                        <option value="0">No</option>   
                                                 </select>
                                            </div>
                                        </div>                                    
                                        
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="submitNewsCategory"  data-dismiss="modal">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    
