<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/main.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/tpl_auth/index.css"; ?>">

    <link href='http://fonts.googleapis.com/css?family=Gilda+Display&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	
	<script type="text/javascript" src="<?php echo base_url()."js/jquery-1.11.0.min.js"; ?>"></script>
</head>

<body>

	<section id='MasterMain'>
		<header id="MasterHeader">
			<h1 style='margin:0px; padding:3px;'><?= $title; ?></h1>
    	</header>
		
		<section id="MasterContent">
		<?= $content; ?>
		</section>
		
		<footer id='MasterFooter'>
	    	<?= $footer; ?>
	    </footer>
    </section>
 
</body>
</html>