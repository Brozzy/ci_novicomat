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

    $(".datepicker_up").on("change",function() {
        $( ".datepicker_down" ).datepicker( "destroy" );

        if($(".datepicker_down").val() < $(".datepicker_up").val())
            $(".datepicker_down").val('');

        $(".datepicker_down").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: $(this).val()
        });
    });

    $(".datepicker_up").datepicker({
        dateFormat: "yy-mm-dd"
    });

    $(".datepicker_down").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: $(".datepicker_up").val()
    });
});

// CROPPING
$(".edit-image-button").on("click",function() {
    $image = $("#modal-edit-image");

    var current_image_id = $(this).parent().siblings("img").attr("id").substr(6);
    var current_image_url = base_url+$(this).siblings("input[name=image_url]").val();

    $image.attr("src",current_image_url);
    $(".current-image-id").val(current_image_id);
});

$("#crop-image").on("click",function() {
    classie.toggle(this,"crop");
    $image = $("#modal-edit-image");

    if($(this).hasClass("crop")) {
        classie.removeClass(this,"crop-icon");
        classie.addClass(this,"check-icon");
        $(this).attr("value","končaj z obrezovanjem");
        $image.addClass("cropping");

        $image.cropper("enable");
        $image.cropper("setAspectRatio", 1.2);
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
    var image_ref_id = $(this).siblings("input[name=image_ref_id]").val();
    var image_id = $(this).siblings("input[name=image_id]").val();
    var name = $(this).siblings("h2").text();
    var description = $(this).siblings("p").text();

    $("#upload-image-ref-id").val(image_ref_id);
    $("#upload-image-id").val(image_id);
    $("#upload-image-name").val(name);
    $("#upload-image-description").val(description);

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

$("#new-image-form").on("submit",function() {
    $("#upload-image-button").val("Nalaganje..");
});

// GALLERY
$(".select-gallery-image").on("click",function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();

    console.log(JSON.stringify($(".select-gallery-image-form").serialize()));
    $(this).children("form").submit();
});