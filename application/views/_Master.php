<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $Title; ?></title>
    
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/main.css"; ?>">
    <link href='http://fonts.googleapis.com/css?family=EB+Garamond&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/jquery.Jcrop.min.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/jquery-te-1.4.0.css"; ?>">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    
    <script type="text/javascript" src='<?php echo base_url()."js/jquery-1.11.0.min.js"; ?>'></script>
    <script type="text/javascript" src='<?php echo base_url()."js/jquery.Jcrop.min.js"; ?>'></script>
    <script type="text/javascript" src='<?php echo base_url()."js/jquery.color.js"; ?>'></script>
    <script type="text/javascript" src='<?php echo base_url()."js/jquery-te-1.4.0.min.js"; ?>'></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    
    <script type="text/javascript" src='<?php echo base_url()."js/angular.min.js"; ?>'></script>
    <script type="text/javascript" src='<?php echo base_url()."js/keywords.js"; ?>'></script>
    
    <style type="text/css">
		#MasterHeader { 
			background-color:#446c77; 
			display:table;
			width:100%;
		}
		h1 { color:#c3dde5; }
		#MasterMain { margin:0px; }
		
		#MasterPanel {
			background-color:#ccdde2;
			margin:0px;
			padding:0px;
		}
		#MasterPanel ul { list-style:none; padding-left:1%; padding-right:1%; }
		#MasterPanel li { display:inline-block; padding:1%; padding-left:20px;  }
		
		#MasterContent { min-height:400px; width:92%; padding:0.5% 4% 200px 4%; display:table; }
		
		.button { cursor:pointer; }
		.button:hover { background-color:#7ab7c8; }
		
		.add-button {
			background-image:url(<?php echo base_url()."style/images/add.png"; ?>); 
			background-size:12px auto;
			background-position:4px;
			background-repeat:no-repeat;
		}

    </style>
</head>

<body>
	<header id="MasterHeader">
		<?= $Header; ?>
    </header>
    
	<section id='MasterMain'>
    	<header id='MasterPanel'>
        	<?= $Panel; ?>
        </header>
        <section id='MasterContent'>
        	<header style="display:table-cell;">
        	<?= $Sidebar; ?>
            </header>
            <section style="display:table-cell;">
			<?= $Content; ?>
            </section>
        </section>
    </section>
    
    <footer id='MasterFooter'>
    	<?= $Footer; ?>
    </footer>
</body>
</html>