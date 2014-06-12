<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>

    <!-- main style -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/main.css"; ?>">
	<script type="text/javascript" src="<?php echo base_url()."js/jquery-1.11.0.min.js"; ?>"></script>

    <!-- login -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/login/css/style.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/login/css/animate-custom.css"; ?>">

</head>

<body>

<div class="container">
    <section id="content">
        <?= $content; ?>

    </section>
    <footer style="text-align: center; position: absolute; bottom:0px; left:46%; opacity: 0.4; font-size: 1em; color:#222;">
        <?= $footer; ?>
    </footer>
</div>
 
</body>
</html>