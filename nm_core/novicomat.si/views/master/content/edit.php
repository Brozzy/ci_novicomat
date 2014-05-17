
<style type="text/css" scoped>
	#GalleryContainer { width:100%; -webkit-transition:opacity 0.5s; -moz-transition:opacity 0.5s; transition:opacity 0.5s; opacity:0.5; }
	#GalleryContainer:hover { -webkit-transition:opacity 0.5s; -moz-transition:opacity 0.5s; transition:opacity 0.5s; opacity:1; }
	.appended { vertical-align:top; }

    .remove_attachment {
        position:absolute;
        top:40px; right:10px;
        width:auto; min-width:auto;
        background-color:Transparent;
        color:white;
        border:none; cursor:pointer;
    }
    .remove_attachment:hover { color:#FF6D68; }
    .attachment {
        position:relative;
        display:inline-block;
        vertical-align:top;
        margin-right:20px;
        padding:5px;
        min-width:300px; min-height:300px;
        border:thin solid #888; margin-bottom:20px;
    }
    .attachment h3 {
        margin:0px 0px 10px 0px;
        border:thin solid #333;
    }

    .attachment h4 {
        text-align:center;
        margin:5px; color:#333;
        text-transform:uppercase;
    }

    .attachment input {
       margin-bottom:10px;
    }

    .attachment hr {
        padding-top:5px;
        margin-bottom:10px;
    }

    .attachment .buttons {
        float:right;
        margin-left:10px;
        cursor:pointer;
    }

    .table-cell {
        display:table-cell;
        border-bottom:thin solid #222;
        padding:15px 0px;
    }
    .table-cell input {
        margin-bottom:15px;
    }
    section .header-image {
        width:30%;
    }
    section .content {
    }

    .image_display {
        position:absolute;
        left:auto;right:auto; top:5%;
    }

    .fancy_button {
        background-color:transparent;
        border:none;
        background-repeat:no-repeat;
        background-size:150px 150px;
        background-position:center;
        padding-bottom:180px; padding-top:10px;
        width:190px;
        cursor:pointer;
        font-size:1.1em;
        -webkit-filter: grayscale(100%);
        -moz-filter: grayscale(100%);
        filter: grayscale(100%);
    }
    .fancy_button:hover {
        -webkit-filter:none;
        filter:none;
        -moz-filter:none;
        background-color:#174371; color:white;
    }

    .image_button {
        background-image:url("<?php echo base_url()."style/images/image.png"; ?>");

    }
    .event_button {
        background-image:url("<?php echo base_url()."style/images/calendar.png"; ?>");
    }

    .location_button {
        background-image:url("<?php echo base_url()."style/images/location.png"; ?>");
    }
</style>

<section style='padding:20px; color:#222;'>
	<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='contentForm' enctype="multipart/form-data" >
        <section style="display:table; width:100%;">
            <section class="table-cell header-image">
                <label for='header_image'>Naslovna slika</label><br/>
                <img src='<?php echo base_url().$article->image->cropped; ?>' style="max-width:300px; max-height:300px;" alt='article header image' id='header_image' />
                <br/>
                <input type='file' name='content[image]' id='header_image_upload' value='' accept='image/*' />
                <br>
                <img src="<?php echo $article->image->url; ?>" style="display:none;">

                <input class='master_input crop_image' type='button' value='Obreži sliko' style='<?php if($article->image->cropped == "style/images/image_upload.png") echo "display:none"; else echo "display:inline-block;"; ?>'><br>
            </section>

            <section class="table-cell content" style="padding-left:30px;">
                <label for='name'>Naslov</label><br/>
                <input type='text' required name='content[name]' size="30" id='name' value='<?php echo $article->name; ?>' /><br/>

                <label for='description'><?php if($article->type == "article") echo "Uvodno besedilo"; else echo "Opis"; ?></label><br/>
                <textarea name='content[description]' required style="width:60%; min-height:50px;" id='description'><?php echo $article->description; ?></textarea><br/>

                <label for='text'>Besedilo</label><br/>
                <textarea class="editor" name='content[text]' style="width:95%; min-height:150px;" id='text'><?php echo $article->text; ?></textarea><br/>

                <input type="hidden" value='<?php echo $article->id; ?>' name='content[id]'>
                <input type="hidden" value='<?php echo $article->ref_id; ?>' name='content[ref_id]'>
                <input type="hidden" value='<?php echo $article->type; ?>' name='content[type]'>
            </section>
        </section>

        <section style="display:table; width:100%;">
            <section class="table-cell misc" style="width:32.7%;">
                <label for='author_name'>Ime avtorja</label><br/>
                <input type='text' name='content[author_name]' id='author_name' value='<?php echo $article->author_name; ?>' /><br/>

                <label for='publish_up'>Objava</label><br/><br>
                <label style="margin-right:5px;">od</label><input type='text' class="datepicker" name='content[publish_up]' id='publish_up' value='<?php echo $article->publish_up; ?>' />
                <br>
                <label for='publish_down'>do</label>
                <input type='text' class="datepicker" name='content[publish_down]' id='publish_down' value='<?php echo $article->publish_down; ?>' /><br/>

                <label for='article_tags'>Ključne besede</label><br/>
                <input type='text' value='<?php echo $article->tags; ?>' name='content[tags]' class="tags" id='article_tags'/><br/>
            </section>

            <section class="table-cell attachments">
                <input class="fancy_button event_button" type="button" id='add_event' value="Dodaj dogodek" >
                <input class="fancy_button image_button" type="button" id='add_multimedia' value="Dodaj sliko" >
                <input class="fancy_button location_button" type="button" id='add_location' value="Dodaj lokacijo" >
                <br>
            </section>
        </section>

        <section style="display:table; width:100%;">

            <ul style="padding:0px; list-style:none;" id="attachments_list">
                <?php foreach($article->attachments as $attachment)  {
                    if(isset($attachment->type) && $attachment->type == "image")
                        echo "<li class='attachment image'>
                                    <h4>".$attachment->name."</h4>
                                    <h3>Slika</h3>
                                    <a class='fancybox' rel='image_attachments' href='".base_url().$attachment->url."' title='".$attachment->description."'>
                                        <img src='".base_url().$attachment->medium."' alt='image attachment thumbnail'>
                                    </a>
                                    <input type='button' class='remove_attachment' id='remove_".$attachment->id."' value='odstrani'>
                                 </li>";
                    else if(isset($attachment->type) && $attachment->type == "event") {
                        echo "<li class='attachment event'>
                                    <h4>".$attachment->name."</h4>
                                    <h3>Dogodek</h3>";
                                    if($attachment->image->medium != "style/images/image_upload.png")
                                        echo "<a class='fancybox' href='".base_url().$attachment->image->url."'>
                                                <img style='max-width:300px; max-height:225px;' src='".base_url().$attachment->image->medium."' alt='image attachment thumbnail'>
                                            </a>";

                       echo        "<p>".$attachment->description."</p>
                                    <p>Začetek: ".$attachment->start_date."</p>
                                    <p>Konec: ".$attachment->end_date."</p>
                                    <input type='button' class='remove_attachment' id='remove_".$attachment->id."' value='odstrani'>
                              </li>";
                    }
                    else if(isset($attachment->type) && $attachment->type == "location")
                        echo "<li class='attachment location'>
                                <h4>".$attachment->country."</h4>
                                <h3>Lokacija</h3>
                                <p>Mesto: ".$attachment->post_number." ".$attachment->city."</p>
                                <p>Ulica ali vas: ".$attachment->street_village."</p>
                                <p>Hišna številka: ".$attachment->house_number."</p>
                                <input type='button' class='remove_attachment' id='".$attachment->id."' value='odstrani'>
                              </li>";
                } ?>
            </ul>
        </section>

        <section style="display:table; width:100%;">
            <?php
                /*$iterator = new RecursiveArrayIterator($article->domains);
                while ($iterator->valid()) {

                    if ($iterator->hasChildren()) {
                        // print all children
                        foreach ($iterator->getChildren() as $key => $value) {
                            echo "<br>"; var_dump($value); echo "<br>";
                        }
                    }

                    $iterator->next();
                }*/
                function loop_trough($value) {
                    if(is_array($value)) {
                        foreach($value as $v) {
                            echo "<div style='padding-left:30px;'>";
                            loop_trough($v);
                            echo "</div>";
                        }
                    }
                    else echo "<div style='padding-left:30px;'>".$value."</div>";
                }

                foreach($article->domains as $domain) {
                    echo $domain->domain;
                    foreach($domain->menu as $menu) {
                        loop_trough($menu);
                    }
                }
            ?>
        </section>

        <section style="display:table; width:100%;">
            <section class="table-cell cp">
                <input class='master_input' type='button' value='Nazaj' onclick="window.location.href='<?php echo base_url()."Domov"; ?>'"/>
                <input class='master_input' type='submit' style="float:right;" value='Shrani' formaction='<?php echo base_url()."content/Update"; ?>'/>

                <?php if($user->level > 3) { ?>
                    <input class='master_input' type='submit' value='Objavi' formaction='<?php echo base_url()."content/Publish"; ?>'/>
                <?php } else { ?>
                    <input class='master_input' type='submit' style="float:right; margin-right:15px;" value='Pošlji v pregled' formaction='<?php echo base_url()."content/Editing"; ?>'/>
                <?php } ?>
            </section>
        </section>
	</form>

</section>

<script type="text/javascript">
    var jcrop_api;

    $(".fancybox").fancybox({
        showNavArrows: true
    });
    $(".editor").jqte();
    $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: new Date()
    });
    $(".tags").tagsInput({

    });

    $(document).on("click",".crop_image",function() {
        var Image = $("#header_image");
        $(Image).attr("src","<?php echo base_url().$article->image->medium; ?>");
        $(Image).Jcrop({
            onSelect: showCoords
        }, function() { jcrop_api = this });
    });

    function showCoords(c) {
        var Image = $("#header_image");

        var Form =
            "<form action='<?php echo base_url().'content/CropImage'; ?>' method='post' id='image_crop_form' style='display:inline-block;'>"+
                "<input type='hidden' name='crop[x]' value='"+c.x+"' >"+
                "<input type='hidden' name='crop[y]' value='"+c.y+"' >"+
                "<input type='hidden' name='crop[x2]' value='"+c.x2+"' >"+
                "<input type='hidden' name='crop[y2]' value='"+c.y2+"' >"+
                "<input type='hidden' name='crop[w]' value='"+c.w+"' >"+
                "<input type='hidden' name='crop[h]' value='"+c.h+"' >"+
                "<input type='hidden' name='crop[content_id]' value='<?php echo $article->id; ?>' >"+
                "<input type='hidden' name='crop[image_medium]' value='<?php echo $article->image->medium; ?>' >"+
                "<input type='hidden' name='crop[image_url]' value='<?php echo $article->image->url; ?>' >"+
                "<input type='hidden' name='crop[image_id]' value='<?php echo $article->image->asoc_id; ?>' >"+
                "<input type='button' id='cancel_cropping' value='prekliči'>"+
                "<input type='submit' value='končaj z obrezovanjem'>"+
            "</form>";

        $(".crop_image").after(Form);
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

    $(document).on("click","#cancel_cropping",function() {
        $(this).parent().remove();
        jcrop_api.destroy();
    });

    $(document).on("submit","#image_crop_form",function(e) {
        e.preventDefault();
        var Crop = $(this).serialize();
        jcrop_api.destroy();

        $.ajax({
            url: "<?php echo base_url().'content/CropImage'; ?>",
            type: "POST",
            data: Crop,
            success: function(data) {
                $("#header_image").attr("src",data);
            }
        }).fail(function(data) { console.log(data); });

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
        }).fail(function(data) { console.log(data); });
    });

    $("#add_event").on("click",function(e) {
        e.preventDefault();

        var Event =
            "<li class='attachment event' style='padding-top:33px;'>"+
            "<div class='appended event'  margin-right:15px;'>"+
            "<h3>Nov dogodek</h3>"+
            "<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='eventForm' enctype='multipart/form-data'>"+
                "<label>Ime dogodka</label><br>"+
                "<input type='text' required name='content[name]'><br>"+
                "<label>Opis</label><br>"+
                "<textarea required name='content[description]'></textarea><br>"+
                "<label>Začetek</label><br>"+
                "<input type='text' required name='content[start_date]' class='datepicker'><br>"+
                "<label>Konec</label><br>"+
                "<input type='text' name='content[end_date]' class='datepicker'><br>"+
                "<label>Slika</label><br>"+
                "<input type='file' name='content[attachments_image]' value='' accept='image/*' /><hr/>"+
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
                "<label>Naslov</label><br>"+
                "<input required type='text' name='content[name]'><br>"+
                "<label>Kratek opis</label><br>"+
                "<textarea required name='content[description]'></textarea><br>"+
                "<label>Slika</label><br>"+
                "<input required type='file' name='content[attachments_image]' accept='image/*,video/*'><hr>"+
                "<input type='submit' class='buttons' value='Dodaj'>"+
                "<input type='button' class='buttons remove_appended' value='Odstrani'>"+
                "<input type='hidden' name='content[asoc_id]' value='<?php echo $article->id; ?>'>"+
                "<input type='hidden' name='content[type]' value='image'>"+
            "</form>"+
            "</div>"+
            "</li>";

        $("#attachments_list").prepend(Multimedia);
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
