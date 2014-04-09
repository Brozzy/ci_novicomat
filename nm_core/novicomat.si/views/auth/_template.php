<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/main.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/tpl_auth/index.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/tpl_auth/Login.css"; ?>">
    <link href='http://fonts.googleapis.com/css?family=Gilda+Display&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

</head>

<body>
    <header id="MasterHeader">
		<h1><?= $title; ?></h1>
    </header>
    
	<section id='MasterMain'>
		<?= $content; ?>
    </section>
    
    <footer id='MasterFooter'>
    	<?= $footer; ?>
    </footer>
</body>
</html>