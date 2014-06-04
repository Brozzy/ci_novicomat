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
    <img src="<?php echo base_url()."style/images/logo_large2.png"; ?>" alt="logo" class="logo" style="position:absolute; top:40px; left:29%; width:40%; ">
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

    <script type="text/javascript">

        authAnimation();
        setInterval('authAnimation()',1000);

        function authAnimation() {
            var random_id = "animation_"+Math.floor((Math.random() * 1000) + 1);
            var chooser =  Math.floor((Math.random() * 10) + 1 );
            var random_bottom = Math.floor((Math.random() * 800) + 20);
            var random_left = Math.floor((Math.random() * 100) + 0);
            var random_width = Math.floor((Math.random() * 150) + 50);
            var random_image = (chooser<0 ? '<?php echo base_url()."style/images/animation.png"; ?>' : '<?php echo base_url()."style/images/animation2.png"; ?>');

            var image = "<img id='"+random_id+"' style='width:"+random_width+"px; height:auto; bottom:"+random_bottom+"px; left:"+random_left+"%;' class='animation_image' src='"+random_image+"' alt='animation image'>";
            $('body').append(image);

            chooser =  Math.floor((Math.random() * 10) + 1 );
            var random_speed = Math.floor((Math.random() * 300) + 30);

            var random_direction = (chooser>4 ? 1 : -1);
            var random_opacity = Math.floor((Math.random() * 5) + 4)/10;
            random_opacity = (chooser<5 ? random_opacity+0.2 : random_opacity);
            image = $("#"+random_id);

            $(image).animate({
                opacity: random_opacity
            },random_speed,"linear",function() {
                random_speed = Math.floor((Math.random() * 8000) + 4000);
                setTimeout("destroyBlock('"+random_id+"')",random_speed);
            });
        }

        function destroyBlock(id) {
            var random_speed = Math.floor((Math.random() * 8000) + 4000);
            $("#"+id).fadeOut(random_speed,function() { $(this).remove(); });
        }
    </script>
 
</body>
</html>