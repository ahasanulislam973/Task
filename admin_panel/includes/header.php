<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Moon">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="<?php echo baseUrl('assets/img/favicon.png'); ?>">

    <title><?php echo isset($pageTitle) ? $pageTitle . PROJECT_NAME : ' myAdmin ' . PROJECT_NAME; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo baseUrl('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo baseUrl('assets/css/bootstrap-reset.css'); ?>" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo baseUrl('assets/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo baseUrl('assets/js/jquery-easy-pie-chart/jquery.easy-pie-chart.css'); ?>" rel="stylesheet"
          type="text/css"
          media="screen"/>
    <link rel="stylesheet" href="<?php echo baseUrl('assets/css/owl.carousel.css'); ?>" type="text/css">

    <!--right slidebar-->
    <link href="<?php echo baseUrl('assets/css/slidebars.css'); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->

    <link href="<?php echo baseUrl('assets/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo baseUrl('assets/css/style-responsive.css'); ?>" rel="stylesheet"/>

    <script src="<?php echo baseUrl('assets/js/jquery.js'); ?>"></script>
    <script src="<?php echo baseUrl('assets/js/bootstrap.min.js'); ?>"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo baseUrl('assets/js/html5shiv.js'); ?>"></script>
    <script src="<?php echo baseUrl('assets/js/respond.min.js'); ?>"></script>
    <![endif]-->

    <link href="<?php echo baseUrl('assets/dashboard-table/css/normalize.min.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo baseUrl('assets/dashboard-table/css/style.css'); ?>" rel="stylesheet"/>

</head>

<body>
<section id="container">
    <!--header start-->
    <?php include_once INCLUDE_DIR . 'header_upper.php'; ?>
    <!--header end-->

    <!--sidebar start-->
    <?php include_once INCLUDE_DIR . 'sidebar_menu.php'; ?>
    <!--sidebar end-->
