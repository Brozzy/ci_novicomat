<section>
    <header>
        <h2>Urejanje prispevka</h2>
    </header>
    <section id="content-edit">
        <form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='contentForm' enctype="multipart/form-data" >
            <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

            <section class="editable-row">
                <!-- NAME, DESCRIPTION, TEXT -->
                <div class="first-column">
                    <label class="icon edit-icon" for='name'>Naslov<span class="required">*</span></label><br/>
                    <input type='text' required="required" name='content[name]' size="30" id='name' value='<?php echo $article->name; ?>' />

                    <label class="icon edit-icon" for='description'><?php if($article->type == "article") echo "Uvodno besedilo"; else echo "Opis"; ?><span class="required">*</span></label><br/>
                    <textarea name='content[description]' required="required" style="width:60%; min-height:50px; border-color:#777;" id='description'><?php echo $article->description; ?></textarea><br/>

                    <label class="icon edit-icon" for='text'>Besedilo<span class="required">*</span></label><br/>
                    <textarea class="editor" name='content[text]' required="required" style="width:100%; min-height:150px;" id='text'><?php echo $article->text; ?></textarea><br/>

                    <input type="hidden" value='<?php echo $article->id; ?>' name='content[id]'>
                    <input type="hidden" value='<?php echo $article->ref_id; ?>' name='content[ref_id]'>
                    <input type="hidden" value='<?php echo $article->type; ?>' name='content[type]'>
                </div>

                <!-- HEADER IMAGE -->
                <div class="second-column">
                    <label class="md-trigger icon image-icon" data-modal="modal-image-form">Naslovna slika<span class="required">*</span></label><br/>
                    <div class="view view-first" style="background-color:white; overflow: hidden; border:thin solid #888; border-radius:5px;" >
                        <img src='<?php echo base_url().$article->image->display."?img=".rand(0,1000); ?>' class="article-header-image" id="image-<?php echo $article->image->id; ?>" style="display:block; margin:0px auto; min-width:300px; min-height: 250px; max-height: 250px;" alt='article header image' />
                        <div class="mask">
                            <h2><?php echo $article->image->name; ?></h2>
                            <p><?php echo $article->image->description; ?></p>

                            <?php if($article->image->url != "style/images/icons/png/pictures.png") { ?>
                            <a href="<?php echo base_url().$article->image->display."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $article->image->name; ?>">Povečaj</a>
                            <?php } ?>

                            <a href="#" class="md-trigger upload-image-button header-image new-image info " data-modal="modal-image-form">Naloži</a>

                            <?php if($article->image->url != "style/images/icons/png/pictures.png") { ?>
                            <a href="#" class="md-trigger info edit-image-button header-image" data-modal="modal-edit-image-form">Uredi</a>
                            <?php } ?>

                            <input type="hidden" value="<?php echo $article->image->url; ?>" name="image_url">
                            <input type="hidden" value="<?php echo $article->image->ref_id; ?>" name="image_ref_id">
                            <input type="hidden" value="<?php echo $article->image->id; ?>" name="image_id">
                            <input type="hidden" value="<?php echo $article->image->display; ?>" name="image_display">
                        </div>
                    </div>
                </div>
            </section>

            <hr>

            <section class="editable-row">
                <!-- MISC CHECKBOXES (AUTHOR NAME, PUBLISH_UP, PUBLISH_DOWN...) -->
                <div class="first-column">
                    <label class="icon user-icon" for='author_name'>Ime avtorja<span class="required">*</span></label><br/>
                    <input type='text' required="required" name='content[author_name]' id='author_name' value='<?php echo $article->author_name; ?>' />

                    <label class="icon eye-icon" for='publish_up'>Objava od<span class="required">*</span></label><br/>
                    <input class="datepicker_up" required="required" type='text' name='content[publish_up]' id='publish_up' value='<?php echo $article->publish_up; ?>' />

                    <label class="icon eye-blocked-icon" for='publish_down'>Objava do</label><br>
                    <input class="datepicker_down" type='text' name='content[publish_down]' id='publish_down' value='<?php echo $article->publish_down; ?>' />

                    <label class="icon tags-icon" for='article_tags'>Ključne besede<span class="required">*</span></label><br/>
                    <textarea class="tags" required="required" style="width:100%; min-height:60px;" name='content[tags]'><?php echo $article->tags; ?></textarea><br>

                    <label class="icon locked-icon" for="locked-content" title="Pomeni, da ne more istočasno urejati članka še drug urednik.">Urejanje članka je zaklenjeno</label>
                </div>

                <!-- ADD ATTACHMENT BUTTONS -->
                <div class="second-column">
                    <input class="icon images-icon upload-image-button md-trigger new-image" data-modal="modal-image-form" type="button" value="Dodaj slike" ><br>
                    <!--<input class="icon images-icon md-trigger new-gallery" data-modal="modal-gallery-form" type="button" value="Dodaj galerijo" ><br>-->
                    <input class="icon video-icon" type="button" value="Dodaj video" ><br>
                    <input class="icon music-icon" type="button" value="Dodaj glasbeni posnetek" ><br>
                    <input class="icon file-icon" type="button" value="Dodaj dokument" ><br>
                    <input class="md-trigger icon calendar-icon" data-modal="modal-event-form" type="button" value="Dodaj ali poveži z dogodkom" ><br>
                    <input class="icon location-icon" type="button" value="Označi lokacijo" ><br>
                    <input class="icon link-icon" type="button" value="Poveži z obstoječim člankom" ><br>
                    <input class="icon users-icon" type="button" value="Dodaj urednika" ><br>
                </div>
            </section>

            <hr>

            <!-- DISPLAY ATTACHMENTS -->
            <section id="attachments-section">
                <?php if($article->attachments_count > 0) { ?>
                    <h3 class='icon attachment-icon' style='background-position: left 10px; padding-top:5px; padding-bottom:10px;'>Priponke</h3>
                <?php } ?>
                <div>
                    <?php foreach($article->attachments as $attachment)  {
                        if(isset($attachment->type) && $attachment->type == "multimedia") { ?>
                            <div style="position:relative; border-bottom:thin solid #999; width:100%; min-height: 167px; margin-bottom: 15px; box-shadow: 0px 3px 7px rgba(0,0,0,0.5);">
                                <div class="attachment-image-wrapper">
                                    <a href="<?php echo base_url().$attachment->display."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $attachment->name; ?>">
                                        <img class="attachment-image" src='<?php echo base_url().$attachment->display."?img=".rand(0,1000); ?>' id="image-<?php echo $attachment->id; ?>" alt='attachment image'>
                                    </a>
                                </div>
                                <div style="position:relative; margin-left:210px; margin-right: 210px; padding:5px; height:100%; min-height: 167px;">
                                    <h2><?php echo $attachment->name; ?></h2>
                                    <p style="padding-left: 3px; opacity: 0.6; word-break: break-all; "><?php echo substr($attachment->description,0,120); ?></p>
                                    <input type="hidden" value="<?php echo $attachment->ref_id; ?>" name="image_ref_id">
                                    <input type="hidden" value="<?php echo $attachment->id; ?>" name="image_id">
                                    <input type="hidden" value="<?php echo $attachment->url; ?>" name="image_url">

                                    <div style="position: absolute; bottom:0px; left:0px;">
                                        <input type="button" class="md-trigger icon upload-icon upload-image-button new-image existing-image" data-modal="modal-image-form" value="Naloži">
                                        <input type="button" class="md-trigger icon edit-icon edit-image-button" data-modal="modal-edit-image-form" value="Uredi">
                                        <input type="button" class="icon delete-icon outer-delete-image-button" value="Izbriši">
                                        <input type="button" class="md-trigger icon question-icon image-position-button" data-modal="modal-image-position-notification" value="Položaj slike">
                                        <input type="hidden" name='id' value="<?php echo $attachment->id; ?>">
                                        <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                                        <input type="hidden" name='url' value="<?php echo $attachment->url; ?>">
                                        <input type="hidden" name='display' value="<?php echo $attachment->display; ?>">
                                    </div>
                                </div>
                                <div class="attachment-position-wrapper">
                                    <table class="attachment-position">
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td style="width:45px;" class="area right <?php if($attachment->position == "right") echo "selected"; ?>"><input type="hidden" name='id' value="<?php echo $attachment->ref_id; ?>"></td>
                                        </tr>
                                        <tr style="height:30px;">
                                            <td colspan="2" class="area bottom <?php if($attachment->position == "bottom") echo "selected"; ?>"><input type="hidden" name='id' value="<?php echo $attachment->ref_id; ?>"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        <?php  } ?>
                    <?php } ?>
                </div>

            </section>

            <!-- MEDIA PUBLISH -->
            <section class="editable-row">
                <h3 class="icon list-icon">Objavi na naslednjih medijih</h3>
                <div style="width:100%;">
                    <?php
                    function loop_trough($value) {
                        if(is_array($value)) {
                            foreach($value as $v) {
                                echo "<ul style='padding-left:40px;'>";
                                loop_trough($v);
                                echo "</ul>";
                            }
                        }
                        else echo "<li style='padding-left:40px;'><span>".$value."</span><input type='checkbox' name='content[media][]' value='".$value."'></li>";
                    }

                    foreach($article->media as $media) {
                        echo "<ul class='media'>";
                            echo "<li><img src='".$media->favicon."' alt='media favicon'><span>".$media->media."</span><input type='checkbox' name='content[media][]' value='".$media->media."'></li>";
                            foreach($media->menu as $menu)
                                loop_trough($menu);
                        echo "</ul>";
                    }
                    ?>
                </div>
            </section>

            <hr>

            <!-- CANCEL, SAVE, PUBLISH BUTTONS -->
            <section class="editable-row">
                <input class="icon home-icon" type='button' value='nazaj na domačo stran' onclick="window.location.href='<?php echo base_url()."Domov"; ?>'"/>
                <input class="icon save-icon" type='submit' style="float:right;" value='samo shrani' formaction='<?php echo base_url()."content/Update"; ?>'/>

                <?php if($user->level > 3) { ?>
                    <input class="icon publish-icon" type='submit' value='objavi' formaction='<?php echo base_url()."content/Publish"; ?>'/>
                <?php } else { ?>
                    <input class="icon checkout-icon" type='submit' style="float:right; margin-right:15px;" value='shrani in pošlji v pregled' formaction='<?php echo base_url()."content/Editing"; ?>'/>
                <?php } ?>
            </section>

        </form>
    </section>
</section>
