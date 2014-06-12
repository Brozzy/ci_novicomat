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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/jquery.Jcrop.min.css"; ?>">
    <script type="text/javascript" src="<?php echo base_url().'js/jquery-1.11.0.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/jquery-ui-1.10.4.custom.min.js'; ?>"></script>
   	<script type="text/javascript" src="<?php echo base_url().'js/jquery-te-1.4.0.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'js/jquery.Jcrop.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/jquery.color.js'; ?>"></script>

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
    <script type="text/javascript" src="<?php echo base_url().'style/image-hover/js/modernizr.custom.js'; ?>"></script>

    <!-- fancybox -->
    <link rel="stylesheet" href="<?php echo base_url()."style/fancybox/jquery.fancybox.css"; ?>" type="text/css" media="screen">
    <script type="text/javascript" src="<?php echo base_url()."style/fancybox/jquery.fancybox.pack.js"; ?>"></script>

    <!-- image filter -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/image-filter/css/style1.css"; ?>">
    <script type="text/javascript" src="<?php echo base_url().'style/image-filter/js/modernizr.custom.29473.js'; ?>"></script>

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

    <!-- modal -->
    <script type="text/javascript" src="<?php echo base_url().'style/modal/js/classie.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'style/modal/js/modalEffects.js'; ?>"></script>
    <script> var polyfilter_scriptpath = '/js/'; </script>
    <script type="text/javascript" src="<?php echo base_url().'style/modal/js/cssParser.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'style/modal/js/css-filters-polyfill.js'; ?>"></script>

    <!-- fancybox, texteditor -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.fancybox').fancybox();
            $(".editor").jqte({
                sub: false,
                sup: false,
                strike: false,
                remove: false
            });
        });
    </script>

</body>
</html>