<?php init_header(); ?>
<?php  if (isset($category)) {
            $category = $category[0];
        }
   //echo "<pre>";print_r($parentstaff);die();   
?>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Category</h4>
                                <hr>
                                  <form class="custom-validation" action="<?= base_url('admin/category/category');?>" method="post" enctype="multipart/form-data" >
                                    <input type="hidden" name="id" id="id" value="<?= (isset($category))? $category['id'] : '' ; ?>">
                                       <div class="form-group col-md-6">
                                          <label>Category Name</label>
                                          <div>
                                            <input  type="text" class="form-control" required placeholder=" Category Name" name="category_name" value="<?= (isset($category))? $category['category_name'] :''; ?>">
                                        </div>
                                        <div class="form-group col-md-6" >
                <label>Category Level</label>
                <div>
                  <select id="category_level" name="category_level" required class="form-control select2">
                    <option value="">Category Level</option>
                    <option value="1" <?= ($category && $category['category_level'] == 1)? 'selected' : ''; ?>> Parent Category</option>
                    <option value="2" <?= ($category && $category['category_level'] == 2)? 'selected' : ''; ?>> Sub Category</option>
                    <option value="3" <?= ($category && $category['category_level'] == 3)? 'selected' : ''; ?>> Sub Sub Category</option>
                  </select>
                </div>
              </div>
                                          <div class="form-group row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Slug</label>
                                            <div class="col-md-6">
                                                  <textarea  class="form-control" rows="3" name="slug" id="slug"><?= (isset($category))? $category['slug'] :''; ?></textarea>
                                            </div>
                                        </div>
                                          <div class="form-group row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Font Awesome Class </label>
                                            <div class="col-md-6">
                                                  <textarea  class="form-control" rows="3" name="font_awesome_class" id="font_awesome_class"><?= (isset($category))? $category['font_awesome_class'] :''; ?></textarea>
                                            </div>
                                        </div>
                                     
                                    
                                         
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Is Active</label>
                                            <div class="col-md-4">
                                                   <select class="form-control" name="is_active" id="is_active">
                                                    <?php 
                                                          if(isset($category['is_active'])&& $category['is_active']==1){
                                                    ?>
                                                     <option value="1" selected="selected">Yes</option>
                                                    <?php
                                                          }else{
                                                    ?>
                                                       <option value="1">Yes</option>
                                                    <?php
                                                       
                                                          }
                                                    ?>

                                                     <?php 
                                                          if(isset($category['is_active'])&& $category['is_active']==0){
                                                    ?>
                                                     <option value="0" selected="selected">No</option>
                                                    <?php
                                                          }else{
                                                    ?>
                                                       <option value="0">No</option>

                                                     <?php  
                                                          }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                             <div class="form-group row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">thumbnail</label>
                                            <div class="col-md-6">
                                                   
                                                  <div class="col-md-12">
                                                            <div class="form-group">                                                                                                          
                                                               <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="image" name="image">
                                                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                                                        </div>     
                                                                         <?php
                                                                        if(isset($category['thumbnail'])){
                                                                            ?>
                                                                              <div class="col-md-4">
                                                                                <img src="<?= base_url().CATEGORY_IMAGES.$category['thumbnail'] ?>" style="width: 30%">
                                                                              </div>
                                                                            <?php
                                                                        }
                                                                ?>               
                                                            </div>
                                                   </div>                                   
                                             
                                            </div>
                                        </div>
                                     
                                       <div class="row">
                                                                                   
                                            <div class="form-group form-group mb-0">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                                            </div>
                                        </div> 
                                   
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>
<?php init_footer(); ?>


  
