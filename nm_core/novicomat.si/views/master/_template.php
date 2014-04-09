<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>
    
    <link href='http://fonts.googleapis.com/css?family=Gilda+Display&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/main.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/tpl_master/index.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/jquery-te-1.4.0.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/jquery.tagsinput.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/jquery-ui-1.10.4.custom.min.css"; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/jquery.fancybox.css"; ?>">
    
    <script type="text/javascript" src="<?php echo base_url()."js/jquery-1.11.0.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url()."js/angular.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url()."js/jquery-ui-1.10.4.custom.min.js"; ?>"></script>
    
   	<script type="text/javascript" src="<?php echo base_url()."js/jquery-te-1.4.0.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url()."js/jquery.color.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url()."js/jquery.tagsinput.min.js"; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url()."js/jquery.fancybox.js"; ?>"></script>
</head>

<body>
	<header id="MasterHeader">
		<?= $header; ?>
    </header>
    
	<section id='MasterMain'>
    	<header id='MasterPanel'>
        	<?= $panel; ?>
        </header>
        <section id='MasterContent'>
        	<?= $sidebar; ?>
            
			<?= $content; ?>
        </section>
    </section>
    
    <footer id='MasterFooter'>
    	<?= $footer; ?>
    </footer>
</body>
</html>