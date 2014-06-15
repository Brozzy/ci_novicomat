<section>
    <header>
        <h2>Urejanje prispevka</h2>
    </header>
    <section id="content-edit">
        <form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='contentForm' enctype="multipart/form-data" >

            <section class="editable-row">
                <!-- NAME, DESCRIPTION, TEXT -->
                <div class="first-column">
                    <label class="icon edit-icon" for='name'>Naslov<span class="required">*</span></label><br/>
                    <input class="text_input" type='text' required="required" name='content[name]' size="30" id='name' value='<?php echo $article->name; ?>' />

                    <label class="icon edit-icon" for='description'><?php if($article->type == "article") echo "Uvodno besedilo"; else echo "Opis"; ?><span class="required">*</span></label><br/>
                    <textarea class="text_input" name='content[description]' required="required" style="width:60%; min-height:50px; border-color:#777;" id='description'><?php echo $article->description; ?></textarea><br/>


                    <label class="icon edit-icon" for='text'>Besedilo<span class="required">*</span></label><br/>
                    <textarea class="editor" name='content[text]' required="required" style="width:100%; min-height:150px;" id='text'><?php echo $article->text; ?></textarea><br/>

                    <input type="hidden" value='<?php echo $article->id; ?>' name='content[id]'>
                    <input type="hidden" value='<?php echo $article->ref_id; ?>' name='content[ref_id]'>
                    <input type="hidden" value='<?php echo $article->type; ?>' name='content[type]'>
                </div>

                <!-- HEADER IMAGE -->
                <div class="second-column">
                    <label class="md-trigger icon image-icon" data-modal="modal-image-form">Naslovna slika<span class="required">*</span></label><br/>
                    <div class="view view-first" style="overflow: hidden;" >
                        <img src='<?php echo $article->image->large."?img=".rand(0,100); ?>' class="article-header-image" id="image-<?php echo $article->image->id; ?>" style="display:block; margin:0px auto; min-width:300px; min-height: 250px; max-height: 250px;" alt='article header image' />
                        <div class="mask">
                            <h2><?php echo $article->image->name; ?></h2>
                            <p><?php echo $article->image->description; ?></p>

                            <?php if($article->image->url != "style/images/icons/png/pictures.png") { ?>
                            <a href="<?php echo base_url().$article->image->url; ?>" class="info fancybox" rel="content-images" title="<?php echo $article->image->name; ?>">Povečaj</a>
                            <?php } ?>

                            <a href="#" class="md-trigger upload-image-button header-image new-image info " data-modal="modal-image-form">Naloži</a>

                            <?php if($article->image->url != "style/images/icons/png/pictures.png") { ?>
                            <a href="#" class="md-trigger info edit-image-button" data-modal="modal-edit-image-form">Uredi</a>
                            <?php } ?>

                            <input type="hidden" value="<?php echo $article->image->ref_id; ?>" name="image_ref_id">
                            <input type="hidden" value="<?php echo $article->image->id; ?>" name="image_id">
                        </div>
                    </div>
                </div>
            </section>

            <hr>

            <section class="editable-row">
                <!-- MISC CHECKBOXES (AUTHOR NAME, PUBLISH_UP, PUBLISH_DOWN...) -->
                <div class="first-column">
                    <label class="icon user-icon" for='author_name'>Ime avtorja<span class="required">*</span></label><br/>
                    <input class="text_input" type='text' required="required" name='content[author_name]' id='author_name' value='<?php echo $article->author_name; ?>' />

                    <label class="icon eye-icon" for='publish_up'>Objava od<span class="required">*</span></label><br/>
                    <input class="text_input datepicker_up" required="required" type='text' name='content[publish_up]' id='publish_up' value='<?php echo $article->publish_up; ?>' />

                    <label class="icon eye-blocked-icon" for='publish_down'>Objava do</label><br>
                    <input class="text_input datepicker_down" type='text' name='content[publish_down]' id='publish_down' value='<?php echo $article->publish_down; ?>' />

                    <label class="icon tags-icon" for='article_tags'>Ključne besede<span class="required">*</span></label><br/>
                    <textarea class="text_input tags" required="required" style="width:100%; min-height:60px;" name='content[tags]'><?php echo $article->tags; ?></textarea><br>

                    <label class="icon locked-icon" for="locked-content" title="Pomeni, da ne more istočasno urejati članka še drug urednik.">Urejanje članka je zaklenjeno</label>
                </div>

                <!-- ADD ATTACHMENT BUTTONS -->
                <div class="second-column">
                    <input class="md-trigger icon calendar-icon" data-modal="modal-event-form" type="button" value="Dodaj dogodek" ><br>
                    <input class="icon video-icon" type="button" value="Dodaj video" ><br>
                    <input class="icon image-icon upload-image-button md-trigger new-image" data-modal="modal-image-form" type="button" value="Dodaj sliko" ><br>
                    <input class="icon images-icon" type="button" value="Dodaj galerijo" ><br>
                    <input class="icon location-icon" type="button" value="Dodaj lokacijo" ><br>
                    <input class="icon file-icon" type="button" value="Dodaj dokument" ><br>
                    <input class="icon link-icon" type="button" value="Poveži z obstoječim člankom" ><br>
                    <input class="icon users-icon" type="button" value="Dodaj urednika" ><br>
                </div>
            </section>

            <hr>

            <!-- DISPLAY ATTACHMENTS -->
            <section id="attachments-section">
                <?php foreach($article->attachments as $attachment)  {
                    if(isset($attachment->type) && $attachment->type == "multimedia") { ?>
                        <div class="view view-first" style=" margin:10px 15px 5px 0px;" >
                            <img src='<?php echo $attachment->display."?img=".rand(0,100); ?>' id="image-<?php echo $attachment->id; ?>" style="display:block; margin:0px auto; min-width:300px; min-height: 250px; max-height: 250px;" alt='article header image' />
                            <div class="mask">
                                <h2><?php echo $attachment->name; ?></h2>
                                <p><?php echo $attachment->description; ?></p>
                                <input type="hidden" value="<?php echo $attachment->ref_id; ?>" name="image_ref_id">
                                <input type="hidden" value="<?php echo $attachment->id; ?>" name="image_id">
                                <a href="<?php echo $attachment->display; ?>" class="info fancybox" rel="content-images" title="<?php echo $attachment->name; ?>">Povečaj</a>
                                <a href="#" class="md-trigger info upload-image-button new-image existing-image" data-modal="modal-image-form">Naloži</a>
                                <a href="#" class="md-trigger info edit-image-button" data-modal="modal-edit-image-form">Uredi</a>
                            </div>
                        </div>
                    <?php  } ?>
                <?php } ?>
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

                    foreach($article->domains as $domain) {
                        echo "<ul class='media'>";
                            echo "<li><img src='".$domain->favicon."' alt='media favicon'><span>".$domain->domain."</span><input type='checkbox' name='content[media][]' value='".$domain->domain."'></li>";
                            foreach($domain->menu as $menu)
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

<script type="text/javascript">

    $(".tags").autocomplete({
        source: "<?php echo base_url()."content/GetTags"; ?>",
        minLength: 2,
        focus: function() {
            return false;
        },
        select: function( event, ui ) {
            var terms = $(this).val().split(", ");

            terms.pop();
            terms.push( ui.item.value );
            terms.push( "" );

            this.value = terms.join( ", " );
            return false;
        }
    });

</script>
