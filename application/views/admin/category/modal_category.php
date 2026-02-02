<style>
  @media (min-width: 992px){  .modal-lg, .modal-xl { max-width: 1000px;  }  }
  b, strong { font-weight: 600;}
  #_cate_image,#_parent_cate{display: none;}
</style>
<?php
//print_r($product);die;
?>
<!-- Inventory modal content -->
  <div id="categoryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog ">
        <div class="modal-content">
           <div class="modal-header">
              <h5 class="modal-title mt-0" id="myModalLabel"><?= $sub_title; ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
           </div>
          <form method="post" action="<?= base_url(ADMIN.'Category/add')?>" id="categoryFrm" enctype="multipart/form-data">
            <div class="modal-body">
              <input type="hidden" name="id" id="id" value="<?= ($category)? $category['id'] : '' ?>">
              <div class="form-group col-md-12">
                <label>Category Name</label>
                <div>
                  <input  type="text" class="form-control" required placeholder=" Category Name" name="category_name" value="<?= ($category)? $category['category_name'] : ''; ?>">
                </div>
              </div>

            <!--  <div class="form-group col-md-12" >
                <label>Category Level</label>
                <div>
                  <select id="category_level" name="category_level" required class="form-control select2">
                    <option value="">Category Level</option>
                    <option value="1" <?= ($category && $category['category_level'] == 1)? 'selected' : ''; ?>> Parent Category</option>
                    <option value="2" <?= ($category && $category['category_level'] == 2)? 'selected' : ''; ?>> Sub Category</option>
                    <option value="3" <?= ($category && $category['category_level'] == 3)? 'selected' : ''; ?>> Sub Sub Category</option>
                  </select>
                </div>
              </div>-->
              <input type="hidden" value="1" name="category_level">
             <div class="form-group col-md-12">
                <label>Category Image </label>
                <div>
                  <input  type="file" class="form-control" name="category_icon" id="category_icon">
                </div>
             </div>
              <?php if ($category && $category['category_icon'] !=''): ?>
              <div class="form-group col-md-12">
                <img src="<?= base_url(CATEGORY_IMAGES.$category['category_icon']);?>" alt="" style="width: 80px;height: 80px;">
              </div>
              <?php endif ?>
              <div class="form-group col-md-12">
                <label>Status</label>
                <div>
                  <input type="radio" required value="1" name="status" <?= ($category && $category['status'] == 1)? 'checked': '';?> checked>
                  &nbsp;&nbsp;Active&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="radio" required value="0" name="status" <?= ($category && $category['status'] == 0)? 'checked': '';?>>
                  &nbsp;&nbsp;In-Active
                </div>
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
              <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
<script src="<?= base_url(); ?>assets/js/custom-js/category.js?v=1.0.0"></script>
