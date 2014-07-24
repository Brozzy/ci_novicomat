<header>
    <h2>Urejanje prispevka</h2>
</header>
<section id="content-edit">
    <form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='contentForm' enctype="multipart/form-data" >
        <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

        <section class="editable-row">

            <!-- NAME, DESCRIPTION, TEXT -->
            <div class="first-column">
                <label class="icon edit-icon" for='name'>Naslov<span class="required">*</span></label>
                <input type='text' required="required" name='content[name]' size="30" id='name' value='<?php echo $article->name; ?>' />

                <label class="icon edit-icon" for='description'><?php if($article->type == "article") echo "Uvodno besedilo"; else echo "Opis"; ?><span class="required">*</span></label>
                <textarea name='content[description]' required="required" style="width:60%; min-height:50px; border-color:#777;" id='description'><?php echo $article->description; ?></textarea><br/>

                <label class="icon edit-icon" for='text'>Besedilo<span class="required">*</span></label>
                <textarea class="editor" name='content[text]' required="required" style="width:100%; min-height:150px;" id='text'><?php echo $article->text; ?></textarea><br/>

                <input type="hidden" id="asoc_id" name='content[id]' value='<?php echo $article->id; ?>'>
                <input type="hidden" name='content[ref_id]' value='<?php echo $article->ref_id; ?>'>
                <input type="hidden" name='content[type]' value='article'>
            </div>

            <!-- HEADER IMAGE -->
            <div class="second-column">
                <label class="md-trigger icon image-icon" data-modal="modal-image-form">Naslovna slika<span class="required">*</span></label>
                <div style="overflow: hidden; width:100%; max-width:500px; height: 333px; border:thin dashed #999; border-radius: 5px; background-color:white;">
                    <a href="<?php echo base_url().$article->image->extra_large."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $article->image->name; ?>">
                        <img class="attachment-image" src='<?php echo base_url().$article->image->large."?img=".rand(0,1000); ?>' id="image-<?php echo $article->image->id; ?>" alt='attachment image' style="min-height: 333px; margin-left: auto; margin-right: auto; border-radius: 5px; ">
                    </a>
                </div>

                <div>
                    <hr>
                    <input type="hidden" value="<?php echo $article->image->ref_id; ?>" name="image_ref_id">
                    <input type="hidden" value="<?php echo $article->image->id; ?>" name="image_id">
                    <input type="hidden" value="<?php echo $article->image->url; ?>" name="image_url">

                    <div>
                        <input type="button" class="md-trigger icon edit-icon" title="Urejanje vsebine" data-modal="new-image" value="Uredi ali naloži">
                        <input type="button" class="md-trigger icon wand-icon" title='Spreminjanje slike' data-modal="edit-image" value="Spremeni">
                        <input type="button" class="md-trigger icon question-icon" data-modal="about-header-image" title="Naslovna slika" value="Naslovna slika">

                        <input type="hidden" name='id' class="current-content-id" value="<?php echo $article->image->id; ?>">
                        <input type="hidden" name='ref_id' value="<?php echo $article->image->ref_id; ?>">
                        <input type="hidden" name='category' value="<?php echo $article->image->category; ?>">
                        <input type="hidden" name='url' value="<?php echo $article->image->url; ?>">
                        <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                        <input type="hidden" name='header' value="true">
                        <input type="hidden" name='type' value="multimedia">
                    </div>
                </div>
            </div>

        </section>

        <hr>

        <section class="editable-row">

            <!-- MISC CHECKBOXES (AUTHOR NAME, PUBLISH_UP, PUBLISH_DOWN...) -->
            <div class="first-column">
                <label class="icon user-icon" for='author_name'>Ime avtorja<span class="required">*</span></label>
                <input type='text' required="required" name='content[author_name]' id='author_name' value='<?php echo $article->author_name; ?>' />

                <label class="icon eye-icon" for='publish_up'>Objava od<span class="required">*</span></label>
                <input class="datepicker_up" required="required" type='text' name='content[publish_up]' id='publish_up' value='<?php echo $article->publish_up; ?>' />

                <label class="icon eye-blocked-icon" for='publish_down'>Objava do</label>
                <input class="datepicker_down" type='text' name='content[publish_down]' id='publish_down' value='<?php echo $article->publish_down; ?>' />

                <label class="icon tags-icon" for='article_tags'>Ključne besede<span class="required">*</span></label>
                <textarea class="tags" required="required" id="article_tags" style="width:95%; min-height:60px; font-size:1.2em; opacity:0.9;" name='content[tags]'><?php echo implode(", ",$article->tags); ?></textarea><br>

                <label class="icon locked-icon" for="locked-content" title="Pomeni, da ne more istočasno urejati članka še drug urednik.">Urejanje članka je zaklenjeno. Članek trenutno lahko urejate samo vi.</label>
            </div>

            <!-- ADD ATTACHMENT BUTTONS -->
            <div class="second-column">
                <div>
                    <input class="md-trigger icon images-icon" data-modal="new-image" title="Dodajanje slik" type="button" value="Dodaj slike" >
                    <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                    <input type="hidden" name='type' value="image">
                </div>
                <div>
                    <input class="md-trigger icon video-icon" data-modal="new-video" title="Dodajte video posnetek" type="button" value="Dodaj video">
                    <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                    <input type="hidden" name='type' value="video">
                </div>
                <div>
                    <input class="md-trigger icon music-icon" type="button" value="Dodaj glasbeni posnetek" data-modal="new-audio" title="Dodajte glasbeni posnetek" >
                    <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                    <input type="hidden" name='type' value="audio">
                </div>
                <div>
                    <input class="md-trigger icon file-icon " type="button" value="Dodaj dokument"  data-modal="new-file" title="Dodajte dokument" >
                    <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                    <input type="hidden" name='type' value="file">
                </div>
                <div>
                    <input class="md-trigger icon calendar-icon" type="button" value="Dodaj dogodek" data-modal="new-event" title="Dodajte dogodek" >
                    <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                    <input type="hidden" name='type' value="event">
                </div>
                <div>
                    <input class="md-trigger icon location-icon" type="button" value="Označi lokacijo" data-modal="new-location" title="Dodajanje lokacije">
                    <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                    <input type="hidden" name='type' value="location">
                </div>
                <div>
                    <input class="md-trigger icon users-icon" type="button" value="Dodaj urednika" data-modal="new-editor" title="Dodajte urednika" >
                    <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                    <input type="hidden" name='type' value="editor">
                </div>
            </div>

        </section>

        <hr>

        <!-- DISPLAY ATTACHMENTS -->
        <section id="attachments-section">

            <?php foreach($article->attachments as $attachment)  {
                if(get_class($attachment) == "image") { ?>
                    <div class="attachment-wrapper" style="background:transparent url('<?php echo base_url()."style/images/icons/svg/image.svg"; ?>') no-repeat 98% 15px;">
                        <div class="attachment-image-wrapper">
                            <a href="<?php echo base_url().$attachment->extra_large."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $attachment->name; ?>">
                                <img class="attachment-image" src='<?php echo base_url().$attachment->medium."?img=".rand(0,1000); ?>' id="image-<?php echo $attachment->id; ?>" alt='attachment image'>
                            </a>
                        </div>
                        <div style="position:relative; margin-left:310px; margin-right: 210px; padding:5px; height:100%; min-height: 167px;">
                            <h2><?php echo $attachment->name; ?></h2>
                            <p style="padding-left: 3px; opacity: 0.6; word-break: break-all; "><?php echo substr($attachment->description,0,120); ?></p>
                            <hr>

                            <div style="position: absolute; bottom:0px; left:0px;">
                                <input type="button" class="md-trigger icon edit-icon" title="Urejanje slike" data-modal="new-image" value="Uredi">
                                <input type="button" class="md-trigger icon wand-icon" title="Spreminjanje slike" data-modal="edit-image" value="Spremeni">
                                <input type="button" class="md-trigger icon location-icon" data-modal="edit-image-position" title="Položaj slike" value="Položaj slike">
                                <input type="button" class="icon delete-icon delete-attachment-button" value="Izbriši">

                                <input type="hidden" name='id' class="current-content-id" value="<?php echo $attachment->id; ?>">
                                <input type="hidden" name='ref_id' value="<?php echo $attachment->ref_id; ?>">
                                <input type="hidden" name='category' value="<?php echo $attachment->category; ?>">
                                <input type="hidden" name='url' value="<?php echo $attachment->url; ?>">
                                <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                                <input type="hidden" name='type' value="multimedia">
                                <input type="hidden" name='header' value="false">
                            </div>
                            <ul class="attachment-tags icon tags-icon">
                                <?php foreach($attachment->tags as $tag) { ?>
                                    <li><?php echo $tag; ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php }
                else if(get_class($attachment) == "video") { ?>
                    <div class="attachment-wrapper" style="height: 200px; background:transparent url('<?php echo base_url()."style/images/icons/svg/play.svg"; ?>') no-repeat 98% 15px;">
                        <div class="attachment-image-wrapper" style="width: 300px;">
                            <?php if($attachment->source == "internet") { ?>
                                <iframe width="300" height="200" style="padding:0px 5px 5px 0px;" src="<?php echo $attachment->url; ?>" frameborder="0" allowfullscreen></iframe>
                            <?php } else { ?>
                                <video width="300" height="200" controls style="">
                                    <source src="<?php echo base_url().$attachment->url; ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php } ?>
                        </div>
                        <div style="position:relative; margin-left:310px; margin-right: 210px; padding:5px; height:100%; min-height: 167px;">
                            <h2><?php echo $attachment->name; ?></h2>
                            <p style="padding-left: 3px; opacity: 0.6; word-break: break-all; "><?php echo substr($attachment->description,0,120); ?></p>
                            <hr>
                            <div style="position: absolute; bottom:0px; left:0px;">
                                <input type="button" class="md-trigger icon edit-icon" data-modal="new-video" title="Urejanje video posnetka" value="Uredi">
                                <input type="button" class="icon delete-icon delete-attachment-button" value="Izbriši">

                                <input type="hidden" name='id' class="current-content-id" value="<?php echo $attachment->id; ?>">
                                <input type="hidden" name='url' value="<?php echo $attachment->url; ?>">
                                <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                                <input type="hidden" name='type' value="video">
                            </div>
                            <ul class="attachment-tags icon tags-icon">
                                <?php foreach($attachment->tags as $tag) { ?>
                                    <li><?php echo $tag; ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php }
                else if(get_class($attachment) == "audio") { ?>
                    <div class="attachment-wrapper" style="height: 200px; background:transparent url('<?php echo base_url()."style/images/icons/svg/music.svg"; ?>') no-repeat 98% 15px;">
                        <div class="attachment-image-wrapper" style="width: 300px; background:transparent url('<?php echo $attachment->thumbnail; ?>') no-repeat center 90px; ">
                            <audio controls width="300" height="200" >
                            <source src="<?php echo base_url().$attachment->url; ?>" type="audio/mpeg">
                            Your browser does not support the audio element.
                            </audio>
                        </div>
                        <div style="position:relative; margin-left:310px; margin-right: 210px; padding:5px; height:100%; min-height: 167px;">
                            <h2><?php echo $attachment->name; ?></h2>
                            <p style="padding-left: 3px; opacity: 0.6; word-break: break-all; "><?php echo substr($attachment->description,0,120); ?></p>
                            <hr>
                            <div style="position: absolute; bottom:0px; left:0px;">
                                <input type="button" class="md-trigger icon edit-icon" data-modal="new-audio" title="Urejanje glasbenega posnetka" value="Uredi">
                                <input type="button" class="icon delete-icon delete-attachment-button" value="Izbriši">
                                <input type="hidden" name='id' class="current-content-id" value="<?php echo $attachment->id; ?>">
                                <input type="hidden" name='url' value="<?php echo $attachment->url; ?>">
                                <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                                <input type="hidden" name='type' value="audio">
                            </div>
                            <ul class="attachment-tags icon tags-icon">
                                <?php foreach($attachment->tags as $tag) { ?>
                                    <li><?php echo $tag; ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php }
                else if(get_class($attachment) == "document") { ?>
                    <div class="attachment-wrapper" style="height: 200px; background:transparent url('<?php echo base_url()."style/images/icons/svg/file.svg"; ?>') no-repeat 98% 15px;">
                        <a href="<?php echo base_url().$attachment->url; ?>" target="_self">
                            <div class="attachment-image-wrapper" style="width: 300px; background:transparent url('<?php echo $attachment->thumbnail; ?>') no-repeat center; ">
                                &nbsp;
                            </div>
                        </a>
                        <div style="position:relative; margin-left:310px; margin-right: 210px; padding:5px; height:100%; min-height: 167px;">
                            <h2><?php echo $attachment->name; ?><small style="margin-left:5px; vertical-align: top; opacity: 0.6; font-size: 0.6em;">[<?php echo $attachment->format; ?>]</small></h2>
                            <p style="padding-left: 3px; opacity: 0.6; word-break: break-all; "><?php echo substr($attachment->description,0,120); ?></p>
                            <hr>
                            <div style="position: absolute; bottom:0px; left:0px;">
                                <a class="icon save-icon" href="<?php echo base_url().$attachment->url; ?>" target="_self">Prenesi</a>
                                <input type="button" class="md-trigger icon edit-icon" data-modal="new-file" title="Urejanje datoteke" value="Uredi">
                                <input type="button" class="icon delete-icon delete-attachment-button" value="Izbriši">

                                <input type="hidden" name='id' class="current-content-id" value="<?php echo $attachment->id; ?>">
                                <input type="hidden" name='url' value="<?php echo $attachment->url; ?>">
                                <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                                <input type="hidden" name='type' value="document">
                            </div>
                            <ul class="attachment-tags icon tags-icon">
                                <?php foreach($attachment->tags as $tag) { ?>
                                    <li><?php echo $tag; ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php }
                else if(get_class($attachment) == "event") { ?>
                    <div class="attachment-wrapper" style="height: 167px; background:transparent url('<?php echo base_url()."style/images/icons/svg/calendar.svg"; ?>') no-repeat 98% 15px;">
                        <div class="attachment-image-wrapper">
                            <a href="<?php echo base_url().$attachment->image->extra_large."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $attachment->name; ?>">
                                <img class="attachment-image" src='<?php echo base_url().$attachment->image->medium."?img=".rand(0,1000); ?>' id="image-<?php echo $attachment->id; ?>" alt='attachment image'>
                            </a>
                        </div>
                        <div style="position:relative; margin-left:310px; margin-right: 210px; padding:5px; height:100%; min-height: 167px;">
                            <h2><?php echo $attachment->name; ?></h2>
                            <p style="padding-left: 3px; opacity: 0.6; word-break: break-all; padding:2px 0px; margin:0px; "><?php echo substr($attachment->description,0,120); ?></p>
                            <hr>
                            <p style="opacity: 0.8;">
                                <strong style="font-size: 1.1em;" class="icon clock-icon"><?php echo $attachment->display_start_date; ?></strong> <span style="margin-left:20px; opacity:0.8;"><?php echo $attachment->exact_date_start; ?></span><br><br>
                                <?php if($attachment->exact_date_end != "") { ?>
                                    <strong style="font-size: 1.1em;" class="icon clock2-icon"><?php echo $attachment->display_end_date; ?></strong> <span style="margin-left:20px; opacity:0.8;"><?php echo $attachment->exact_date_end; ?></span>
                                <?php } ?>
                            </p>
                            <div style="position: absolute; bottom:0px; left:0px;">
                                <input type="button" class="md-trigger icon edit-icon" data-modal="new-event" value="Uredi">
                                <input type="button" class="icon delete-icon delete-attachment-button" value="Izbriši">

                                <input type="hidden" name='id' class="current-content-id" value="<?php echo $attachment->id; ?>">
                                <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                                <input type="hidden" name='type' value="event">
                            </div>
                            <ul class="attachment-tags icon tags-icon">
                                <?php foreach($attachment->tags as $tag) { ?>
                                    <li><?php echo $tag; ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php }
                else if(get_class($attachment) == "location") { ?>
                    <div class="attachment-wrapper" style="background:transparent url('<?php echo base_url()."style/images/icons/svg/location.svg"; ?>') no-repeat 98% 15px;">
                        <div class="attachment-image-wrapper">
                            <img class="attachment-image" src='<?php echo $attachment->google_image; ?>' alt='google location image'>
                        </div>
                        <div style="position:relative; margin-left:310px; margin-right: 210px; padding:5px; height:100%; min-height: 167px;">
                            <h2><?php echo $attachment->country; ?></h2>
                            <p style="padding-left: 3px; opacity: 0.6; font-size:1.1em; word-break: break-all; padding:10px 0px; margin:0px; "><?php echo substr($attachment->city,0,120); if($attachment->street_village != "") echo ", ".$attachment->street_village; if($attachment->house_number != "") echo ", ".$attachment->house_number; ?></p>
                            <hr>
                            <ul style="opacity: 0.6; font-size: 1em;">
                                <?php if($attachment->region != "") echo "<li>Regija: ".$attachment->region."</li>"; ?>
                                <?php if($attachment->post_number != "") echo "<li>Poštna številka: ".$attachment->post_number."</li>"; ?>
                                <?php if($attachment->room_name != "") echo "<li>Poslopje ali soba: ".$attachment->room_name."</li>"; ?>
                            </ul>
                            <div style="position: absolute; bottom:0px; left:0px;">
                                <input type="button" class="md-trigger icon edit-icon" data-modal="new-location" title="Urejanje lokacije" value="Uredi">
                                <input type="button" class="icon delete-icon delete-attachment-button" value="Izbriši">

                                <input type="hidden" name='id' class="current-content-id" value="<?php echo $attachment->id; ?>">
                                <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                                <input type="hidden" name='type' value="location">
                            </div>
                            <ul class="attachment-tags icon tags-icon">
                                <?php foreach($attachment->tags as $tag) { ?>
                                    <li><?php echo $tag; ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php }?>
            <?php } ?>

        </section>

        <!-- MEDIA PUBLISH -->
        <section class="editable-row">
            <label class="icon list-icon">Mediji</label>
            <div style="width:100%;">
                <?php

                function loop_trough($menu) {
                    echo "<li style='padding-left:20px; border-bottom:thin solid #999;'><label for='media-".$menu->name."'>".$menu->name."</label><input ".$menu->attr." type='checkbox' style='float:right;' id='media-".$menu->name."' class='add-tag ".$menu->class."' value='".$menu->name."'></li>";

                    foreach($menu->menu as $row) {
                        echo "<ul style='padding-left:20px; width: 100%;'>";
                            loop_trough($row);
                        echo "</ul>";
                    }
                }

                foreach($article->media as $media) {
                    echo "<ul class='media' style='display: inline-block; margin-right: 30px; min-width:250px; vertical-align: top; '>";
                    echo "<li style='text-align:center; font-size:1.2em;'><img src='".$media->favicon."' alt='media favicon'><label for='media-".$media->tag_id."'>".$media->name."</label><input ".$media->attr." class='add-tag domain' id='media-".$media->tag_id."' style='float:right;' type='checkbox' name='content[media][]' value='".$media->name."'></li>";

                    foreach($media->menu as $menu) {
                        echo "<ul style='padding-left:20px; display: ".$media->display.";'>";
                            loop_trough($menu);
                        echo "</ul>";
                    }

                    echo "</ul>";
                }

                ?>
            </div>
            <div>
                <input class="md-trigger icon address-icon" data-modal="new-media" title="Dodajanje medija" type="button" value="Dodaj svoj medij" ><br>
            </div>
        </section>

        <hr>

        <!-- CANCEL, SAVE, PUBLISH BUTTONS -->
        <section class="editable-row">
            <input class="icon home-icon" type='button' value='nazaj na domačo stran' onclick="window.location.href='<?php echo base_url()."Domov"; ?>'"/>
            <input class="icon save-icon" type='submit' style="float:right;" value='samo shrani' formaction='<?php echo base_url()."content/Update"; ?>'/>

            <?php if($user->level > 0) { ?>
                <input class="icon mail-icon" type='submit' style="float:right;" value='objavi' formaction='<?php echo base_url()."content/Publish"; ?>'/>
            <?php } else { ?>
                <input class="icon checkout-icon" type='submit' style="float:right; margin-right:15px;" value='shrani in pošlji v pregled' formaction='<?php echo base_url()."content/Editing"; ?>'/>
            <?php } ?>
        </section>

    </form>
</section>

