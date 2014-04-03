<style type="text/css">
	#VsebineArticle {
		width:100%; 
		border:thin solid #222;
		margin-bottom:15px;
		padding:5px;
	}
	
	#VsebineArticle h3 {
		padding:0px; margin:0px;
	}
</style>


<section>
	<header>
    	<h3>Prispevki</h3>
    </header>
<?php foreach($Vsebine as $Vsebina) { ?>

	<article id='VsebineArticle'>
    	<header>
        	<h3><?php echo $Vsebina->title; ?></h3>
        </header>
        <p>
        	<?php echo strip_tags($Vsebina->introtext); ?>
        </p>
    </article>

<?php } ?>
</section>