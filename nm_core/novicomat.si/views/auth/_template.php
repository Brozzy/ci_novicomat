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
    <header>
        <h1 style="margin-bottom:20px;"><?= $title; ?></h1>
    </header>

	<section>
    	<?= $content; ?>
    </section>
    
    <footer>
    	<?= $footer; ?>
    </footer>
</body>
</html>