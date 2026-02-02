<?php init_header(); ?>
        <!-- Lightbox css -->
        
<?php 
//echo"<pre>";
//print_r($course);die();
if(isset($course)){ $course = $course[0]; }
?>
    
        <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                            <div class="col-lg-12">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                        <div class="col-lg-12">
                                        <div class="media">  
                                           
                                             <div class="media">
                                                 <?php
                                                    if(isset($course['thumbnail'])){
                                                        ?>
                                                         
                                                          <img  src="<?= base_url().COURSE_IMAGES.$course['thumbnail'] ?>" alt="" class="avatar-lg mr-4">
                                                        
                                                        <?php
                                                                 }
                                                        ?>       
                                          

                                            <div class="media-body overflow-hidden">
                                                <h5 class="text-truncate font-size-15 text_primary"><?= $course['title']?></h5>
                                                <p class="text-muted"><?= $course['short_description']?></p>
                                            </div>
                                        </div>
                                        </div>

                                        <h5 class="font-size-15 mt-4">courses Details :</h5>

                                        <p class="text-muted"><?= $course['description']?></p>

                                       
                                     
                                        
                                          <h5 class="font-size-15 mt-4" style="margin-top: 5px;">Course Details :</h5>
                                        
                                        <div class="row">
                                        <div class="table-responsive col-lg-12">
                                           
                                            <table class="table  mb-0">
                                                <tbody>  
                                                    <tr>
                                                        <th scope="row" width="20%">Category Name</th>
                                                        <td><?=  $course['name']; ?></td>
                                                    </tr>
                                                     <tr>
                                                        <th scope="row">Meta Keywords</th>
                                                        <td><?=  $course['meta_keywords']; ?></td>
                                                    </tr> 
                                                    <tr>

                                                        <th scope="row">Meta Description </th>
                                                        <td><?=  $course['meta_description']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Price </th>
                                                        <td><?=  $course['price']; ?></td>
                                                    </tr>



                                                    <tr>
                                                        <th scope="row">Discounted Price </th>
                                                        <td><?=  $course['discounted_price']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Video Url</th>
                                                        <td><?=  $course['video_url']; ?></td>
                                                    </tr>
                                                   

                                                    

                                                </tbody>
                                            </table>
                                         </div>
                                         </div>
    
                                    </div>
                                    
                                 </div>
                                     </div>
                                </div>
                            <!-- end col -->

                           
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-5">
                                 <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">                                                  
                                              </h4>

                                                  <div class="">
                                                    
                                                        <?php $this->load->view(ADMIN.COURSE.'table-section'); ?>
                                                    </div>
                                    </div>
                                </div>                            
                            </div> 
                             <div class="col-lg-7">
                                 <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">                                                  
                                              </h4>

                                                  <div class="">                                                    
                                                        <?php $this->load->view(ADMIN.COURSE.'table-lesson'); ?>
                                                    </div>
                                    </div>
                                </div>                            
                            </div> 
                    </div>
                </div>
               </div>

              
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
       <?php $this->load->view(ADMIN.COURSE.'section_modal'); ?>
      <?php $this->load->view(ADMIN.COURSE.'lesson_modal'); ?>
                     
<?php init_footer(); ?>        



 <script type="text/javascript">
    
 </script>