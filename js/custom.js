// GLOBAL VAR
var base_url = $("#base_url").val();
var loader = {
    load: function() {
        $(".loader").fadeIn("fast");
    },
    unload: function() {
        $(".loader").fadeOut("fast");
    }
}

// INIT
$(document).ready(function() {
    $('.fancybox').fancybox();
    $(".editor").jqte({
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
    $('.scrollbar').perfectScrollbar({
        wheelSpeed: 10,
        suppressScrollX: true,
        includePadding: true
    });

    var datepicker_up = $(".datepicker_up");
    var datepicker_down = $(".datepicker_down");

    var datepicker_up_event = $(".datepicker_up_event");
    var datepicker_down_event = $(".datepicker_down_event");

    datepicker_up_event.on("change",function() {
        datepicker_down_event.datepicker( "destroy" );

        if(datepicker_down_event.val() < $(".datepicker_up_event").val())
            $(".datepicker_down_event").val('');

        datepicker_down_event.datepicker({
            dateFormat: "yy-mm-dd",
            minDate: $(this).val()
        });
    });

    datepicker_up_event.datepicker({
        dateFormat: "yy-mm-dd"
    });

    datepicker_down_event.datepicker({
        dateFormat: "yy-mm-dd",
        minDate: datepicker_up_event.val()
    });

    datepicker_up.on("change",function() {
        datepicker_down.datepicker( "destroy" );

        if(datepicker_down.val() < $(".datepicker_up").val())
            $(".datepicker_down").val('');

        datepicker_down.datepicker({
            dateFormat: "yy-mm-dd",
            minDate: $(this).val()
        });
    });

    datepicker_up.datepicker({
        dateFormat: "yy-mm-dd"
    });

    datepicker_down.datepicker({
        dateFormat: "yy-mm-dd",
        minDate: datepicker_up.val()
    });
});

// AJAX
$(".ajax-form").on("submit",function(e) {
    e.preventDefault();

    $.ajax({
        url: $(this).attr("action"),
        type: $(this).attr("method"),
        data: $(this).serialize(),
        success: function(data) {
        }
    });
});
$(".upload-form").on("submit",function() {
    loader.load();
});

// EDIT IMAGE
$(".edit-image-button").on("click",function() {
    var image = $("#modal-edit-image");
    var current_image_id = 0;
    var current_image_url = "";
    var current_image_display = "";

    if($(this).hasClass("header-image")) {
        current_image_id = $(this).parent().siblings("img").attr("id").substr(6);
        current_image_url = base_url+$(this).siblings("input[name=image_url]").val();
        current_image_display = base_url+$(this).siblings("input[name=image_display]").val();
    } else {
        current_image_id = $(this).siblings("input[name=id]").val();
        current_image_url = base_url+$(this).siblings("input[name=url]").val();
        current_image_display = base_url+$(this).siblings("input[name=display]").val();
    }

    image.attr("src",current_image_url+"?img="+Math.floor((Math.random() * 1000) + 1));
    $(".current-image-id").val(current_image_id);
    $(".current-image-display").val(current_image_display);
});

// CROPPING
$("#crop-image").on("click",function() {
    classie.toggle(this,"crop");
    $image = $("#modal-edit-image");

    if($(this).hasClass("crop")) {
        $(this).attr("value","končaj z obrezovanjem");
        $(this).addClass("md-close");

        classie.removeClass(this,"crop-icon");
        classie.addClass(this,"check-icon");

        $image.addClass("cropping");
        $image.cropper("enable");
        $image.cropper("setAspectRatio", 1.5);
    } else {
        classie.removeClass(this,"check-icon");
        classie.addClass(this,"crop-icon");
        $(this).attr("value","obreži sliko");

        var crop_data = $image.cropper("getData");
        $("#crop-x").val(crop_data.x1);
        $("#crop-y").val(crop_data.y1);
        $("#crop-x2").val(crop_data.x2);
        $("#crop-y2").val(crop_data.y2);
        $("#crop-w").val(crop_data.width);
        $("#crop-h").val(crop_data.height);

        $(this).parent().submit();
    }
});

$(".md-close").on("click",function() {
    $image = $("#modal-edit-image");
    $crop_button = $("#crop-image");
    $crop_button.removeClass("check-icon");
    $crop_button.addClass("crop-icon");
    $crop_button.val("obreži sliko");
    $crop_button.removeClass("crop");

    if($image.hasClass("cropping"))$image.cropper("disable");
});

// NEW IMAGE
$(".upload-image-button").on("click",function() {
    var image_id = $(this).siblings("input[name=id]").val();
    var name = $(this).siblings("input[name=name]").val();
    var description = $(this).siblings("input[name=description]").val();
    var header = ($(this).hasClass("header-image") ? "true" : "false");

    $("#upload-image-id").val(image_id);
    $(".current-image-header").val(header);
    $(".current-image-update_id").val(image_id);
    $(".current-image-name").val(name);
    $(".current-image-description").val(description);
});

$(".new-image").on("click",function() {
    if($(this).hasClass("header-image")) {
        var image_id = $(this).siblings("input[name=id]").val();

        if(image_id == "0") $(".gallery-image-update").val("false"); else $(".gallery-image-update").val("true");
        $("#upload-header-type").val("true");
        $(".gallery-image-header").val("true");
    }
    else {
        $(".gallery-image-update").val("false");
        $("#upload-header-type").val("false");
        $(".gallery-image-header").val("false");
    }
});

$("#new-image-form").on("submit",function() {
    loader.load();
});

$(".info").on("click",function(e) {
    e.preventDefault();
});

// DELETE
$(".delete-image").on("submit",function() {
    var image_id = $(this).children(".current-image-id").val();

    $("#image-"+image_id).parent().remove();

});

$(".delete-attachment-button").on("click",function() {
    var content_id = $(this).siblings("input[name=id]").val();
    var asoc_id = $(this).siblings("input[name=asoc_id]").val();

    $.ajax({
        url: base_url+"content/DeleteAttachment",
        type: "post",
        data: { "attachment[content_id]": content_id, "attachment[asoc_id]": asoc_id}
    });

    $(this).parent().parent().parent().fadeOut("fast",function() { $(this).remove(); });
});

// IMAGE POSITION
$(".area").on("click",function() {
    var image_id = $(this).children("input[name=id]").val();
    var asoc_id = $(this).children("input[name=asoc_id]").val();
    var position = ($(this).hasClass("bottom") ? "bottom" : "right");
    var all_areas = $(this).parent().parent().children().children(".area");

    $.ajax({
        url: base_url+"content/ImagePosition",
        type: "post",
        data: { "position[asoc_id]": asoc_id ,"position[image_id]": image_id, "position[position]":position }
    });

    $.each($(all_areas),function(key, value) {
        $(value).removeClass("selected");
    });

    classie.addClass(this,"selected");
});

// GALLERY
$(".select-gallery-image").on("click",function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();

    $(this).children("form").submit();
});

// EDIT IMAGE
$(".transform-image-form").on("submit",function(e) {
    e.preventDefault();
    var image_id = $(this).children(".current-image-id").val();
    var url = $(this).children("input[name=url]").val();
    var image = $("#image-"+image_id);

    loader.load();

    $.ajax({
        dataType: "json",
        url: $(this).attr("action"),
        type: $(this).attr("method"),
        data: $(this).serialize(),
        success: function(data) {
            image.attr("src",base_url+data.medium+"?img="+Math.floor((Math.random() * 1000) + 1));
            image.parent().attr("href",base_url+data.extra_large+"?img="+Math.floor((Math.random() * 1000) + 1));
            loader.unload();
        }
    });
});

// SEARCH GALLERY IMAGES
$(".images-search-input").on("keyup keydown",function() {
    var images = $(".gallery-image");
    var clear_button = $(".images-search-input-clear");

    var text = $(this).val();
    clear_button.fadeIn("slow");

    images.hide();

    $.each(images,function(key,value) {
        var name = $(value).children(".gallery-image-name").text().toLowerCase();
        var tags = $(value).children(".gallery-image-tags").children();
        var description = $(value).children(".gallery-image-description").text().toLowerCase();

        if(name.match(text.toLowerCase()) || description.match(text.toLowerCase()))
            $(value).show();

        $.each(tags,function(key,tag) {
            tag = $(tag).text().toLowerCase();
            if(tag.match(text.toLowerCase()))
                $(value).show();
        });
    });
});

$(".images-search-input-clear").on("click",function() {
    var images = $(".gallery-image");
    $(".images-search-input").val("");
    images.fadeIn("fast");
    $(".images-search-input-clear").fadeOut("fast");
});

// EDIT CONTENT
$(".edit-content-button").on("click",function() {
    var name = $(this).siblings("input[name=name]").val();
    var id = $(this).siblings("input[name=id]").val();
    var description = $(this).siblings("input[name=description]").val();
    var type = $(this).siblings("input[name=type]").val();
    var url = $(this).siblings("input[name=url]").val();
    var tags = $(this).siblings("input[name=tags]").val();
    var header = ($(this).siblings("input[name=header]").val() == "1" ? "true" : "false");

    $(".current-content-name").val(name);
    $(".current-content-header").val(header);
    $(".current-content-tags").text(tags);
    $(".current-content-id").val(id);
    $(".current-content-type").val(type);
    $(".current-content-description").text(description);
    $(".current-content-url").val(url);
});

// EDIT EVENT
$(".edit-event-button").on("click",function() {
    var name = $(this).siblings("input[name=name]").val();
    var id = $(this).siblings("input[name=id]").val();
    var ref_id = $(this).siblings("input[name=ref_id]").val();
    var description = $(this).siblings("input[name=description]").val();
    var type = $(this).siblings("input[name=type]").val();
    var date_start = $(this).siblings("input[name=start_date]").val();
    var date_end = ($(this).siblings("input[name=end_date]").val().substr(0,10) == "0000-00-00" ? "" : $(this).siblings("input[name=end_date]").val());

    $(".datepicker_down_event").val(date_end.substr(0,10));
    $(".datepicker_up_event").val(date_start.substr(0,10));
    $(".current-event-name").val(name);
    $(".current-event-id").val(id);
    $(".current-event-ref-id").val(ref_id);
    $(".current-event-type").val(type);
    $(".current-event-description").text(description);
});

// ADD MENU TAG
$(".add-tag").on("change",function(e) {
    var tag = $(this).val();
    var tags = $("#article_tags");
    var current = tags.text().split(',');
    var new_tags = "";

    classie.toggle(this,"checked");

    if($(this).hasClass("checked")) {
        var not_here = true;
        var media = $(this).parents(".media:first");
        var domain = media.children("li:first").children(".domain:first");

        if(!domain.is(":checked")) domain.prop("checked",true);

        $.each(current,function(key,value) {
            if($.trim(value) == tag) not_here = false;

            new_tags = (new_tags != "" ?  new_tags + "," + value : value ) ;
        });

        if(not_here) new_tags = new_tags + ", " + tag;
    }
    else {
        $.each(current,function(key,value) {
            if($.trim(value) != tag) new_tags = (new_tags != "" ?  new_tags + "," + value : value ) ;
        });
    }

    tags.text(new_tags);
});

$(".domain").on("change",function(e) {
    if($(this).hasClass("checked")) {
        $(this).parent().siblings().fadeIn("fast");
    }
    else {
        $(this).parent().siblings().fadeOut("fast");
    }
});

// EDIT EVENT
$(".edit-location-button").on("click",function() {
    var id = $(this).siblings("input[name=id]").val();
    var ref_id = $(this).siblings("input[name=ref_id]").val();
    var country = $(this).siblings("input[name=country]").val();
    var city = $(this).siblings("input[name=city]").val();
    var house_number = $(this).siblings("input[name=house_number]").val();
    var region = $(this).siblings("input[name=region]").val();
    var street_village = $(this).siblings("input[name=street_village]").val();

    $(".current-location-id").val(id);
    $(".current-location-ref_id").val(ref_id);
    $(".current-location-country").val(country);
    $(".current-location-city").val(city);
    $(".current-location-house_number").val(house_number);
    $(".current-location-region").val(region);
    $(".current-location-street_village").val(street_village);
});

// DELETE BUG
$(".delete-bug-button").on("click",function() {
    var id = $(this).siblings("input[name=id]").val();
    var attachment = $("#bug-"+id);

    $.ajax({
        url: base_url+"content/RemoveBug",
        type: "POST",
        data: { id: id},
        success: function() { attachment.remove(); }
    }).fail(function(data) { console.log(data); });
});

