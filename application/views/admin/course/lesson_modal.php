    <div class="modal fade bs-example-modal-xl" id="LModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title">Lesson Add</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
       <form class="custom-validation repeater " action="<?= base_url('admin/course/courseLesson');?>" method="post" id="formProduct" enctype="multipart/form-data">
        <input type="hidden" name="course_id" id="course_id" value="<?= $course[0]['id']?>">
       <input type="hidden" name="id" id="idL" value="">

                   <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Title</label>                                            
                                           <input type="text" class="form-control"  required="" placeholder="Title..." name="title" id="titleL"  />                              
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Duration</label>                                            
                                           <input type="text" class="form-control"  name="duration" id="duration"  />                              
                                        </div>
                                    </div>
                                    
                                </div>
                                 <div class="col-md-6">
                                     
                                        <div class="form-group">
                                            <label>Section</label>                                            
                                          <select class="custom-select " id="section_id" name="section_id" required>
                                                               <option value=""></option>
                                                                <?php foreach ($section as $key => $value) {
                                                                ?>
                                                                <option value="<?= $value['id'] ?>"><?= $value['title'] ?></option>
                                                                <?php    
                                                                }
                                                                ?> 
                                                                    </select>         
                                        </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>video Url</label>                                            
                                           <input type="text" class="form-control" required="true" name="video_url" id="video_url"  />                              
                                        </div>
                                    </div>
                                    
                                </div>
                                 <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>video Type</label>                                            
                                           <input type="text" class="form-control"  required="true"  name="video_type" id="video_type"  />                              
                                        </div>
                                    </div>
                                    
                                </div>
                                  <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Lesson Type</label>                                            
                                           <input type="text" class="form-control"  name="lesson_type" id="lesson_type"  />                              
                                        </div>
                                    </div>
                                    
                                </div>
                            
                                 <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Summary</label>                                            
                                           <input type="text" class="form-control"  name="summary" id="summary"  />                              
                                        </div>
                                    </div>
                                    
                                </div> 
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>SKU</label>                                            
                                           <input type="text" class="form-control"  name="order" id="order" value="<?= $number_lesson; ?>"  />                              
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                      <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Attchemnt</label>                                            
                                           <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="image" name="image">
                                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                                    </div>     
                                                     <?php
                                                    if(isset($news['image'])){
                                                        ?>
                                                          <div class="col-md-4">
                                                            <img src="<?= base_url().UPLOAD_PATH_NEWS.$news['image'] ?>" style="width: 30%">
                                                          </div>
                                                        <?php
                                                    }
                                            ?>               
                                        </div>
                                    </div>                                   
                                </div>
                                           
                                    
                                </div>
 
 

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