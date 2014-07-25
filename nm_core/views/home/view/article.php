<article id="content-view" style="padding:20px; min-height: 500px;">
    <header style="display: inline-block; width:54%; vertical-align: top;">
        <h2><?php echo $content->name; ?></h2>
        <h3 style="opacity: 0.8; font-size: 1.1em; font-weight: 300; margin: 10px 3px; min-height:50px; width:60%;"><?php echo $content->description; ?></h3>

        <p style="font-size: 1.1em; opacity: 0.8;"><?php echo $content->text; ?></p>

        <br>

        <?php foreach($content->attachments as $attachment) { if(get_class($attachment) == "document") { ?>
            <a href="<?php echo base_url().$attachment->url; ?>" target="_self"><?php echo $attachment->name; ?></a>
        <?php } } ?>
    </header>

    <section style="display: inline-block; width:45%; vertical-align: top; text-align: right;">
        <a href="<?php echo base_url().$content->image->extra_large."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $content->image->name; ?>">
            <img style="width:100%; max-width: 500px; max-height: 500px;" src="<?php echo base_url().$content->image->large; ?>" alt="content image">
        </a>

        <?php foreach($content->attachments as $attachment)  {
        if(get_class($attachment) == "image") { if($attachment->position == "right") { ?>
            <div class="attachment-image-wrapper" style="display: inline-block;">
                <a href="<?php echo base_url().$attachment->extra_large."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $attachment->name; ?>">
                    <img class="attachment-image" src='<?php echo base_url().$attachment->medium."?img=".rand(0,1000); ?>' id="image-<?php echo $attachment->id; ?>" alt='attachment image'>
                </a>
            </div>
        <?php } } }?>
    </section>

    <hr>

    <section id="attachments-section">
        <?php foreach($content->attachments as $attachment)  {
            if(get_class($attachment) == "image") { if($attachment->position == "bottom") { ?>
                <div class="attachment-image-wrapper" style="display: inline-block; margin: 15px 30px 15px 0px;">
                    <a href="<?php echo base_url().$attachment->extra_large."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $attachment->name; ?>">
                        <img class="attachment-image" src='<?php echo base_url().$attachment->medium."?img=".rand(0,1000); ?>' id="image-<?php echo $attachment->id; ?>" alt='attachment image'>
                    </a>
                </div>
        <?php } } } ?>
    </section>
</article>
