<section xmlns="http://www.w3.org/1999/html">
    <header>
        <h2>Urejanje prispevka</h2>
    </header>
    <section id="content-edit">
        <form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='contentForm' enctype="multipart/form-data" >

            <section class="editable-row">
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

                <div class="second-column">
                    <label class="md-trigger icon image-icon" data-modal="modal-image-form">Naslovna slika<span class="required">*</span></label><br/>
                    <div class="view view-first" style="overflow: hidden;" >
                        <img src='<?php echo $article->image->large."?img=".rand(0,100); ?>' id="image-<?php echo $article->image->id; ?>" style="display:block; margin:0px auto; min-width:300px; min-height: 250px; max-height: 250px;" alt='article header image' />
                        <div class="mask">
                            <h2><?php echo $article->image->name; ?></h2>
                            <p><?php echo $article->image->description; ?></p>
                            <a href="<?php echo $article->image->url; ?>" class="info fancybox" rel="content-images" title="<?php echo $article->image->name; ?>">Povečaj</a>
                            <a href="#" class="md-trigger upload-image-button header-image info" data-modal="modal-image-form">Naloži</a>
                            <a href="#" class="md-trigger info edit-image-button" data-modal="modal-edit-image-form">Uredi</a>
                        </div>
                    </div>
                </div>
            </section>
            <hr>
            <section class="editable-row">
                <div class="first-column">
                    <label class="icon user-icon" for='author_name'>Ime avtorja<span class="required">*</span></label><br/>
                    <input class="text_input" type='text' required="required" name='content[author_name]' id='author_name' value='<?php echo $article->author_name; ?>' />

                    <label class="icon eye-icon" for='publish_up'>Objava od<span class="required">*</span></label><br/>
                    <input class="text_input datepicker" required="required" type='text' name='content[publish_up]' id='publish_up' value='<?php echo $article->publish_up; ?>' />

                    <label class="icon eye-blocked-icon" for='publish_down'>Objava do</label><br>
                    <input class="text_input datepicker" type='text' name='content[publish_down]' id='publish_down' value='<?php echo $article->publish_down; ?>' />

                    <label class="icon tags-icon" for='article_tags'>Ključne besede<span class="required">*</span></label><br/>
                    <textarea class="text_input tags" required="required" style="width:100%; min-height:60px;" name='content[tags]'><?php echo $article->tags; ?></textarea><br>

                    <label class="icon locked-icon" for="locked-content" title="Pomeni, da ne more istočasno urejati članka še drug urednik.">Urejanje članka je zaklenjeno</label>
                </div>

                <div class="second-column">
                    <input class="md-trigger icon calendar-icon" data-modal="modal-event-form" type="button" value="Dodaj dogodek" ><br>
                    <input class="icon video-icon" type="button" value="Dodaj video" ><br>
                    <input class="icon image-icon md-trigger new-image" data-modal="modal-image-form" type="button" value="Dodaj sliko" ><br>
                    <input class="icon images-icon" type="button" value="Dodaj galerijo" ><br>
                    <input class="icon location-icon" type="button" value="Dodaj lokacijo" ><br>
                    <input class="icon file-icon" type="button" value="Dodaj dokument" ><br>
                    <input class="icon link-icon" type="button" value="Poveži z obstoječim člankom" ><br>
                    <input class="icon users-icon" type="button" value="Dodaj urednika" ><br>
                </div>
            </section>

            <hr>

            <section>
                <?php if(count($article->attachments) > 0) echo "<h3 class='icon attachment-icon' style='background-size: 18px;'>Priponke</h3>"; ?>
                <?php foreach($article->attachments as $attachment)  {
                    if(isset($attachment->type) && $attachment->type == "multimedia") { ?>
                        <div class="view view-first" style=" margin:10px 15px 5px 0px;" >
                            <img src='<?php echo $attachment->cropped."?img=".rand(0,100); ?>' id="image-<?php echo $attachment->id; ?>" style="display:block; margin:0px auto; min-width:300px; min-height: 250px; max-height: 250px;" alt='article header image' />
                            <div class="mask">
                                <h2><?php echo $attachment->name; ?></h2>
                                <p><?php echo $attachment->description; ?></p>
                                <input type="hidden" value="<?php echo $attachment->ref_id; ?>" name="image_ref_id">
                                <input type="hidden" value="<?php echo $attachment->id; ?>" name="image_id">
                                <a href="<?php echo $attachment->url; ?>" class="info fancybox" rel="content-images" title="<?php echo $attachment->name; ?>">Povečaj</a>
                                <a href="#" class="md-trigger info upload-image-button" data-modal="modal-image-form">Naloži</a>
                                <a href="#" class="md-trigger info edit-image-button" data-modal="modal-edit-image-form">Uredi</a>
                            </div>
                        </div>
                    <?php  } ?>
                <?php } ?>
            </section>
            <hr>
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
    var jcrop_api;

    $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: new Date()
    });

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


    $(document).on("click",".crop_button",function() {
        $(this).parent().children(".image").remove();
        var url = $(this).parent().children(".hidden_url").attr("src");
        var height = $(this).parent().children(".hidden_height").val();
        var width = $(this).parent().children(".hidden_width").val();

        $(this).parent().append("<img src='"+url+"' alt='header_image' id='header_image' class='image' style='margin-bottom:15px; max-width:500px; max-height:500px; vertical-align:top;'>");

        var Image = $(this).parent().children(".image");

        $(Image).Jcrop({
            onSelect: setCoords,
            aspectRatio: 1.8,
            trueSize: [width,height]
        }, function() { jcrop_api = this });

        var Form =
            "<form action='<?php echo base_url().'content/CropImage'; ?>' method='post' class='cropping_form' style='float:right; position:relative; width:100%;'>"+
                "<input type='hidden' id='crop_x' name='crop[x]' value='' >"+
                "<input type='hidden' id='crop_y' name='crop[y]' value='' >"+
                "<input type='hidden' id='crop_x2' name='crop[x2]' value='' >"+
                "<input type='hidden' id='crop_y2' name='crop[y2]' value='' >"+
                "<input type='hidden' id='crop_w' name='crop[w]' value='' >"+
                "<input type='hidden' id='crop_h' name='crop[h]' value='' >"+
                "<input type='hidden' name='crop[content_id]' value='<?php echo $article->id; ?>' >"+
                "<input type='hidden' name='crop[image_large]' value='<?php echo $article->image->large; ?>' >"+
                "<input type='hidden' name='crop[image_url]' value='<?php echo $article->image->url; ?>' >"+
                "<input type='hidden' name='crop[image_id]' value='<?php echo $article->image->asoc_id; ?>' >"+
                "<br><br>"+
                "<input class='master_input image_settings done_crop_button' style='top:0px; right:0px;' type='submit' value='končaj'>"+
                "<input class='master_input image_settings cancel_crop_button' style='top:65px; right:0px;' type='button' value='prekliči'>"+
            "</form>";

        $(this).parent().css("border-right","thin dashed #666");
        $(this).after(Form);
        $(this).siblings(".fancybox").hide();
        $(this).hide();
    });

    function setCoords(c) {
        $("#crop_x").val(c.x);
        $("#crop_y").val(c.y);
        $("#crop_x2").val(c.x2);
        $("#crop_y2").val(c.y2);
        $("#crop_w").val(c.w);
        $("#crop_h").val(c.h);
    };

    setInterval("Update();",1000);

    function Update() {
        var Form = $("#contentForm").serialize();

        $.ajax({
            url: "<?php echo base_url()."content/Update"; ?>",
            type: "post",
            data: Form
        })
    }

    $(document).on("click",".cancel_crop_button",function() {
        var Image = $(this).parents(".image_container:first").children(".image");
        RemoveCroppingButtons(Image);
    });

    function RemoveCroppingButtons(Image) {
        var large = $(Image).siblings(".hidden_large").attr("src");
        $(Image).parent().css("border-right","thin solid #999");
        $(Image).parent().append("<img src='"+large+"' alt='header_image' class='image' id='header_image' style='max-width:500px; max-height:500px;'>");
        $(Image).remove();

        $(".cropping_form").remove();
        jcrop_api.destroy();
        $(".crop_button").show();
        $(".fancybox").show();
    }

    $(document).on("change","#header_image_upload",function() {
        $("#header_image_upload").after("<span class='loading'><br><img src='<?php echo base_url()."style/images/loading.gif"; ?>' alt='loading'>nalaganje slike..</span>");
        $("#contentForm").submit();
    });

    $(document).on("submit",".cropping_form",function(e) {
        e.preventDefault();
        var Form = $(this);

        if($("#crop_x").val() != '') {
            $(".done_crop_button").css("background-image","url('<?php echo base_url()."style/images/loading.gif"; ?>')");
            $.ajax({
                url: "<?php echo base_url().'content/CropImage'; ?>",
                type: "POST",
                data: $(this).serialize(),
                cache: false,
                success: function(data) {
                    $(".done_crop_button").css("background-image","url('<?php echo base_url()."style/images/checked.png"; ?>')");
                    $(Form).parent().children(".image").remove();
                    $(Form).parent().children(".hidden_large").attr("src",data+"?img="+Math.floor((Math.random()*1000)+1));
                    $(Form).parent().append("<img src='"+data+"?img="+Math.floor((Math.random()*1000)+1)+"' style='max-width:500px; max-height:500px;' class='image' alt='cropped image' id='header_image'>");
                    $(Form).parent().css("border-right","thin solid #999");
                    $(Form).parent().children(".fancybox").attr("href",data+"?img="+Math.floor((Math.random()*1000)+1));
                    $(".cropping_form").remove();
                    $(".crop_button").show();
                    jcrop_api.destroy();
                    $(".fancybox").show();
                }
            });
        }
        else alert("Zajamite mesto na sliki katerega želite obrezati.");
    });

    $("#SaveButton").on("click",function(e) {

        if(CheckForEmpty("contentTags") || CheckForEmpty("contentText")) {
            e.preventDefault();
            alert("Prosim vpišite vsaj eno ključno besedo.");
        }
    });

    $(document).on("click",".remove_appended",function() {
        $(this).parents("li:first").remove();
    });

    $(document).on("click",".remove_attachment",function(e) {
        e.preventDefault();
        var attacthment_id = $(this).attr("id").substr(7);
        $(this).parent().remove();

        $.ajax({
           url: "<?php echo base_url()."content/DeleteAttachment"; ?>",
           type: "post",
           data: { id:attacthment_id, asoc_id:<?php echo $article->id; ?> }
        });
    });

    $("#add_event").on("click",function(e) {
        e.preventDefault();

        var Event =
            "<li class='attachment event' style='padding-top:33px;'>"+
            "<div class='appended event'  margin-right:15px;'>"+
            "<h3>Nov dogodek</h3>"+
            "<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='eventForm' enctype='multipart/form-data'>"+
                "<label>Ime dogodka<span class='required'>*</span></label><br>"+
                "<input type='text' required name='content[name]'><br>"+
                "<label>Opis<span class='required'>*</span></label><br>"+
                "<textarea required name='content[description]'></textarea><br>"+
                "<label>Začetek<span class='required'>*</span></label><br>"+
                "<input type='text' required name='content[start_date]' class='datepicker'><br>"+
                "<label>Konec</label><br>"+
                "<input type='text' name='content[end_date]' class='datepicker'><br>"+
                "<label>Slika</label><br>"+
                "<input type='file' name='content[file][]' value='' accept='image/*' /><hr/>"+
                "<input type='submit' class='buttons' value='Dodaj'>"+
                "<input type='button' class='buttons remove_appended' value='Odstrani'>"+
                "<input type='hidden' name='content[asoc_id]' value='<?php echo $article->id; ?>'>"+
                "<input type='hidden' name='content[type]' value='event'>"+
            "</form>"+
            "</div>"+
            "</li>";

        $("#attachments_list").prepend(Event);
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: new Date()
        });
    });
    $("#add_multimedia").on("click",function(e) {
        e.preventDefault();

        var Multimedia =
            "<li class='attachment event' style='padding-top:33px;'>"+
            "<div class='appended multimedia' style='display:inline-block; margin-right:15px;'>"+
            "<h3>Nova slika</h3>"+
            "<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='multimediaForm' enctype='multipart/form-data'>"+
                "<label>Naslov<span class='required'>*</span></label><br>"+
                "<input required type='text' name='content[name]'><br>"+
                "<label>Kratek opis<span class='required'>*</span></label><br>"+
                "<textarea required name='content[description]'></textarea><br>"+
                "<label>Slika<span class='required'>*</span></label><br>"+
                "<input required type='file' name='content[file][]' accept='image/*'><hr>"+
                "<input type='submit' class='buttons' value='Dodaj'>"+
                "<input type='button' class='buttons remove_appended' value='Odstrani'>"+
                "<input type='hidden' name='content[asoc_id]' value='<?php echo $article->id; ?>'>"+
                "<input type='hidden' name='content[type]' value='multimedia'>"+
            "</form>"+
            "</div>"+
            "</li>";

        $("#attachments_list").prepend(Multimedia);
    });
    $("#add_gallery").on("click",function(e) {
        e.preventDefault();

        var Gallery =
            "<li class='attachment event' style='padding-top:33px;'>"+
                "<div class='appended multimedia' style='display:inline-block; margin-right:15px;'>"+
                "<h3>Nova galerija</h3>"+
                "<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='galleryForm' enctype='multipart/form-data'>"+
                    "<label>Naslov<span class='required'>*</span></label><br>"+
                    "<input required type='text' name='content[name]'><br>"+
                    "<label>Kratek opis<span class='required'>*</span></label><br>"+
                    "<textarea required name='content[description]'></textarea><br>"+
                    "<label>Izberite slike<span class='required'>*</span></label><br>"+
                    "<input required type='file' multiple name='content[file][]' accept='image/*'><hr>"+
                    "<input type='submit' class='buttons' value='Dodaj'>"+
                    "<input type='button' class='buttons remove_appended' value='Odstrani'>"+
                    "<input type='hidden' name='content[asoc_id]' value='<?php echo $article->id; ?>'>"+
                    "<input type='hidden' name='content[type]' value='gallery'>"+
                "</form>"+
                "</div>"+
            "</li>";

        $("#attachments_list").prepend(Gallery);
    });
    $("#add_location").on("click",function(e) {
        e.preventDefault();

        var Location =
            "<li class='attachment event' style='padding-top:33px;'>"+
            "<div class='appended locations' style='display:inline-block; margin-right:15px;'>"+
            "<h3>Nova lokacija</h3>"+
            "<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='locationsForm'>"+
                "<label>Mesto</label><br>"+
                "<input required type='text' name='content[city]'><br>"+
                "<label>Poštna številka</label><br>"+
                "<input size='6' required type='text' name='content[post_number]'><br>"+
                "<label>Ulica</label><br>"+
                "<input size='40' required type='text' name='content[street_village]'><br>"+
                "<label>Hišna številka</label><br>"+
                "<input size='6' type='text' name='content[house_number]'><br>"+
                "<label>Država</label><br>"+
                "<input required type='text' name='content[country]' value='Slovenija'><hr>"+
                "<input type='submit' class='buttons' value='Dodaj'>"+
                "<input type='button' class='buttons remove_appended' value='Odstrani'>"+
                "<input type='hidden' name='content[asoc_id]' value='<?php echo $article->id; ?>'>"+
                "<input type='hidden' name='content[type]' value='location'>"+
            "</form>"+
            "</div>"+
            "</li>";

        $("#attachments_list").prepend(Location);
    });
</script>
