// GLOBAL VAR
var base_url = $("#base_url").val();

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
            console.log(data);
        }
    });
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
        classie.removeClass(this,"crop-icon");
        classie.addClass(this,"check-icon");
        $(this).attr("value","končaj z obrezovanjem");
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

function ShowCoords(c) {
    console.log("width: "+ c.w+" height: "+ c.h);
}

function SendCoords(c) {
    $("#crop-x").val(c.x);
    $("#crop-y").val(c.y);
    $("#crop-w").val(c.w);
    $("#crop-h").val(c.h);
    $("#crop-x2").val(c.x2);
    $("#crop-y2").val(c.y2);
}

// NEW IMAGE
$(".upload-image-button").on("click",function() {
    var image_ref_id = ($(this).hasClass("header-image") ? $(this).siblings("input[name=image_ref_id]").val() : $(this).parent().siblings("input[name=image_ref_id]").val());
    var image_id = ($(this).hasClass("header-image") ? $(this).siblings("input[name=image_id]").val() : $(this).parent().siblings("input[name=image_id]").val());
    var name = ($(this).hasClass("header-image") ? $(this).siblings("h2").text() : $(this).parent().siblings("h2").text());
    var description = ($(this).hasClass("header-image") ? $(this).siblings("p").text() : $(this).parent().siblings("p").text());

    console.log("image_ref_id: "+image_ref_id);
    console.log("image_id: "+image_id);
    console.log("name: "+name);
    console.log("description: "+description);

    $("#upload-image-ref-id").val(image_ref_id);
    $("#upload-image-id").val(image_id);
    $(".current-image-name").val(name);
    $(".current-image-description").val(description);

    $(".gallery-image-update-id").val(image_id);
    $(".gallery-image-update-ref-id").val(image_ref_id);
});

$(".new-image").on("click",function() {
    if($(this).hasClass("header-image")) {
        var image_id = $(this).siblings("input[name=image_id]").val();

        $("#upload-header-type").val("true");
        $(".gallery-image-header").val("true");
        if(image_id > 0)
            $(".gallery-image-update").val("true");
        else $(".gallery-image-update").val("false");
    }
    else if($(this).hasClass("existing-image")) {
        $(".gallery-image-update").val("true");
        $("#upload-header-type").val("false");
        $(".gallery-image-header").val("false");
    }
    else {
        $(".gallery-image-update").val("false");
        $("#upload-header-type").val("false");
        $(".gallery-image-header").val("false");
    }
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
    var position = ($(this).hasClass("bottom") ? "bottom" : "right");
    var all_areas = $(this).parent().parent().children().children(".area");

    $.ajax({
        url: base_url+"content/ImagePosition",
        type: "post",
        data: { "position[image_id]": image_id, "position[position]":position }
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

    console.log(JSON.stringify($(".select-gallery-image-form").serialize()));
    $(this).children("form").submit();
});

// EDIT IMAGE
$(".transform-image-form").on("submit",function(e) {
    e.preventDefault();
    var image_id = $(this).children(".current-image-id").val();
    var url = $(this).children("input[name=url]").val();
    var display = $(this).children("input[name=display]").val();
    var image = $("#image-"+image_id);

    image.attr("src",base_url+"style/images/loader.gif");

    if(image.hasClass("article-header-image"))
        image.addClass("header-image-loading");
    else image.addClass("image-loading");

    $.ajax({
        url: $(this).attr("action"),
        type: $(this).attr("method"),
        data: $(this).serialize(),
        success: function(data) {
            image.attr("src",display+"?img="+Math.floor((Math.random() * 1000) + 1));
            image.removeClass("image-loading");
            image.parent().attr("href",display+"?img="+Math.floor((Math.random() * 1000) + 1));
        }
    });
});

// EDIT CONTENT
$(".edit-content-button").on("click",function() {
    var name = $(this).siblings("input[name=name]").val();
    var id = $(this).siblings("input[name=id]").val();
    var description = $(this).siblings("input[name=description]").val();
    var type = $(this).siblings("input[name=type]").val();
    var url = $(this).siblings("input[name=url]").val();

    $(".current-content-name").val(name);
    $(".current-content-id").val(id);
    $(".current-content-type").val(type);
    $(".current-content-description").text(description);
    $(".current-content-url").val(url);
});

$(".content-edit-form").on("submit",function() {

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
