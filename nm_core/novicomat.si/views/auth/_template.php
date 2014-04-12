<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/main.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/tpl_auth/index.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/tpl_auth/Login.css"; ?>">
    <link href='http://fonts.googleapis.com/css?family=Gilda+Display&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	
	<script type="text/javascript" src="<?php echo base_url()."js/jquery-1.11.0.min.js"; ?>"></script>
</head>

<body>
	<script type='text/javascript'>
		$(document).ready(function() {
			ChangeBackground();
			setInterval("ChangeBackground()",10000);
		});

		function ChangeBackground() {
			$('body').animate({
				'background-color': GetHexaColor()
			},10000);
		}
		
		function GetHexaColor() {
			var RandomHEX = '#'+Math.floor(Math.random()*16777215).toString(16);
			return RandomHEX;
		}
	</script>

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