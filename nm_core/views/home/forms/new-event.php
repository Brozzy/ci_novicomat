<?php if($js == '/true') echo '<h3 style="padding-bottom:15px;">Nov dogodek</h3>'; ?>

<form action="<?php echo base_url()."content/Update",$js; ?>" method="post" style="padding: 15px;" enctype="multipart/form-data" class="upload-form" <?php if($js == '/true') echo 'id="contentForm"'; ?>>
    <label class="icon edit-icon" for="video-title">Naslov</label>
    <input type="text" name="content[name]" id="video-title" size="30" value="<?php echo (isset($content->name) ? $content->name : ''); ?>">

    <label class="icon edit-icon" for="video-description">Opis</label>
    <textarea name="content[description]" id="video-description" style="width:70%; height:70px;"><?php echo (isset($content->description) ? $content->description : ''); ?></textarea>

    <label class="icon tags-icon" for="video-tags">Ključne besede</label>
    <input type="text" class="tags" name="content[tags]" size="50" id="video-tags" value="<?php echo (isset($content->tags) ? implode(', ',$content->tags) : ''); ?>">

    <label for="upload-local" class="icon image-icon">Dodajte dogodku naslovno sliko</label>
    <input type="file" accept="image/*" name="content[file][]"><br>

    <div style="display: inline-block;">
        <label class="icon eye-icon" for='publish_up'>Začetek dogodka<span class="required">*</span></label>
        <input class="datepicker_up_event" required="required" type='text' name='content[start_date]' id='publish_up_event' placeholder="llll-mm-dd" value="<?php echo (isset($content->start_date) ? substr($content->start_date,0,10) : ''); ?>" style="display: inline-block;" />
    </div>

    <div style="display: inline-block; margin-left: 15px;">
        <label class="icon clock-icon" for='publish_up'>ura</label>
        <input type='text' pattern="[0-2][0-9]\:[0-5][0-9]" name='content[start_time]' placeholder="hh:mm" value="<?php echo (isset($content->start_date) ? substr($content->start_date,11,5) : '00:00'); ?>" required="required" style="display: inline-block;" size="10" maxlength="10" />
    </div>

    <br>

    <div style="display: inline-block;">
        <label class="icon eye-blocked-icon" for='publish_down'>Konec</label>
        <input class="datepicker_down_event" type='text' name='content[end_date]' id='publish_down_event' placeholder="llll-mm-dd" value="<?php echo (isset($content->end_date) ? substr($content->end_date,0,10) : ''); ?>" style="display: inline-block;" />
    </div>

    <div style="display: inline-block; margin-left: 15px;">
        <label class="icon clock2-icon" for='publish_up'>ura</label>
        <input type='text' pattern="[0-2][0-9]\:[0-5][0-9]" name='content[end_time]' placeholder="hh:mm" required="required" value="<?php echo (isset($content->end_date) ? substr($content->end_date,11,5) : '00:00'); ?>" style="display: inline-block;" size="10" />
    </div>

    <br>

    <input type="button" value="Prekliči" class="icon cancel-icon md-close">

    <span>
        <input type="hidden" name='asoc_id' value="<?php echo $content->id; ?>">
        <input type="hidden" name='type' value="location">
    </span>

    <input type="submit" class="icon upload-icon" value="Shrani">

    <input type="hidden" name="content[id]" value="<?php echo (isset($content->id) ? $content->id : '0'); ?>">
    <input type="hidden" name="content[url]" value="<?php echo (isset($content->url) ? $content->url : ''); ?>">
    <input type="hidden" name="content[type]" value="event">

    <?php foreach($hidden as $input) { ?>
        <input type="hidden" name="<?php echo 'content['.$input['name'].']'; ?>" value="<?php echo $input['value']; ?>">
    <?php } ?>
</form>