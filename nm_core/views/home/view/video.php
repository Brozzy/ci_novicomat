<header>
    <h2>Video posnetki</h2>
</header>
<section>
    <?php foreach($contents as $content) { if(get_class($content) == 'video') { ?>
        <div style="display:table; width: 100%; padding: 3px; margin: 10px 0px; border:thin solid #ccc; ">
            <header style="display:table-cell; width:300px; ">
                <?php if($content->source == "internet") { ?>
                    <iframe width="300" height="200" style="padding:0px 5px 5px 0px;" src="<?php echo $content->url; ?>" frameborder="0" allowfullscreen></iframe>
                <?php } else { ?>
                    <video width="300" height="200" controls style="">
                        <source src="<?php echo base_url().$content->url; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php } ?>
            </header>
            <section style="display:table-cell; vertical-align: top;">
                <h3><?php echo $content->name; ?></h3>
                <p><?php echo $content->description; ?></p>
                <ul class="icon tags-icon">
                    <?php foreach($content->tags as $tag) { ?>
                        <li><?php echo $tag; ?></li>
                    <?php } ?>
                </ul>

                <p><?php echo $content->author->name.', '.$content->display_created; ?></p>
            </section>
        </div>
    <?php } } ?>
</section>
