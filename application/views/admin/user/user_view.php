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
              <div class="col-lg-4">
                    <div class="card">
                      <div class="card-body"> 
                          <h4 class="card-title"><?= $title ?> Details</h4>
                          <input type="hidden" name="action" id="action" value="2">
                          <div class="float-left mr-4">
                          <?php  $img = ($user['image'])? $user['image']:'no-image.png'; ?>
                          <img src="<?= base_url().USER_IMAGES.$user['image'] ?>" alt="" class="rounded-circle" width="60" ></div>
                          <h4 class="text-success"><?= $user['first_name'];?> <?= $user['last_name'];?></h4>
                          <p class="text-muted"><?= ($user['status'])?"Active":"Not active";?></p>
                      </div>
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

                                   <tr>
                                        <th scope="row" class="p-1">Last Login:</th>
                                         <?php
                                            if(isset($user['last_login']) && $user['last_login']!="0000-00-00 00:00:00"){
                                              $date=date('F d Y H:i a', strtotime($user['last_login']));
                                            }else{
                                              $date="-";
                                            }
                                          ?>
                                        <td class="p-1"><?= $date; ?></td>
                                    </tr> 
                                </tbody>
                            </table> 
                      
                      </div>
              </div>
              <div class="col-lg-8">
                 <div class="card">
                                    <div class="card-body">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">Basic Info</span> 
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#profile1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">My Courses</span> 
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#messages1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                                    <span class="d-none d-sm-block">My Package</span>   
                                                </a>
                                            </li>
                                          
                                           
                                        </ul>
        
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="tab-pane active p-3" id="home1" role="tabpanel">
                                                <p class="mb-0">
                                                     <form  method="post" id="imeno_form" name="imeno_form">
                                                        <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">IMEI No</label>

                                                            <div class="col-sm-5">
                                                              <input type="hidden" name="id" id="id" value="<?= $user['id'];?>">
                                                                <input class="form-control" type="text" value="<?= $user['imei_no'];?>" id="imei_no" name="imei_no">
                                                            </div>
                                                        </div>
                                                          <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Commsion Percentage</label>

                                                            <div class="col-sm-5">
                                                             
                                                                <input class="form-control" type="text" value="<?= $user['commsion_percentage'];?>" id="commsion_percentage" name="commsion_percentage">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <div>
                                                                <button type="button" class="btn btn-success waves-effect waves-light mr-1" onclick="actionUsers(1)">
                                                                    Update
                                                                </button>
                                                                <button type="button" class="btn btn-danger waves-effect" onclick="actionUsers(2)">
                                                                    Delete IMEI No
                                                                </button>
                                                            </div>
                                                        </div>
                                                     </form>
                                                </p>
                                            </div>
                                            <div class="tab-pane p-3" id="profile1" role="tabpanel">
                                                 <?php $this->load->view(ADMIN.USER.'table-mycourse'); ?>   
                                            </div>
                                            <div class="tab-pane p-3" id="messages1" role="tabpanel">
                                                <p class="mb-0">
                                                     <?php $this->load->view(ADMIN.USER.'table-mypackage'); ?>   
                                                </p>
                                            </div>
                                            
                                          
                                        </div>
        
                                    </div>
                                </div>
              </div>
      </div>
      <div class="row">
          <div class="col-lg-12">
                 <div class="card">
                                    <div class="card-body">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#challenge" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">Challenge Exam Solved</span> 
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#lesson" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Lesson Video MCQ Solved</span> 
                                                </a>
                                            </li>
                                               <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#wallet" role="tab" onclick="filter_users_wallet()">
                                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                                    <span class="d-none d-sm-block">My Wallet</span>   
                                                </a>
                                            </li>
                                        </ul>
        
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="tab-pane active p-3" id="challenge" role="tabpanel">
                                                <p class="mb-0">
                                                   <table id="user_challenge_datatable" class="table table-striped dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;" >
                                                  </table>
                                                </p>
                                            </div>
                                            <div class="tab-pane p-3" id="lesson" role="tabpanel">
                                                <table id="user_video_mcq_datatable" class="table table-striped dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;" >
                                                </table> 
                                            </div>
                                              <div class="tab-pane p-3" id="wallet" role="tabpanel">
                                                <p class="mb-0">
                                                     <table id="userWallet_datatable" class="table table-striped dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;" >
                                                    </table>
                                                </p>
                                            </div>
                                          
                                        </div>
        
                                    </div>
                                </div>
              </div>
      </div>
              
  
          </div>
          </div>
	  			
            </div>
        </div>

</div>


<!-- content -->
<?php  init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/custom-js/user.js"></script>