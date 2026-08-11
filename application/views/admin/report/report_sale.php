<?php init_header(); ?>

<div class="main-content">
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between ">
                        <h4 class="my-3 px-3">Sales Report</h4>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/SaleReport') ?>">Sales Report</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Listing</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card ">
                            <div class="card-body">
                                <form class="custom-validation"
                                    action="<?= base_url() . 'admin/SaleReport/downloadSaleReport' ?>"
                                    method="post">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <div>
                                                <select id="on_date" name="on_date"
                                                    class="form-control select2"
                                                    onchange="filter_order()">
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
                                                    placeholder="From date" onchange="filter_order()">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 on_date">
                                            <div>
                                                <input type="text" name="to_date" id="to_date"
                                                    class="form-control datepicker" autocomplete="off"
                                                    placeholder="To date" onchange="filter_order()">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 ">
                                            <div>
                                                <input type="submit"
                                                    class="btn btn-danger waves-effect waves-light"
                                                    id="submit" name="submit" value="Export">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title">Course Wise Sale Report
                                            </h4>
                                            <br>
                                            <table id="report_sales" class="table table-striped dt-responsive"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
        <?php init_footer(); ?>
        <script src="<?= base_url(); ?>assets/js/custom-js/report_sales.js?v=1.0.7"></script>
        <!-- Plugins js -->