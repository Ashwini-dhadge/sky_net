<style>
  @media (min-width: 992px){  .modal-lg, .modal-xl { max-width: 1000px;  }  }
  b, strong { font-weight: 600;}
  #_cate_image,#_parent_cate{display: none;}
</style>
<?php 
    // echo "<pre>";
    // print_r($que);die;
?>
<!-- Inventory modal content -->
<div id="editMcqModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0" id="myModalLabel"><?= $sub_title; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form method="post" action="<?= base_url(ADMIN.'LessonVideoMcq/editMcq')?>" id="categoryFrm" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id" value="<?= ($que)? $que['id'] : '' ?>">
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-6">
              <label>Question</label>
              <div>
                <textarea class="form-control"  name="question" rows="2"><?= $que['question']; ?></textarea>
                <!-- <input  type="text" class="form-control"   name="question" value="<?= ($que)? $que['question']: ''; ?>"> -->
              </div>
            </div>            
            <div class="form-group col-md-6">
              <label>Explanation</label>
              <div>
                <textarea class="form-control" name="explantion" rows="2"><?= $que['explantion']; ?></textarea>
              </div>
            </div>         
            <div class="form-group col-md-6" >
              <label>Select Skill </label>
              <div>
                <select id="skill_id" name="skill_id"  class="form-control select2">
                  <?php foreach ($skill_master as $key => $value): ?>
                  <option value="<?= $value['id'] ?>"  <?= (isset($que['skill_id']) && $que['skill_id'] == $value['id'])? 'selected': '';?>>
                    <?= $value['name'] ?>
                  </option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>  
            <div class="form-group col-md-6">
              <label>Option1</label>
              <div>
                <input  type="text" class="form-control"   name="option_1" value="<?= ($que)? $que['option_1'] : ''; ?>">
              </div>
            </div>
            <div class="form-group col-md-6">
              <label>Option2</label>
              <div>
                <input  type="text" class="form-control"   name="option_2" value="<?= ($que)? $que['option_2'] : ''; ?>">
              </div>
            </div>
            <div class="form-group col-md-6">
              <label>Option3</label>
              <div>
                <input  type="text" class="form-control"   name="option_3" value="<?= ($que)? $que['option_3'] : ''; ?>">
              </div>
            </div>
            <div class="form-group col-md-6">
              <label>Option4</label>
              <div>
                <input  type="text" class="form-control"   name="option_4" value="<?= ($que)? $que['option_4'] : ''; ?>">
              </div>
            </div>
            <div class="form-group col-md-6">
              <label>Option5</label>
              <div>
                <input  type="text" class="form-control"   name="option_5" value="<?= ($que)? $que['option_5'] : ''; ?>">
              </div>
            </div>
            <div class="form-group col-md-6" >
              <label>Answer</label>
              <div>
               <input type="radio"  value="1" name="answer" <?= ($que && $que['answer'] == 1)? 'checked': '';?> >
                option1&nbsp;&nbsp;
                <input type="radio"  value="2" name="answer" <?= ($que && $que['answer'] == 2)? 'checked': '';?>>
                option2&nbsp;&nbsp;
                <input type="radio"  value="3" name="answer" <?= ($que && $que['answer'] == 3)? 'checked': '';?> >
                option3&nbsp;&nbsp;
                <input type="radio"  value="4" name="answer" <?= ($que && $que['answer'] == 4)? 'checked': '';?>>
                option4&nbsp;&nbsp; 
                <input type="radio" value="5" name="answer" <?= ($que && $que['answer'] == 5)? 'checked': '';?>>
                option5&nbsp;&nbsp; 
              </div>
            </div> 

            <div class="form-group col-md-6">
              <label>Is Chanllenge</label>
              <div>
                <input type="radio"  value="1" name="is_challenge" <?= ($que && $que['is_challenge'] == 1)? 'checked': '';?> checked>
                &nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio"  value="0" name="is_challenge" <?= ($que && $que['is_challenge'] == 0)? 'checked': '';?>>
                &nbsp;&nbsp;No
              </div>
            </div>
          </div>   
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
            <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="<?= base_url(); ?>assets/js/custom-js/mcq.js?v=1.0.0"></script>
