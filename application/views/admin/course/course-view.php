<?php init_header(); ?> 
  <style>._status{cursor: pointer;}
    .btn-sm {
    margin: 0px 2px;
    
}
  </style>
      <div class="main-content">
 <!-- ============================================================== -->
 <!-- Start right Content here -->
 <!-- ============================================================== -->
 <div class="content-page">
    <!-- Start content -->
    <div class="content">
       <div class="container-fluid">
        <div class="page-title-box">
         <div class="row align-items-center">
            <div class="col-sm-6">
               <h4 class="page-title"><?= $title ?> </h4>
            </div>
            <div class="col-sm-6">
             <div class="float-right d-none d-md-block">
                <button type="button" class="btn btn-secondary waves-effect waves-light mb-0" onclick="window.history.back()">Back</button>
             </div>
            </div>
         </div>
      </div>
           <div class="row">
             <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body"> 
                             
                          <h4 class="card-title "><?= $course['title'];?>&nbsp;Details
                          <span class="d-print-none ">
                        <!--   <a href="<?= base_url().ADMIN.'Course/CourseDelete/'.$course['id']; ?>" class="btn btn-danger btn-sm waves-effect waves-light float-right"><i class="fas fa-trash-alt"></i></a> -->
                           <a href="<?= base_url() .ADMIN.'Course/Course/'.$course['id']; ?>" class="btn btn-primary btn-sm waves-effect waves-light float-right"><i class="fas fa-edit"></i></a></span></h4><hr>
                          <div class="">
                            <div class="row">
                              <div class="col-lg-5">
                                  <div class="float-left mr-4">
                                    <?php  $img = ($course['image'])? $course['image']:'no-image.png'; ?>
                                    <img src="<?= base_url().COURSE_IMAGES.$course['image'] ?>" alt=""  width="80%"></div>
                                    

                              </div>
                        <div class="col-lg-7">
                              <h4 class="mt-0 header-title m-b-20">Course Basic.</h4>
                              
                            <table class="table">
                                <tbody>    
                            
                                    <tr>
                                        <th scope="row" class="p-1">Category:</th>
                                        <td class="p-1"><?= $course['category_name'];?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="p-1">Title:</th>
                                        <td class="p-1"><?= $course['title'];?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="p-1">Language:</th>
                                        <?php if($course['language']==1){ ?>
                                             <td class="p-1">English</td>
                                        <?php    }else{ ?>
                                        
                                             <td class="p-1">Marathi</td>
                                        <?php      

                                            } 
                                        ?>
                                       
                                    </tr>

                                    <tr>
                                        <th scope="row" class="p-1">Skill:</th>
                                        <td class="p-1"><?= $course['name'];?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="p-1">Certificate:</th>
                                        <?php if($course['certificate']==1){ ?>
                                             <td class="p-1">YES</td>
                                        <?php    }else{ ?>
                                        
                                             <td class="p-1">NO</td>
                                        <?php      

                                            } 
                                        ?>
                                       
                                    </tr>
                                    <tr>
                                        <th scope="row" class="p-1">Assessment:</th>
                                        <?php if($course['assessment']==1){ ?>
                                             <td class="p-1">YES</td>
                                        <?php    }else{ ?>
                                        
                                             <td class="p-1">NO</td>
                                        <?php      

                                            } 
                                        ?>
                                       
                                    </tr>
                                   <!--  <tr>
                                        <th scope="row" class="p-1">Description:</th>
                                        <td class="p-1"><?= $incident['description'];?></td>
                                    </tr> -->
                                </tbody>
                            </table>
                          </div>
                        <div class="col-lg-12"><br>
                           <h4><u>Benefits:</u></h4>
                           <p><?= $course['benefits'];?></p>
                          </div>
                        </div>
                        </div>
                           
                      </div>
                  </div>
              </div>
              <div class="col-lg-12">

                    <div class="card  mb-4 mt-4">
                      <div class="card-body"> 
                        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">Duration</span> 
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#profile1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Lesson</span> 
                                                </a>
                                            </li>
                                            
                                        </ul>
        
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="tab-pane active p-3" id="home1" role="tabpanel">
                                                <p class="mb-0">
                                                   
                                                        <input type="hidden" name="d_id" id="d_id" value="<?= $course['id']; ?>">
                                                       <table id="duration_dataTable" class="table table-striped dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;" >
                                                      </table> <br>
                                                </p>
                                            </div>
                                            <div class="tab-pane p-3" id="profile1" role="tabpanel">
                                                <p class="mb-0">
                                                  <input type="hidden" name="course_id" id="course_id" value="<?= $course['id']?>">
                                                     <input type="hidden" name="course_view_type" id="course_view_type" value="1">
                                                  <table id="Lesson_datatable" class="table table-striped dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;" >
                                                  </table>
        
                                                </p>
                                            </div>
                                          
                                        </div>
                         

                      </div>
                  </div>
              </div>
          </div>
</div><br>
<?php init_footer(); ?>        
<script src="<?= base_url(); ?>assets/js/custom-js/course.js"></script> 
<script src="<?= base_url(); ?>assets/js/custom-js/lesson.js"></script> 