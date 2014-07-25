// INIT
var plugins = new __constructPlugins();
setInterval(function() { plugins.autosave(); }, 2000);

jQuery(document).ready(function() {

    // TEXT EDITOR
    jQuery(".editor").jqte({
        sub: false,
        sup: false,
        strike: false,
        remove: false,
        formats: [
            ["p","Navadni"],
            ["h1","Naslov 1"],
            ["h2","Naslov 2"],
            ["h3","Naslov 3"],
            ["h4","Naslov 3"]
        ]
    });

    plugins.init();
});

// AJAX
jQuery(".upload-form").on("submit",function() {
    var loader = new __constructLoader();
    loader.load();
});

// EDIT IMAGE
jQuery(".edit-image-button").on("click",function() {
    var image = jQuery("#modal-edit-image");
    var current_image_id = 0;
    var current_image_url = "";
    var current_image_display = "";

    if(jQuery(this).hasClass("header-image")) {
        current_image_id = jQuery(this).parent().siblings("img").attr("id").substr(6);
        current_image_url = base_url+jQuery(this).siblings("input[name=image_url]").val();
        current_image_display = base_url+jQuery(this).siblings("input[name=image_display]").val();
    } else {
        current_image_id = jQuery(this).siblings("input[name=id]").val();
        current_image_url = base_url+jQuery(this).siblings("input[name=url]").val();
        current_image_display = base_url+jQuery(this).siblings("input[name=display]").val();
    }

    image.attr("src",current_image_url+"?img="+Math.floor((Math.random() * 1000) + 1));
    jQuery(".current-image-id").val(current_image_id);
    jQuery(".current-image-display").val(current_image_display);
});

// CROPPING
jQuery("#crop-image").on("click",function() {
    classie.toggle(this,"crop");
    jQueryimage = jQuery("#modal-edit-image");

    if(jQuery(this).hasClass("crop")) {
        jQuery(this).attr("value","končaj z obrezovanjem");
        jQuery(this).addClass("md-close");

        classie.removeClass(this,"crop-icon");
        classie.addClass(this,"check-icon");

        jQueryimage.addClass("cropping");
        jQueryimage.cropper("enable");
        jQueryimage.cropper("setAspectRatio", 1.5);
    } else {
        classie.removeClass(this,"check-icon");
        classie.addClass(this,"crop-icon");
        jQuery(this).attr("value","obreži sliko");

        var crop_data = jQueryimage.cropper("getData");
        jQuery("#crop-x").val(crop_data.x1);
        jQuery("#crop-y").val(crop_data.y1);
        jQuery("#crop-x2").val(crop_data.x2);
        jQuery("#crop-y2").val(crop_data.y2);
        jQuery("#crop-w").val(crop_data.width);
        jQuery("#crop-h").val(crop_data.height);

        jQuery(this).parent().submit();
    }
});

/*jQuery(".md-close").on("click",function() {
    jQueryimage = jQuery("#modal-edit-image");
    jQuerycrop_button = jQuery("#crop-image");
    jQuerycrop_button.removeClass("check-icon");
    jQuerycrop_button.addClass("crop-icon");
    jQuerycrop_button.val("obreži sliko");
    jQuerycrop_button.removeClass("crop");

    if(jQueryimage.hasClass("cropping"))jQueryimage.cropper("disable");
});
*/

// DELEGATES (onclick body events that open the modal window)
jQuery(document.body).delegate(".md-trigger", "click",function() {
    var modalId = this.getAttribute('data-modal');
    var title = this.getAttribute('title');
    var pop = new __constructModal(modalId,title);

    var id = jQuery(this).siblings('.current-content-id').val();
    var hidden = jQuery(this).siblings('input[type=hidden]');
    var inputs = [];



    jQuery.each(hidden,function(key,value) { inputs.push({name: jQuery(value).attr('name'), value: jQuery(value).attr('value')}); });
    jQuery.ajax({
        url: base_url+'content/GetModal/'+modalId,
        type: 'POST',
        data: {
            id: id,
            ajax: true,
            title:title,
            hidden: inputs
        },
        success: function(data) {
            pop.AddContent(data);
            pop.Show();

            var plugins = new __constructPlugins();
            plugins.init();
        }
    }).fail(function(data) { console.log(data); });
});

jQuery(document.body).delegate('.md-close','click',function() {
    var modal = new __constructModal();
    var plugins = new __constructPlugins();

    modal.Remove(jQuery(this).parents('.md-modal:first').attr('id'));
    plugins.init();
});

jQuery(document.body).delegate(".delete-attachment-button", "click",function() {
    var id = jQuery(this).siblings(".current-content-id").val();

    jQuery.ajax({
        url: base_url+"content/DeleteAttachment",
        type: "post",
        data: { id: id, asoc_id: asoc_id }
    });

    jQuery(this).parent().parent().parent().fadeOut("fast",function() { jQuery(this).remove(); });
});

jQuery(document.body).delegate('#crop-image','click',function() {
    classie.toggle(this,"crop");
    jQueryimage = jQuery("#modal-edit-image");

    if(jQuery(this).hasClass("crop")) {
        jQuery(this).attr("value","končaj z obrezovanjem");
        jQuery(this).addClass("md-close");

        classie.removeClass(this,"crop-icon");
        classie.addClass(this,"check-icon");

        jQueryimage.addClass("cropping");
        jQueryimage.cropper("enable");
        jQueryimage.cropper("setAspectRatio", 1.5);
    } else {
        classie.removeClass(this,"check-icon");
        classie.addClass(this,"crop-icon");
        jQuery(this).attr("value","obreži sliko");

        var crop_data = jQueryimage.cropper("getData");
        jQuery("#crop-x").val(crop_data.x1);
        jQuery("#crop-y").val(crop_data.y1);
        jQuery("#crop-x2").val(crop_data.x2);
        jQuery("#crop-y2").val(crop_data.y2);
        jQuery("#crop-w").val(crop_data.width);
        jQuery("#crop-h").val(crop_data.height);

        jQuery(this).parent().submit();
    }
});

jQuery(document.body).delegate('.ajax-form','submit',function() {
    // TODO
    console.log("submiting ajax form..");
});

jQuery(".new-image").on("click",function() {
    if(jQuery(this).hasClass("header-image")) {
        var image_id = jQuery(this).siblings("input[name=id]").val();

        if(image_id == "0") jQuery(".gallery-image-update").val("false"); else jQuery(".gallery-image-update").val("true");
        jQuery("#upload-header-type").val("true");
        jQuery(".gallery-image-header").val("true");
    }
    else {
        jQuery(".gallery-image-update").val("false");
        jQuery("#upload-header-type").val("false");
        jQuery(".gallery-image-header").val("false");
    }
});

jQuery("#new-image-form").on("submit",function() {
    var loader = new __constructLoader();
    loader.load();
});

jQuery('body').delegate('#new-image-form','submit',function() {
    console.log("click");
});

jQuery(".info").on("click",function(e) {
    e.preventDefault();
});

// DELETE
jQuery(".delete-image").on("submit",function() {
    var image_id = jQuery(this).children(".current-image-id").val();

    jQuery("#image-"+image_id).parent().remove();

});

// EDIT IMAGE
jQuery(".transform-image-form").on("submit",function(e) {
    e.preventDefault();
    var image_id = jQuery(this).children(".current-image-id").val();
    var url = jQuery(this).children("input[name=url]").val();
    var image = jQuery("#image-"+image_id);
    var loader = new __constructLoader();

    loader.load();
    jQuery.ajax({
        dataType: "json",
        url: jQuery(this).attr("action"),
        type: jQuery(this).attr("method"),
        data: jQuery(this).serialize(),
        success: function(data) {
            image.attr("src",base_url+data.medium+"?img="+Math.floor((Math.random() * 1000) + 1));
            image.parent().attr("href",base_url+data.extra_large+"?img="+Math.floor((Math.random() * 1000) + 1));
            loader.unload();
        }
    });
});

// EDIT CONTENT
jQuery(".edit-content-button").on("click",function() {
    var name = jQuery(this).siblings("input[name=name]").val();
    var id = jQuery(this).siblings("input[name=id]").val();
    var description = jQuery(this).siblings("input[name=description]").val();
    var type = jQuery(this).siblings("input[name=type]").val();
    var url = jQuery(this).siblings("input[name=url]").val();
    var tags = jQuery(this).siblings("input[name=tags]").val();
    var header = (jQuery(this).siblings("input[name=header]").val() == "1" ? "true" : "false");

    jQuery(".current-content-name").val(name);
    jQuery(".current-content-header").val(header);
    jQuery(".current-content-tags").text(tags);
    jQuery(".current-content-id").val(id);
    jQuery(".current-content-type").val(type);
    jQuery(".current-content-description").text(description);
    jQuery(".current-content-url").val(url);
});

// EDIT EVENT
jQuery(".edit-event-button").on("click",function() {
    var name = jQuery(this).siblings("input[name=name]").val();
    var id = jQuery(this).siblings("input[name=id]").val();
    var ref_id = jQuery(this).siblings("input[name=ref_id]").val();
    var description = jQuery(this).siblings("input[name=description]").val();
    var type = jQuery(this).siblings("input[name=type]").val();
    var date_start = jQuery(this).siblings("input[name=start_date]").val();
    var date_end = (jQuery(this).siblings("input[name=end_date]").val().substr(0,10) == "0000-00-00" ? "" : jQuery(this).siblings("input[name=end_date]").val());

    jQuery(".datepicker_down_event").val(date_end.substr(0,10));
    jQuery(".datepicker_up_event").val(date_start.substr(0,10));
    jQuery(".current-event-name").val(name);
    jQuery(".current-event-id").val(id);
    jQuery(".current-event-ref-id").val(ref_id);
    jQuery(".current-event-type").val(type);
    jQuery(".current-event-description").text(description);
});

// ADD MENU TAG
jQuery(".add-tag").on("change",function(e) {
    var tag = jQuery(this).val();
    var tags = jQuery("#article_tags");
    var current = tags.text().split(',');
    var new_tags = "";

    classie.toggle(this,"checked");

    if(jQuery(this).hasClass("checked")) {
        var not_here = true;
        var media = jQuery(this).parents(".media:first");
        var domain = media.children("li:first").children(".domain:first");

        if(!domain.is(":checked")) domain.prop("checked",true);

        jQuery.each(current,function(key,value) {
            if(jQuery.trim(value) == tag) not_here = false;

            new_tags = (new_tags != "" ?  new_tags + "," + value : value ) ;
        });

        if(not_here) new_tags = new_tags + ", " + tag;
    }
    else {
        jQuery.each(current,function(key,value) {
            if(jQuery.trim(value) != tag) new_tags = (new_tags != "" ?  new_tags + "," + value : value ) ;
        });
    }

    tags.text(new_tags);
});

jQuery(".domain").on("change",function(e) {
    if(jQuery(this).hasClass("checked")) {
        jQuery(this).parent().siblings().fadeIn("fast");
    }
    else {
        jQuery(this).parent().siblings().fadeOut("fast");
    }
});

// EDIT EVENT
jQuery(".edit-location-button").on("click",function() {
    var id = jQuery(this).siblings("input[name=id]").val();
    var ref_id = jQuery(this).siblings("input[name=ref_id]").val();
    var country = jQuery(this).siblings("input[name=country]").val();
    var city = jQuery(this).siblings("input[name=city]").val();
    var house_number = jQuery(this).siblings("input[name=house_number]").val();
    var region = jQuery(this).siblings("input[name=region]").val();
    var street_village = jQuery(this).siblings("input[name=street_village]").val();

    jQuery(".current-location-id").val(id);
    jQuery(".current-location-ref_id").val(ref_id);
    jQuery(".current-location-country").val(country);
    jQuery(".current-location-city").val(city);
    jQuery(".current-location-house_number").val(house_number);
    jQuery(".current-location-region").val(region);
    jQuery(".current-location-street_village").val(street_village);
});

// DELETE BUG
jQuery(".delete-bug-button").on("click",function() {
    var id = jQuery(this).siblings("input[name=id]").val();
    var attachment = jQuery("#bug-"+id);

    jQuery.ajax({
        url: base_url+"content/RemoveBug",
        type: "POST",
        data: { id: id},
        success: function() { attachment.remove(); }
    }).fail(function(data) { console.log(data); });
});

