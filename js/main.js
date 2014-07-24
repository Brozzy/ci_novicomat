var url = document.getElementById('base_url');
var base_url = (jQuery(url).length == 0 ? '' : url.getAttribute('value'));

var asoc = document.getElementById('asoc_id')
var asoc_id = (jQuery(asoc).length == 0 ? 0 : asoc.getAttribute('value'));

function __constructPlugins() {
    this.init = function() {
        // FANCY BOX
        jQuery('.fancybox').fancybox();

        // SCROLLBAR
        jQuery('.scrollbar').perfectScrollbar({
            wheelSpeed: 10,
            suppressScrollX: true,
            includePadding: true
        });

        // DATEPICKER
        var datepicker_up = jQuery(".datepicker_up");
        var datepicker_down = jQuery(".datepicker_down");
        var datepicker_up_event = jQuery(".datepicker_up_event");
        var datepicker_down_event = jQuery(".datepicker_down_event");

        datepicker_up_event.datepicker({
            dateFormat: "yy-mm-dd"
        });

        datepicker_down_event.datepicker({
            dateFormat: "yy-mm-dd",
            minDate: datepicker_up_event.val()
        });

        datepicker_up_event.on("change",function() {
            datepicker_down_event.datepicker( "destroy" );

            if(datepicker_down_event.val() < jQuery(".datepicker_up_event").val())
                jQuery(".datepicker_down_event").val('');

            datepicker_down_event.datepicker({
                dateFormat: "yy-mm-dd",
                minDate: jQuery(this).val()
            });
        });

        datepicker_up.datepicker({
            dateFormat: "yy-mm-dd"
        });

        datepicker_down.datepicker({
            dateFormat: "yy-mm-dd",
            minDate: datepicker_up.val()
        });

        datepicker_up.on("change",function() {
            datepicker_down.datepicker( "destroy" );

            if(datepicker_down.val() < jQuery(".datepicker_up").val())
                jQuery(".datepicker_down").val('');

            datepicker_down.datepicker({
                dateFormat: "yy-mm-dd",
                minDate: jQuery(this).val()
            });
        });

        // AUTOCOMPLETE
        jQuery(".tags").autocomplete({
            source: base_url+"content/GetTags",
            minLength: 2,
            focus: function() {
                return false;
            },
            select: function( event, ui ) {
                var value = jQuery(this).val();
                var clean = value.split(' ');
                clean = clean.join('');
                var terms = clean.split(",");

                terms.pop();
                terms.push( ui.item.value );

                this.value = terms.join( ", " );
                return false;
            }
        });

        jQuery(".username-autocomplete").autocomplete({
            source: base_url+"content/GetUsers",
            minLength: 1,
            focus: function() {
                return false;
            },
            select: function( event, ui ) {
                this.value = ui.item.value;
                return false;
            }
        });

        jQuery(".email-autocomplete").autocomplete({
            source: base_url+"content/GetUsers/email",
            minLength: 1,
            focus: function() {
                return false;
            },
            select: function( event, ui ) {
                this.value = ui.item.value;
                return false;
            }
        });

        // IMAGE POSITION
        jQuery(".area").on("click",function() {
            var image_id = jQuery(this).children("input[name=id]").val();
            var position = (jQuery(this).hasClass("bottom") ? "bottom" : "right");
            var all_areas = jQuery(this).parent().parent().children().children(".area");

            jQuery.ajax({
                url: base_url+"content/ImagePosition",
                type: "post",
                data: { "position[asoc_id]": asoc_id ,"position[image_id]": image_id, "position[position]":position }
            });

            jQuery.each(jQuery(all_areas),function(key, value) {
                jQuery(value).removeClass("selected");
            });

            classie.addClass(this,"selected");
        });

        // GALLERY
        if(jQuery("#gallery-images-list").length != 0) {
            var hidden = jQuery('#gallery-hidden-inputs').children('input[type=hidden]');
            var header = 'false';

            jQuery.each(hidden,function(key,value) { if(jQuery(value).attr('name') == 'content[header]') {  header = jQuery(value).attr('value'); } });

            jQuery.ajax({
                dataType: 'json',
                url: base_url+'content/GetGalleryImages',
                type:'POST',
                success: function(data) {
                    var items = "";

                    jQuery.each(data,function(key, value) {
                        items +=
                            '<li class="select-gallery-image gallery-image">'+
                                '<img src="'+base_url+value.medium+'" />'+
                                '<div class="gallery-image-name" style="word-break: break-all; ">'+value.name+'</div>'+
                                '<p class="gallery-image-description" style="opacity: 0.8; font-size: 0.9em;">'+value.description+'</p>'+
                                '<ul class="icon tags-icon tags">';
                                    jQuery.each(value.tags,function(index,tag) { items += '<li>'+tag+'</li>'; });
                        items +='</ul>'+
                                '<form action="'+base_url+'content/SetGalleryImage" method="post">'+
                                '<input type="hidden" name="gallery[asoc_id]" value="'+asoc_id+'">'+
                                '<input type="hidden" name="gallery[header]" value="'+header+'">'+
                                '<input type="hidden" name="gallery[type]" value="image">'+
                                '<input type="hidden" name="gallery[id]" value="'+value.id+'">'+
                                '</form>'+
                                '</li>';
                    });

                    jQuery('#gallery-images-list').html(items);
                    var plugins = new __constructPlugins();
                    plugins.gallery();
                }
            });
        }

        // SEARCH GALLERY IMAGES
        jQuery(".images-search-input").on("keyup keydown",function() {
            var images = jQuery(".gallery-image");
            var clear_button = jQuery(".images-search-input-clear");

            var text = jQuery(this).val();
            clear_button.fadeIn("slow");

            images.hide();

            jQuery.each(images,function(key,value) {
                var name = jQuery(value).children(".gallery-image-name").text().toLowerCase();
                var tags = jQuery(value).children(".tags").children();
                var description = jQuery(value).children(".gallery-image-description").text().toLowerCase();

                if(name.match(text.toLowerCase()) || description.match(text.toLowerCase()))
                    jQuery(value).show();

                jQuery.each(tags,function(key,tag) {
                    tag = jQuery(tag).text().toLowerCase();
                    if(tag.match(text.toLowerCase()))
                        jQuery(value).show();
                });
            });
        });
    };
    this.gallery = function() {
        jQuery(".select-gallery-image").on("click",function() {
            jQuery(this).children("form").submit();
        });
    };
    this.autosave = function() {
        var form = document.getElementById('contentForm');

        jQuery.ajax({
            url: jQuery(form).attr("action"),
            type: jQuery(form).attr("method"),
            data: jQuery(form).serialize()
        });
    }
}

function __constructLoader(container) {
    this.container = (typeof container == 'undefined' ? document.body : container);
    this.wrapper = document.createElement("div");
    this.overlay = document.createElement("div");
    this.icon = base_url+'style/images/loading.gif';
    this.text = 'nalaganje, prosim počakajte';

    this.wrapper.appendChild(document.createTextNode(this.text));
    this.overlay.appendChild(this.wrapper);
    this.container.appendChild(this.overlay);

    this.load = function() {
        this.wrapper.setAttribute('class', "loader");
        this.wrapper.setAttribute('id', "loader");
        this.overlay.setAttribute('class', "overlay");
        this.overlay.setAttribute('id', "overlay");

        jQuery(this.overlay,this.wrapper).fadeIn("fast");
    };
    this.unload = function() {
        jQuery(this.overlay,this.wrapper).fadeOut("fast",function() { jQuery(this).remove(); });
    }
}

function __constructOverlay() {
    this.show = function() {
        var overlay = document.createElement('div');
        overlay.setAttribute('id','modal-overlay');
        classie.add(overlay,'overlay');

        document.body.appendChild(overlay);
        jQuery(overlay).fadeIn(200);
    };
    this.hide = function() {
        var overlay = document.getElementById('modal-overlay');
        jQuery(overlay).fadeOut(200,function() { jQuery(this).remove(); });
    }
}

function __constructModal(id, title) {
    this.id = (typeof id == 'undefined' ? "" : "modal-"+id);
    this.title =  (typeof title == 'undefined' ? "Pojavno okno" : title);

    this.wrapper = document.createElement("div");
    this.content = document.createElement("div");
    this.header = document.createElement('header');
    this.section = document.createElement('section');
    this.h3 = document.createElement("h3");

    // global variables (usable in class subfunctions)
    var overlay = new __constructOverlay();
    var wrapper = this.wrapper;
    var modal = this;

    this.Remove = function(modalId) {
        modal = (typeof modalId != 'undefined' ? document.getElementById(modalId) : modal);
        overlay.hide();
        classie.remove(modal,'md-show');
        setTimeout(function() { jQuery(modal).remove(); },300);
    };
    this.Show = function() {
        overlay.show();
        classie.add(this.wrapper, 'md-show' );
        jQuery(this.wrapper).fadeIn(200);
    };
    this.AddContent = function(content) { jQuery(this.section).html(content); }

    // hirearchy
    this.wrapper.appendChild(this.content);
        this.content.appendChild(this.header);
            this.header.appendChild(this.h3);
                this.h3.appendChild(document.createTextNode(this.title));
        this.content.appendChild(this.section);
    document.body.appendChild(this.wrapper);

    // attributes
    this.wrapper.setAttribute("id",this.id);

    // class and style
    classie.add(this.wrapper,"md-modal");
    classie.add(this.wrapper,"md-effect-16");
    classie.add(this.content,"md-content");
}

