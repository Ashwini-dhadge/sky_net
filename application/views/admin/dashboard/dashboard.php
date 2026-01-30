    <?php init_header();  ?>
    <!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->

    <style>
.modern-card {
    border: none;
    border-left: 5px solid #CA151C;
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
                    <!-- <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card mini-stat bg-primary text-white shadow-sm">
                                <div class="card-body">
                                    <div class="mb-0">
                                        <div class="float-left mini-stat-img mr-4">
                                            <img src="<?= base_url(); ?>assets/images/services-icon/02.png" alt="">
                                        </div>
                                        <h5 class="font-size-14 text-uppercase mt-0 text-white-50">Total Users</h5>
                                        <h4 class="font-weight-medium font-size-24 float-right">
                                            <?= ($total_users) ? $total_users : "0" ?> </h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card mini-stat bg-primary text-white shadow-sm">
                                <div class="card-body">
                                    <div class="mb-0">
                                        <div class="float-left mini-stat-img mr-4">
                                            <img src="<?= base_url(); ?>assets/images/services-icon/02.png" alt="">
                                        </div>
                                        <h5 class="font-size-14 text-uppercase mt-0 text-white-50">Total Package</h5>
                                        <h4 class="font-weight-medium font-size-24 float-right">
                                            <?= ($total_package) ? $total_package : "0" ?> </h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card mini-stat bg-primary text-white shadow-sm">
                                <div class="card-body">
                                    <div class="mb-0">
                                        <div class="float-left mini-stat-img mr-4">
                                            <img src="<?= base_url(); ?>assets/images/services-icon/02.png" alt="">
                                        </div>
                                        <h5 class="font-size-14 text-uppercase mt-0 text-white-50">Total Course <br>
                                        </h5>
                                        <h4 class="font-weight-medium font-size-24 float-right">
                                            <?= ($total_course) ? $total_course : "0" ?> </h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card mini-stat bg-primary text-white shadow-sm">
                                <div class="card-body">
                                    <div class="mb-0">

                                        <div class="float-left mini-stat-img mr-4">
                                            <img src="<?= base_url(); ?>assets/images/services-icon/02.png" alt="">
                                        </div>
                                        <h5 class="font-size-14 text-uppercase mt-0 text-white-50">Total Income </h5>
                                        <h4 class="font-weight-medium font-size-24 float-right">
                                            <?= ($total_sale) ? $total_sale['sales'] : "0" ?> </h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <!-- Total Users -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card rounded-lg border-dark bg-dark shadow-lg">
                                <div class="card-body">
                                    <div class="d-flex p-10 no-block">
                                        <div class="align-self-center">
                                            <h2 class="m-b-0 text-white">234</h2>
                                            <h6 class="m-b-0 text-white">Total Users</h6>
                                        </div>
                                        <div class="align-self-center display-6 ml-auto">
                                            <i class="fas fa-users text-white fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Package -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card rounded-lg bg-primary shadow-lg">
                                <div class="card-body">
                                    <div class="d-flex p-10 no-block">
                                        <div class="align-self-center">
                                            <h2 class="m-b-0 text-white">6,759</h2>
                                            <h6 class="m-b-0 text-white">Total Package</h6>
                                        </div>
                                        <div class="align-self-center display-6 ml-auto">
                                            <i class="fas fa-box-open text-white fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Course -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card rounded-lg bg-success shadow-lg">
                                <div class="card-body">
                                    <div class="d-flex p-10 no-block">
                                        <div class="align-self-center">
                                            <h2 class="m-b-0 text-white">2,356</h2>
                                            <h6 class="text-white m-b-0">Total Course</h6>
                                        </div>
                                        <div class="align-self-center display-6 ml-auto">
                                            <i class="fas fa-book-open text-white fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Income -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card rounded-lg bg-danger shadow-lg">
                                <div class="card-body">
                                    <div class="d-flex p-10 no-block">
                                        <div class="align-self-center">
                                            <h2 class="m-b-0 text-white">38</h2>
                                            <h6 class="text-white m-b-0">Total Income</h6>
                                        </div>
                                        <div class="align-self-center display-6 ml-auto">
                                            <i class="fas fa-wallet text-white fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Total Users -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card modern-card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="modern-value mb-1">234</h2>
                                        <h6 class="text-muted mb-0">Total Users</h6>
                                    </div>
                                    <div><i class="fas fa-users modern-icon"></i></div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Package -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card modern-card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="modern-value mb-1">6,759</h2>
                                        <h6 class="text-muted mb-0">Total Package</h6>
                                    </div>
                                    <div><i class="fas fa-box-open modern-icon"></i></div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Course -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card modern-card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="modern-value mb-1">2,356</h2>
                                        <h6 class="text-muted mb-0">Total Course</h6>
                                    </div>
                                    <div><i class="fas fa-book-open modern-icon"></i></div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Income -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card modern-card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="modern-value mb-1">38</h2>
                                        <h6 class="text-muted mb-0">Total Income</h6>
                                    </div>
                                    <div><i class="fas fa-wallet modern-icon"></i></div>
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
                        <!-- <div class="col-lg-6">
                            <div class="card ">
                                <div class="card-body">
                                    <div class="d-flex no-block">
                                        <h5 class="card-title m-b-0 align-self-center">Active Students</h5>

                                    </div>
                                    <div id="income-year" style="height:100px; width:100%;"></div>
                                </div>
                            </div>
                        </div> -->
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
                    <div class="row">
                        <!-- Column -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex mb-2">
                                        <div>
                                            <h5 class="card-title">Popular Instructors </h5>
                                        </div>
                                        <div class="ml-auto">
                                            <select class="custom-select b-0">
                                                <option selected="">November</option>
                                                <option value="1">October</option>
                                                <option value="2">September</option>
                                                <option value="3">August</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="table-responsive m-t-20 no-wrap">
                                        <table class="table vm no-th-brd pro-of-month">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Instructor</th>
                                                    <th>Course</th>
                                                    <th>Rating</th>
                                                    <th>Students</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width:50px;"><span class="round"><img
                                                                src="https://randomuser.me/api/portraits/men/45.jpg"
                                                                alt="user" width="50"></span></td>
                                                    <td>
                                                        <h6>Rahul Sharma</h6><small class="text-muted">Web
                                                            Development</small>
                                                    </td>
                                                    <td>Full-Stack Bootcamp</td>
                                                    <td><span class="label label-success label-rounded">4.8 ★</span>
                                                    </td>
                                                    <td>1,250</td>
                                                </tr>
                                                <tr class="active">
                                                    <td><span class="round"><img
                                                                src="https://randomuser.me/api/portraits/women/47.jpg"
                                                                alt="user" width="50"></span></td>
                                                    <td>
                                                        <h6>Priya Mehta</h6><small class="text-muted">UI/UX
                                                            Design</small>
                                                    </td>
                                                    <td>Design Masterclass</td>
                                                    <td><span class="label label-info label-rounded">4.9 ★</span></td>
                                                    <td>980</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="round"><img
                                                                src="https://randomuser.me/api/portraits/men/23.jpg"
                                                                alt="user" width="50"></span></td>
                                                    <td>
                                                        <h6>Amit Verma</h6><small class="text-muted">Data
                                                            Science</small>
                                                    </td>
                                                    <td>Python for Data Science</td>
                                                    <td><span class="label label-primary label-rounded">4.7 ★</span>
                                                    </td>
                                                    <td>1,120</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="round"><img
                                                                src="https://randomuser.me/api/portraits/women/12.jpg"
                                                                alt="user" width="50"></span></td>
                                                    <td>
                                                        <h6>Sneha Iyer</h6><small class="text-muted">Digital
                                                            Marketing</small>
                                                    </td>
                                                    <td>Social Media Strategy</td>
                                                    <td><span class="label label-success label-rounded">4.6 ★</span>
                                                    </td>
                                                    <td>870</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="round"><img
                                                                src="https://randomuser.me/api/portraits/men/10.jpg"
                                                                alt="user" width="50"></span></td>
                                                    <td>
                                                        <h6>Vikram Rao</h6><small class="text-muted">Mobile
                                                            Development</small>
                                                    </td>
                                                    <td>Android Development 2025</td>
                                                    <td><span class="label label-info label-rounded">4.9 ★</span></td>
                                                    <td>720</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Column -->
                        <!-- Column -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex mb-2">
                                        <div>
                                            <h5 class="card-title">Top Courses</h5>
                                        </div>
                                        <div class="ml-auto">
                                            <select class="custom-select b-0">
                                                <option selected="">November</option>
                                                <option value="1">October</option>
                                                <option value="2">September</option>
                                                <option value="3">August</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="table-responsive m-t-20 no-wrap">
                                        <table class="table vm no-th-brd pro-of-month">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Course</th>
                                                    <th>Instructor</th>
                                                    <th>Rating</th>
                                                    <th>Enrollments</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width:50px;"><span class="round"><img
                                                                src="https://img.icons8.com/color/48/000000/html-5.png"
                                                                alt="HTML" width="40"></span></td>
                                                    <td>
                                                        <h6>Full-Stack Web Development</h6><small
                                                            class="text-muted">Frontend & Backend</small>
                                                    </td>
                                                    <td>Rahul Sharma</td>
                                                    <td><span class="label label-success label-rounded">4.8 ★</span>
                                                    </td>
                                                    <td>1,520</td>
                                                </tr>
                                                <tr class="active">
                                                    <td><span class="round"><img
                                                                src="https://img.icons8.com/color/48/000000/adobe-xd.png"
                                                                alt="UI/UX" width="40"></span></td>
                                                    <td>
                                                        <h6>Modern UI/UX Design</h6><small
                                                            class="text-muted">Prototyping & Design Systems</small>
                                                    </td>
                                                    <td>Priya Mehta</td>
                                                    <td><span class="label label-info label-rounded">4.9 ★</span></td>
                                                    <td>1,310</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="round"><img
                                                                src="https://img.icons8.com/color/48/000000/python.png"
                                                                alt="Python" width="40"></span></td>
                                                    <td>
                                                        <h6>Python for Data Science</h6><small
                                                            class="text-muted">Machine Learning & AI</small>
                                                    </td>
                                                    <td>Amit Verma</td>
                                                    <td><span class="label label-primary label-rounded">4.7 ★</span>
                                                    </td>
                                                    <td>1,050</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="round"><img
                                                                src="https://img.icons8.com/color/48/000000/marketing.png"
                                                                alt="Marketing" width="40"></span></td>
                                                    <td>
                                                        <h6>Digital Marketing Pro</h6><small class="text-muted">SEO, Ads
                                                            & Branding</small>
                                                    </td>
                                                    <td>Sneha Iyer</td>
                                                    <td><span class="label label-success label-rounded">4.6 ★</span>
                                                    </td>
                                                    <td>930</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="round"><img
                                                                src="https://img.icons8.com/color/48/000000/android-os.png"
                                                                alt="Android" width="40"></span></td>
                                                    <td>
                                                        <h6>Android App Development</h6><small class="text-muted">Kotlin
                                                            & Jetpack</small>
                                                    </td>
                                                    <td>Vikram Rao</td>
                                                    <td><span class="label label-info label-rounded">4.8 ★</span></td>
                                                    <td>850</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Column -->

                    </div>





                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php init_footer(); ?>
            <script src="<?= base_url(); ?>assets/libs/apexcharts/apexcharts.min.js"></script>

            <script src="<?= base_url(); ?>assets/js/custom-js/dashboard.js"></script>
            <!-- content -->

            <script type="text/javascript">


            </script>