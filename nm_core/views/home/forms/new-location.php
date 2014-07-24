<?php if($js == '/true') echo '<h3 style="padding-bottom:15px;">Nova lokacija</h3>'; ?>

<form action="<?php echo base_url()."content/Update".$js; ?>" method="post" style="padding: 15px;" enctype="multipart/form-data" class="upload-form" id="edit-event-form">
    <div>
        <label>Dražava <span class="required">*</span> </label>
        <input type="text" size="20" required="required" name="content[country]" value="<?php echo (isset($content->country) ? $content->country : 'Slovenija'); ?>">

        <label>Regija</label>
        <input type="text" value="<?php echo (isset($content->region) ? $content->region : ''); ?>" size="30" name="content[region]" >
    </div>

    <div style="display: inline-block;">
        <label>Kraj ali vas<span class="required">*</span></label>
        <input type="text" required="required" value="<?php echo (isset($content->city) ? $content->city : ''); ?>" size="30" name="content[city]">
    </div>

    <br>

    <div style="display: inline-block;">
        <label>Ulica</label>
        <input type="text" value="<?php echo (isset($content->street_village) ? $content->street_village : ''); ?>" size="50" name="content[street_village]">
    </div>

    <div style="display: inline-block; margin-left: 20px;">
        <label>Hišna številka</label>
        <input type="text" pattern="[1-9][0-9]*[A-Za-z]?" size="10" value="<?php echo (isset($content->house_number) ? $content->house_number : ''); ?>" name="content[house_number]">
    </div>

    <div>
        <label>Poslopje ali soba</label>
        <input type="text" value="<?php echo (isset($content->room_name) ? $content->room_name : ''); ?>" size="20" name="content[room_name]">
    </div>

    <br>

    <input type="button" value="Prekliči" class="icon cancel-icon md-close">
    <input type="submit" class="icon save-icon" value="Shrani">
    <input type="hidden" name="content[type]" value="location">

    <?php foreach($hidden as $input) { ?>
        <input type="hidden" name="<?php echo 'content['.$input['name'].']'; ?>" value="<?php echo $input['value']; ?>">
    <?php } ?>
</form>