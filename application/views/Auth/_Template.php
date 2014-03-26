<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $Title; ?></title>

	<link rel="stylesheet" type="text/css" href="<?php echo site_url()."style/main.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/login.css"; ?>">
    <link href='http://fonts.googleapis.com/css?family=EB+Garamond&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

	<style type="text/css">
		#Content { padding:1.5%; }
		small { color:#444; }
		.requiered { color: red;}
    </style>

</head>

<body>
    
    <section id="Content">
    	<header>
    		<h1 style="margin-bottom:20px;"><?= $Header; ?></h1>
        </header>
    	<?= $Content; ?>
    </section>
    
    <footer>
    	<?= $Footer; ?>
    </footer>

</body>
</html>