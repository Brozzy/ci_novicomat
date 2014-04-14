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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/jquery-ui-1.10.4.custom.css"; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/jquery.fancybox.css"; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/jquery.fancybox-buttons.css"; ?>">
    
    <script type="text/javascript" src="<?php echo base_url().'js/jquery-1.11.0.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/angular.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/jquery-ui-1.10.4.custom.min.js'; ?>"></script>
   	<script type="text/javascript" src="<?php echo base_url().'js/jquery-te-1.4.0.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/jquery.color.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/jquery.tagsinput.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'js/jquery.fancybox.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'js/jquery.fancybox.pack.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'js/jquery.fancybox-buttons.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'js/jquery.autocomplete.js'; ?>"></script>

</head>

<body>
	<section id='MasterMain'>
		<header id="MasterHeader">
			<?= $header; ?>
   		</header>
        <section id='MasterContent'>  
			<header id='MasterPanel' style='border-right:none;'>
        		<?= $panel; ?>
        	</header>          
			<?= $content; ?>
        </section>
		
		<footer id='MasterFooter'>
    		<?= $footer; ?>
    	</footer>
    </section>
    
    
	
	<script type='text/javascript'>
		/*$(document).ready(function() {
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
		}*/
	</script>
</body>
</html>