<?php init_header(); ?>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between ">
                        <h4 class="my-3 px-3">Users</h4>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent">
                                <li class="breadcrumb-item"><a href="#">Users</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Details</li>
                            </ol>
                        </nav>
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
                                                <?php

                                                $image = trim($user['image'] ?? '');

                                                $uploadPath = FCPATH . 'assets/uploads/user_image/' . $image;

                                                if ($image != '' && $image != 'null' && is_file($uploadPath)) {

                                                    $imagePath = base_url('assets/uploads/user_image/' . $image);
                                                } else {

                                                    $imagePath = base_url('assets/images/user.png');
                                                }

                                                ?>

                                                <img src="<?= $imagePath ?>"
                                                    style="width:85px;height:85px;object-fit:cover;border-radius:15px;">
                                            </div>
                                            <h4 class="text-success">
                                                <?= $user['first_name']; ?><?= $user['last_name']; ?></h4>
                                            <p class="text-muted"><?= $user['email']; ?><br><?= $user['mobile_no']; ?>
                                            </p>
                                        </div>
                                        <div class="col-lg-6">
                                            <table class="table">
                                                <tbody>

                                                    <tr>
                                                        <th scope="row" class="p-1">Full Name:</th>
                                                        <td class="p-1"><?= $user['first_name']; ?></td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <th scope="row" class="p-1">Last Name:</th>
                                                        <td class="p-1"><?= $user['last_name']; ?></td>
                                                    </tr> -->
                                                    <tr>
                                                        <th scope="row" class="p-1">Email:</th>
                                                        <td class="p-1"><?= $user['email']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="p-1">Mobile:</th>
                                                        <td class="p-1"><?= $user['mobile_no']; ?></td>
                                                    </tr>
                                                    <!--  <tr>
                                        <th scope="row" class="p-1">Description:</th>
                                        <td class="p-1"><?= $incident['description']; ?></td>
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
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/custom-js/incident.js"></script>