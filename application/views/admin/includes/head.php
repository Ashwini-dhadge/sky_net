<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= PROJECTNAME; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/icon.png">

    <!-- Summernote css -->
    <link href="<?= base_url(); ?>assets/libs/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/libs/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="<?= base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
    <!-- Lightbox css -->
    <link href="<?= base_url(); ?>assets/libs/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->

    <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url(); ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/css/custom.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/node_modules/c3-master/c3.min.css" rel="stylesheet">
</head>
<script type="text/javascript">
    base_url = '<?= base_url(); ?>';
    _admin = "admin/";;
</script>
<style type="text/css">
    .cke_notification {
        display: none;
    }

    body[data-sidebar="dark"] .navbar-brand-box {
        /* background: #000; */
        /* background: #1A252F */
        background: #fff
    }

    body[data-sidebar="dark"] .vertical-menu {
        /* background: #000; */
        background: #fff;
        /* background: #1A252F */
    }

    body[data-sidebar="dark"] .mm-active .active {
        color: #ffffff !important;
        background-color: #e3a6a8;
        border-left-color: #fff;
        border-left-style: solid;
    }

    .bg-primary {
        /* background-color: #ca151cc2 !important; */
        background-color: #ca151cd1 !important;
    }

    body[data-sidebar="dark"] .mm-active .active i {
        color: #fff !important;
    }

    .btn-primary {
        background-color: #CA151C;
        border-color: #CA151C;
    }

    .btn-primary:hover {
        color: #fff;
        background-color: #CA151C !important;
        border-color: #CA151C !important;
    }
</style>

<body data-sidebar="dark">
    <!-- Begin page -->
    <div id="layout-wrapper">