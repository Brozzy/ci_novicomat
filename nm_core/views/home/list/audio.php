<header>
    <h2>Glasbeni posnetki</h2>
</header>
<section>
    <?php foreach($contents as $content) { if(get_class($content) == 'audio') { ?>
        <div style="display:table; width: 100%; padding: 3px; margin: 10px 0px;">
            <header style="display:table-cell; width:300px; ">
                <audio controls width="300" height="200" >
                    <source src="<?php echo base_url().$content->url; ?>" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
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
        <hr>
    <?php } } ?>
</section>
