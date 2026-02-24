    <?php init_header();  ?>
    <!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
    <style>
        .modern-card {
            border: none;
            border-left: 5px solid #CA151C;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .modern-card2 {
            border: none;
            border-left: 5px solid #36e1cf;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .modern-card3 {
            border: none;
            border-left: 5px solid #88aad3;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .modern-card4 {
            border: none;
            border-left: 5px solid #ffde87;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .modern-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .modern-icon {
            background: rgba(202, 21, 28, 0.1);
            color: #CA151C;
            border-radius: 50%;
            padding: 10px 12px;
            font-size: 1.6rem;
        }

        .modern-icon2 {
            background: rgba(21, 175, 202, 0.1);
            color: #36e1cf;
            border-radius: 50%;
            padding: 10px 12px;
            font-size: 1.6rem;
        }

        .modern-icon3 {
            background: rgba(21, 136, 202, 0.1);
            color: #88aad3;
            border-radius: 50%;
            padding: 10px 12px;
            font-size: 1.6rem;
        }

        .modern-icon4 {
            background: rgba(193, 202, 21, 0.1);
            color: #ffde87;
            border-radius: 50%;
            padding: 10px 12px;
            font-size: 1.6rem;
        }

        .modern-title {
            color: #555;
            font-weight: 500;
        }

        .modern-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a252f;
        }
    </style>
    <style type="text/css">
        #gmaps-markers {
            height: 400px;
        }
    </style>

    <body onload="">
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="page-title-box">
                                <h4 class="font-size-18">Dashboard</h4>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item active">Welcome to Dashboard
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card modern-card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="modern-value mb-1"><?= ($total_users) ? $total_users : "0" ?></h2>
                                        <h6 class="text-muted mb-0">Total Users</h6>
                                    </div>
                                    <div><i class="fas fa-users modern-icon"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card modern-card2">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="modern-value mb-1"><?= ($total_package) ? $total_package : "0" ?></h2>
                                        <h6 class="text-muted mb-0">Total Package</h6>
                                    </div>
                                    <div><i class="fas fa-box-open modern-icon2"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card modern-card3">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="modern-value mb-1"><?= ($total_course) ? $total_course : "0" ?></h2>
                                        <h6 class="text-muted mb-0">Total Course</h6>
                                    </div>
                                    <div><i class="fas fa-book-open modern-icon3"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card modern-card4">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="modern-value mb-1"><?= ($total_course) ? $total_course : "0" ?></h2>
                                        <h6 class="text-muted mb-0">Total Course</h6>
                                    </div>
                                    <div><i class="fas fa-book-open modern-icon4"></i></div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Courses Wise Sale Count % </h4>
                                    <div>
                                        <div id="pie_chart" class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end  -->

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex no-block">
                                        <h5 class="card-title m-b-0 align-self-center">Active Students</h5>
                                    </div>
                                    <div id="active-students" style="height:300px; width:100%;"></div>
                                </div>
                            </div>
                        </div>


                        <!-- end  -->
                        <!-- <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">Payment Name</h4>
                                    <p class="card-title-desc"> </p>

                                    <div>
                                        <div class="table-responsive">
                                            <table class="table mb-0">

                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Payment Name</th>
                                                        <th> </th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($data_payment_gateway as $key => $value) {
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?= $key + 1; ?></th>
                                                        <td><?= $value['payment_gate_name']; ?></td>
                                                        <td><input type="radio" name="payemt_id"
                                                                value="<?= $value['id']; ?>"
                                                                <?= ($value['is_active']) ? "checked" : "" ?>
                                                                onchange="changePaymentMethod()"></td>
                                                    </tr>
                                                    <?php

                                                    }
                                                    ?>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <?php init_footer(); ?>
            <script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>
            <script src="<?= base_url(); ?>assets/js/custom-js/dashboard.js"></script>
            <script type="text/javascript">


            </script>