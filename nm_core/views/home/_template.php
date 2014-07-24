<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>

    <!-- main -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/main.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/home.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/jquery-te-1.4.0.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/jquery-ui-1.10.4.custom.css"; ?>">
    <script type="text/javascript" src="<?php echo base_url().'js/jquery-1.11.0.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/jquery-ui-1.10.4.custom.min.js'; ?>"></script>
   	<script type="text/javascript" src="<?php echo base_url().'js/jquery-te-1.4.0.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/jquery.color.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'style/scroll-to/jquery.scrollTo.js'; ?>"></script>

    <!-- google maps -> API KEY: AIzaSyA8oXSx6enzC-echN80mMoq9CsT9yymhZc -->
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA8oXSx6enzC-echN80mMoq9CsT9yymhZc&sensor=false"></script>

    <!-- links -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/links/css/normalize.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/links/css/component.css"; ?>">
    <script type="text/javascript" src="<?php echo base_url().'style/links/js/modernizr.custom.js'; ?>"></script>

    <!-- modal -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/modal/css/component.css"; ?>">
    <script type="text/javascript" src="<?php echo base_url().'style/modal/js/modernizr.custom.js'; ?>"></script>

    <!-- image hover -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/image-hover/css/style_common.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/image-hover/css/style1.css"; ?>">

    <!-- fancybox -->
    <link rel="stylesheet" href="<?php echo base_url()."style/fancybox/jquery.fancybox.css"; ?>" type="text/css" media="screen">
    <script type="text/javascript" src="<?php echo base_url()."style/fancybox/jquery.fancybox.pack.js"; ?>"></script>

    <!-- image filter -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/image-filter/css/style3.css"; ?>">
    <script type="text/javascript" src="<?php echo base_url().'style/image-filter/js/modernizr.custom.29473.js'; ?>"></script>

    <!-- perfect scrollbar -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/perfect-scrollbar/perfect-scrollbar-0.4.10.min.css"; ?>">
    <script type="text/javascript" src="<?php echo base_url().'style/perfect-scrollbar/perfect-scrollbar-0.4.10.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'style/perfect-scrollbar/perfect-scrollbar-0.4.10.with-mousewheel.min.js'; ?>"></script>

    <!-- cropper -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/crop/cropper.css"; ?>">
    <script type="text/javascript" src="<?php echo base_url().'style/crop/cropper.js'; ?>"></script>

    <!-- timepicker -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/timepicker/timepicker.css"; ?>">
    <script type="text/javascript" src="<?php echo base_url().'style/timepicker/jquery-ui-timepicker-addon.js'; ?>"></script>

    <!-- horizontal menu -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/horizontal-menu/css/component.css"; ?>" />
    <script src="<?php echo base_url()."style/horizontal-menu/js/modernizr.custom.js"; ?>"></script>

</head>

<body>

    <div class="container">
        <header id="header">
            <?= $header; ?>
        </header>

        <section id="content">
            <?= $content; ?>
        </section>

        <footer>
            <?= $footer; ?>
        </footer>
    </div>

    <!-- main script -->
    <script>var polyfilter_scriptpath = '/js/';</script>
    <script type="text/javascript" src="<?php echo base_url().'js/classie.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/main.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/custom.js'; ?>"></script>

    <!-- modal -->
    <script type="text/javascript" src="<?php echo base_url().'style/modal/js/cssParser.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'style/modal/js/css-filters-polyfill.js'; ?>"></script>

    <!-- horizontal menu -->
    <script src="<?php echo base_url().'style/horizontal-menu/js/cbpHorizontalMenu.min.js'; ?>"></script>
    <script>$(function() { cbpHorizontalMenu.init(); });</script>

</body>
</html>