// GLOBAL VAR
var jcrop_api;
var crop_size;

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
$("#crop-image").on("click",function() {
    classie.toggle(this,"crop");

    if($(this).hasClass("crop")) {
        classie.toggle(this,"crop-icon");
        classie.toggle(this,"check-icon");
        $(this).attr("value","končaj z obrezovanjem");
        $("#modal-edit-image").Jcrop({
            onSelect: SendCoords,
            onChange: ShowCoords,
            aspectRatio: 300 / 250,
            minSize: [100,100],
            trueSize: [500,370]
        },function() {
            jcrop_api = this;
        });
    } else {
        classie.toggle(this,"check-icon");
        classie.toggle(this,"loading-icon");
        $(this).attr("value","obrezujem..");
        var crop = $(this).parent().serialize();

        $.ajax({
            url: $(this).parent().attr("action"),
            type: $(this).parent().attr("method"),
            data: crop,
            success: function(data) {
                $("#crop-image").removeClass("loading-icon");
                $("#crop-image").addClass("crop-icon");
                $("#crop-image").attr("value","obreži sliko");
            }
        }).fail(function(data) { console.log("FAIL!"+data); });

        jcrop_api.destroy();
    }
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