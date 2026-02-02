<?php init_header(); ?>

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
                                <button type="button" class="btn btn-secondary waves-effect waves-light mb-0"
                                    onclick="window.history.back()">Back</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" name="section_id" id="section_id" value="<?= $lesson['id']; ?>">
                                <h4 class="card-title"><?= $lesson['title'] ?? ''; ?></h4>
                                <p class="card-title-desc"> <code
                                        class="highlighter-rouge"><?= $lesson['course_name']; ?></code>
                                </p>
                                <div class="row justify-content-end mb-2">
                                    <a href="javascript:void(0);"
                                        class="btn btn-primary waves-effect waves-light float-right"
                                        onclick="videoModal('', '');">
                                        Add Video
                                    </a>

                                </div>

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link " data-toggle="tab" href="#home" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Details</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">Video</span>
                                        </a>
                                    </li>

                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div class="tab-pane  p-3" id="home" role="tabpanel">
                                        <p class="mb-0">
                                        <div class="table-responsive col-lg-12">

                                            <table class="table  mb-0">
                                                <tbody>

                                                    <tr>
                                                        <th scope="row">Lesson Title</th>
                                                        <td><?= $lesson['title']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="20%">Course Name</th>
                                                        <td><?= $lesson['course_name']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Benefits </th>
                                                        <td><?= $lesson['benefits']; ?></td>
                                                    </tr>


                                                    <tr>
                                                        <th scope="row">Price </th>
                                                        <td><?= $lesson['price']; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Importance </th>
                                                        <td><?= $lesson['importance']; ?></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        </p>
                                    </div>
                                    <div class="tab-pane p-3 active" id="profile" role="tabpanel">
                                        <p class="mb-0">

                                        <h4 class="card-title">Table Video</h4><br>
                                        <hr>
                                        <input type="hidden" name="v_id" id="v_id" value="<?= $lesson['id']; ?>">
                                        <table id="video_csvtable" class="table table-striped dt-responsive"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        </table> <br>

                                        </p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>


                </div><br>
                <div id="_mcq"></div>

                <div class="modal fade" id="videosModal" tabindex="-1" aria-labelledby="videosModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div id="video_banner"></div>

                        </div>
                    </div>
                </div>
                <?php init_footer(); ?>

                <script src="<?= base_url(); ?>assets/js/custom-js/video.js"></script>
                <script src="<?= base_url(); ?>assets/plugins/jquery-repeater/jquery.repeater.min.js"></script>