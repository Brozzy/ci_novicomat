/* GLOBAL VAR */
var jcrop_api;
var crop_size;

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
});

$("#crop-image").on("click",function() {
    classie.toggle(this,"crop");

    if($(this).hasClass("crop")) {
        classie.toggle(this,"crop-icon");
        classie.toggle(this,"check-icon");
        $(this).attr("value","končaj z obrezovanjem");
        $("#modal-edit-image").Jcrop({
            onSelect: SendCoords,
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
                console.log(data);
                $("#crop-image").removeClass("loading-icon");
                $("#crop-image").addClass("crop-icon");
                $("#crop-image").attr("value","obreži sliko");
            }
        }).fail(function(data) { console.log("FAIL!"+data); });

        jcrop_api.destroy();
    }
});

function SendCoords(c) {
    $("#crop-x").val(c.x);
    $("#crop-y").val(c.y);
    $("#crop-w").val(c.w);
    $("#crop-h").val(c.h);
    $("#crop-x2").val(c.x2);
    $("#crop-y2").val(c.y2);
}

$(".new-image").on("click",function() {
    if($(this).hasClass("header-image"))
        $("#upload-header-type").val("true");
    else $("#upload-header-type").val("false");
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
    $("#upload-header-type").val("false");
});

$(".mask .info").on("click",function(e) {
    e.preventDefault();
});