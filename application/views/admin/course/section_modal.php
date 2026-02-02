    <div class="modal fade bs-example-modal-xl" id="SModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable" role="document">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title">Section Add</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
       <form class="custom-validation repeater " action="<?= base_url('admin/course/courseSection');?>" method="post" id="formProduct">
       <input type="hidden" name="course_id" id="course_id" value="<?= $course[0]['id']?>">
       <input type="hidden" name="id" id="id" value="">

                   <div class="row">
                              
                                 <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Title</label>                                            
                                           <input type="text" class="form-control"  placeholder="Title..." name="title" id="title"  />                              
                                        </div>
                                    </div>
                                    
                                </div>
                                  <div class="col-md-12" >
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Sku</label>                                            
                                           <input type="number" class="form-control"  placeholder="Order..." name="order" id="order" value="<?= $number_section; ?>"  />                              
                                        </div>
                                    </div>
                                    
                                </div>
                                   
                                   
                                   
                                  
                                                 <div class="divider"></div>
                                </div>
                                <div class="row">
                                        <div class="form-group mb-0 col-md-12"  >
                                            <div class="col-md-6  mb-3" style="float: right;">
                                                <button type="submit" id="submit" class="btn btn-primary waves-effect waves-light mr-1"  >
                                                    Submit
                                                </button>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </form>
    </div>
    </div>
    </div>
</div>