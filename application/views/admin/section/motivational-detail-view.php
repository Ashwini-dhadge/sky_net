<?php init_header(); ?>
        <!-- Lightbox css -->
        
<?php 
//echo"<pre>";
//print_r($motivational);die();
if(isset($motivational)){ $motivational = $motivational[0]; }
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
                                                    if(isset($motivational['thumbnail'])){
                                                        ?>
                                                         
                                                          <img  src="<?= base_url().SERVICE_IMAGES.$motivational['thumbnail'] ?>" alt="" class="avatar-lg mr-4">
                                                        
                                                        <?php
                                                                 }
                                                        ?>       
                                          

                                            <div class="media-body overflow-hidden">
                                                <h5 class="text-truncate font-size-15 text_primary"><?= $motivational['title']?></h5>
                                                <p class="text-muted"><?= $motivational['short_description']?></p>
                                            </div>
                                        </div>
                                        </div>

                                        <h5 class="font-size-15 mt-4">motivationals Details :</h5>

                                        <p class="text-muted"><?= $motivational['description']?></p>

                                       
                                     
                                        
                                          <h5 class="font-size-15 mt-4" style="margin-top: 5px;">motivational Details :</h5>
                                        
                                        <div class="row">
                                        <div class="table-responsive col-lg-12">
                                           
                                            <table class="table  mb-0">
                                                <tbody>  

                                                   
                                                    <tr>
                                                        <th scope="row">Price </th>
                                                        <td><?=  $motivational['price']; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Discounted Price </th>
                                                        <td><?=  $motivational['discounted_price']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Video Link</th>
                                                        <td><?=  $motivational['video_link']; ?></td>
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
                            <div class="col-lg-12">
                                 <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">                                                  
                                              </h4>

                                                  <div class="">
                                                    
                                                        <?php $this->load->view(ADMIN.SERVICE.'table-motivational'); ?>
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

      <?php $this->load->view(ADMIN.SERVICE.'motivational_modal'); ?>
                     
<?php init_footer(); ?>        



 <script type="text/javascript">
    
 </script>