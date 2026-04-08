<?php init_header(); ?>

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
                        <h4 class="page-title">Consolidated Reports</h4>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-right d-none d-md-block">
                            <button type="button" class="btn btn-secondary waves-effect waves-light mb-0"
                                onclick="resetFilter()">Reset <i class="fas fa-filter"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="custom-validation" action="#" method="post">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <div>
                                            <select id="on_date" name="on_date" required class="form-control select2">
                                                <option value="">Select </option>
                                                <option value="1">Today</option>
                                                <option value="2">Yesterday</option>
                                                <option value="3">This Week</option>
                                                <option value="4">This Month</option>
                                                <option value="5">This Year</option>
                                                <option value="6">Custome Date</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 on_date">
                                        <div>
                                            <input type="text" name="from_date" id="from_date"
                                                class="form-control datepicker" autocomplete="off"
                                                placeholder="From date" onchange="filter()">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 on_date">
                                        <div>
                                            <input type="text" name="to_date" id="to_date"
                                                class="form-control datepicker" autocomplete="off" placeholder="To date"
                                                onchange="filter()">
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Consolidated Report
                            </h4>
                            <br>
                            <table id="table_consolidatedReports" class="table table-striped dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- content -->

    <?php init_footer(); ?>
    <script src="<?= base_url(); ?>assets/js/page-js/report_consolidated.js?v=1.0.7"></script>