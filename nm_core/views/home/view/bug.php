<article id="content-view" style="padding:20px; min-height: 500px;">
    <header style="display: inline-block; width:54%; vertical-align: top;">
        <h2><?php echo $content->name; ?></h2>
        <h3 style="opacity: 0.8; font-size: 1.1em; font-weight: 300; margin: 10px 3px; min-height:50px; width:60%;"><?php echo $content->description; ?></h3>
    </header>

    <section style="display: inline-block; width:45%; vertical-align: top; text-align: right;">
        <?php foreach($content->images as $image) { ?>
            <a href="<?php echo base_url().$image->extra_large."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $image->name; ?>">
                <img src="<?php echo base_url().$image->large; ?>" alt="article header image">
            </a>
        <?php } ?>
    </section>
</article>
