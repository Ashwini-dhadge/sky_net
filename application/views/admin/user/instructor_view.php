<?php  init_header(); ?>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
<div class="content-page">
<!-- Start content -->
<div class="content">
   <div class="container-fluid">
      <div class="page-title-box">
         <div class="row align-items-center">
            <div class="col-sm-6">
               <h4 class="page-title"><?= $title ?> Profile</h4>
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
                             
                          <h4 class="card-title"><?= $title ?> Details</h4>
                          <div class="">
                            <div class="row">
                              <div class="col-lg-6">
                                  <div class="float-left mr-4">
                                    <?php  $img = ($user['image'])? $user['image']:'no-image.png'; ?>
                                    <img src="<?= base_url().USER_IMAGES.$user['image'] ?>" alt="" class="rounded-circle" width="150" height="140"></div>
                                    <h4 class="text-success"><?= $user['first_name'];?><?= $user['last_name'];?></h4>
                                    <p class="text-muted"><?= $user['email'];?><br><?= $user['mobile_no'];?></p>
                              </div>
                            <div class="col-lg-6">
                            <table class="table">
                                <tbody>    
                            
                                    <tr>
                                        <th scope="row" class="p-1">First Name:</th>
                                        <td class="p-1"><?= $user['first_name'];?></td>
                                    </tr>
                                       <tr>
                                        <th scope="row" class="p-1">Last Name:</th>
                                        <td class="p-1"><?= $user['last_name'];?></td>
                                    </tr>
                                     <tr>
                                        <th scope="row" class="p-1">Email:</th>
                                        <td class="p-1"><?= $user['email'];?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="p-1">Mobile:</th>
                                        <td class="p-1"><?= $user['mobile_no'];?></td>
                                    </tr>
                                   <!--  <tr>
                                        <th scope="row" class="p-1">Description:</th>
                                        <td class="p-1"><?= $incident['description'];?></td>
                                    </tr> -->
                                </tbody>
                            </table>
                          </div>
                           
                        </div>
                        </div>
                           
                      </div>
                  </div>
              </div>
              
              
<!--               <div class="col-lg-12">
                          <div class="card">
                            <div class="card-body"> 
                              <h4 class="card-title">Status List</h4>
                               <table id="incident_status" class="table table-striped dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">  
                               </table> <br>
                            </div>
                        </div>
              </div> -->
          </div>
          </div>
	  			
            </div>
        </div>

</div>


<!-- content -->
<?php  init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/custom-js/incident.js"></script>
      

