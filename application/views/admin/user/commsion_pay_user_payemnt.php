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
              <div class="col-lg-4">
                    <div class="card">
                      <div class="card-body"> 
                          <h4 class="card-title"><?= $title ?> Details</h4>
                          <input type="hidden" name="action" id="action" value="2">
                          <div class="float-left mr-4">
                          <?php  $img = ($user['image'])? $user['image']:'no-image.png'; ?>
                          <img src="<?= base_url().USER_IMAGES.$user['image'] ?>" alt="" class="rounded-circle" width="60" ></div>
                          <h4 class="text-success"><?= $user['first_name'];?><?= $user['last_name'];?></h4>
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
                                        <th scope="row" class="p-1">Wallet Balance:</th>
                                        <td class="p-1"><?= ($remaining_balance)?$remaining_balance:0;?></td>
                                    </tr>
                                     <tr>
                                        <th scope="row" class="p-1">Paid Amount:</th>
                                        <td class="p-1"><?= ($withdraw_amount)?$withdraw_amount:0;;?></td>
                                    </tr>

                                     <tr>
                                        <th scope="row" class="p-1">Remaining Amount:</th>
                                        <input type="hidden" name="amount" id="amount" value="<?= ( $remaining_balance )? $remaining_balance :0?>">
                                        <td class="p-1"><?= ( $remaining_balance )? $remaining_balance :0?></td>
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
                                        <td class="p-1"><?= date('d F Y H:i a', strtotime($date));?></td>
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
                                                    <span class="d-none d-sm-block">Pay Commission</span> 
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#profile1" role="tab" id="paid_user_tab" onclick="filter_users_paid()">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Paid Commission List</span> 
                                                </a>
                                            </li>
                                            
                                           
                                        </ul>
        
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="tab-pane active p-3" id="home1" role="tabpanel">
                                                <p class="mb-0"> 
                                                     <form  method="post" id="form" name="form" action="<?= base_url()."admin/CommsionPayUsers/PaidCommsion"; ?>">
                                                           <div class="form-group col-md-12">
                                                            <label>Payment Mode</label>
                                                            <div>
                                                               <input type="radio" required value="1" name="payment_mode" <?= (isset($lesson['payment_mode']) && $lesson['payment_mode'] == 1)? 'checked': '';?> checked>
                                                                  &nbsp;&nbsp;Cash&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                  <input type="radio" required value="2" name="payment_mode" <?= (isset($lesson['payment_mode']) && $lesson['payment_mode'] == 2)? 'checked': '';?>>
                                                                  &nbsp;&nbsp;cheque
                                                                  <input type="radio" required value="3" name="payment_mode" <?= (isset($lesson['payment_mode']) && $lesson['payment_mode'] == 3)? 'checked': '';?>>
                                                                  &nbsp;&nbsp;Phone Pay
                                                                   <input type="radio" required value="4" name="payment_mode" <?= (isset($lesson['payment_mode']) && $lesson['payment_mode'] == 4)? 'checked': '';?>>
                                                                  &nbsp;&nbsp;Google Pay
                                                                   <input type="radio" required value="5" name="payment_mode" <?= (isset($lesson['payment_mode']) && $lesson['payment_mode'] == 5)? 'checked': '';?>>
                                                                  &nbsp;&nbsp; Amzone Pay
                                                                  <input type="radio" required value="6" name="payment_mode" <?= (isset($lesson['payment_mode']) && $lesson['payment_mode'] == 6)? 'checked': '';?>>
                                                                  &nbsp;&nbsp; Other
                                                            </div>
                                                          </div>
                                                        
                                                         <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Transaction Id</label>

                                                            <div class="col-sm-5">
                                                              <input type="hidden" name="user_id" id="user_id" value="<?= $user['id'];?>">
                                                                <input class="form-control" type="text" value="" id="transaction_id" name="transaction_id" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Transaction Date</label>

                                                            <div class="col-sm-5">
                                                                <input class="form-control" type="date" value="" id="transaction_date" name="transaction_date">
                                                            </div>
                                                        </div>
                                                          <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Payment Amount</label>
                                                            <div class="col-sm-5">
                                                                <input class="form-control" type="text" value="" id="payment_amount" name="payment_amount" min="1" max="<?= ( $remaining_balance )? $remaining_balance :0?>" step="100" 
                                                             data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="number">
                                                            </div>
                                                        </div>
                                                         <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Description</label>

                                                            <div class="col-sm-5">
                                                             <textarea id="description" name="description" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        <div class="form-group mb-0">
                                                            <div>
                                                                <button type="submit" class="btn btn-success waves-effect waves-light mr-1" onclick="actionUsers(1)">
                                                                    Submit
                                                                </button>
                                                              
                                                            </div>
                                                        </div>
                                                     </form>
                                                </p>
                                            </div>
                                            <div class="tab-pane p-3" id="profile1" role="tabpanel">
                                                
                                                <table id="paidCommsion_datatable" class="table table-striped dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;" >
                                                </table>
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
<script src="<?= base_url(); ?>assets/js/custom-js/user_commsion.js"></script>