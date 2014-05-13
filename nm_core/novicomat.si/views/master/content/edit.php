
<style type="text/css" scoped>
	#GalleryContainer { width:100%; -webkit-transition:opacity 0.5s; -moz-transition:opacity 0.5s; transition:opacity 0.5s; opacity:0.5; }
	#GalleryContainer:hover { -webkit-transition:opacity 0.5s; -moz-transition:opacity 0.5s; transition:opacity 0.5s; opacity:1; }
	.appended { vertical-align:top; }
</style>

<section style='padding:20px; color:#222;'>

	<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='contentForm' enctype="multipart/form-data">
		<label for='name'>Naslov</label><br/>
		<input type='text' name='content[name]' id='name' value='<?php echo $article->name; ?>' /><br/>
		
		<label for='description'><?php if($article->type == "article") echo "Uvodno besedilo"; else echo "Opis"; ?></label><br/>
		<textarea name='content[description]' id='description'><?php echo $article->description; ?></textarea><br/>
		
		<input type="hidden" value='<?php echo $article->id; ?>' name='content[id]'>
	    <input type="hidden" value='<?php echo $article->ref_id; ?>' name='content[ref_id]'>
		<input type="hidden" value='<?php echo $article->type; ?>' name='content[type]'>
		
		<label for='text'>Besedilo</label><br/>
		<textarea name='content[text]' id='text'><?php echo $article->text; ?></textarea><br/>

		<label for='author_name'>Ime avtorja</label><br/>
		<input type='text' name='content[author_name]' id='author_name' value='<?php echo $article->author_name; ?>' /><br/>
		
		<label for='publish_up'>Objava od</label><br/>
		<input type='text' name='content[publish_up]' id='publish_up' value='<?php echo $article->publish_up; ?>' /><br/>
		
		<label for='publish_down'>do</label><br/>
		<input type='text' name='content[publish_down]' id='publish_down' value='<?php echo $article->publish_down; ?>' /><br/>
	
		<label for='header_image'>Naslovna slika</label><br/>
		<img src='<?php echo base_url().$article->image->medium; ?>' alt='article header image' id='header_image' />
		<br/>
		
		<input type='file' name='content[image]' id='header_image' value='' accept='image/*' /><br/>
		<input type='hidden' name='content[image]' value='<?php echo $article->image->url; ?>' id='header_image_url'/>
        <input type='button' class='crop_image' value='Obreži sliko'><br>
		
		<input type='checkbox' name='content[frontpage]' style='margin:0px 10px 0px 0px; padding:0px; min-width:auto;' <?php if($article->frontpage == 1) echo "checked"; ?> value='1' id='frontpage'/>
		<label for='frontpage'>Naslovna stran</label><br/>
		
		<label for='article_tags'>Ključne besede</label><br/>
		<input type='text' value='<?php echo $article->tags; ?>' name='content[tags]' id='article_tags'/><br/>
	
		<button id='add_event'>Dodaj dogodek</button>
		<button id='add_multimedia'>Dodaj multimedijo</button>
		<button id='add_location'>Dodaj lokacijo</button>

		<ul>
			<?php foreach($article->attachments as $attachment)  { 
				if(isset($attachment->type) && $attachment->type == "image") 
					echo "<li><h3>Image</h3><h4>".$attachment->name."</h4><p>".$attachment->description."</p><img src='".base_url().$attachment->thumbnail."' alt='image attachment thumbnail'><button class='remove_attachment' id='".$attachment->id."'>remove</button></li>"; 
				else if(isset($attachment->type) && $attachment->type == "event")
					echo "<li><h3>Event</h3><h4>".$attachment->name."</h4><p>".$attachment->description."</p><p>Začetek: ".$attachment->start_date."</p><p>Konec: ".$attachment->end_date."</p><img src='".base_url().$attachment->image->thumbnail."' alt='image attachment thumbnail'><button class='remove_attachment' id='".$attachment->id."'>remove</button></li>"; 
				else if(isset($attachment->type) && $attachment->type == "location")
					echo "<li><h3>Location</h3><h4>".$attachment->country."</h4><p>Mesto: ".$attachment->post_number." ".$attachment->city."</p><p>Ulica ali vas: ".$attachment->street_village."</p><p>Hišna številka: ".$attachment->house_number."</p><button class='remove_attachment' id='".$attachment->id."'>remove</button></li>"; 
			} ?>
		</ul>

		<br/>
		
		<input type='submit' value='Shrani' formaction='<?php echo base_url()."content/Update"; ?>'/>
		
		<?php if($user->level > 3) { ?>
		<input type='submit' value='Objavi' formaction='<?php echo base_url()."content/Publish"; ?>'/>
		<?php } else { ?>
		<input type='submit' value='Pošlji v pregled' formaction='<?php echo base_url()."content/Editing"; ?>'/>		
		<?php } ?>
	</form>
	
	<section style='display:inline-block; vertical-align:top;' id='event_list'>
		<?php if(isset($article->event)) { foreach($article->event as $event) { ?>
			<div class='appended event' style='display:inline-block; margin-right:15px;'>
				<form action='<?php echo base_url()."event/Create"; ?>' method='POST' id='eventForm'>
					<label>Ime dogodka</label><br>
					<input type='text' name='event[name]'><br/>
					<label>Začetek</label><br>
					<input type='text' name='event[start]'><br>
					<label>Konec</label><br>
					<input type='text' name='event[end]'><br>
					<label>Lokacija</label><br>
					<input type='text' name='event[location]'><br>
					<input type='submit' style='min-width:auto; margin-right:15px;' value='Shrani'>
					<input type='button' style='min-width:auto;' class='remove_event' value='Odstrani'>
				</form>
			</div>
		<?php } } ?>
	</section>
	
	<section style='display:inline-block; vertical-align:top;' id='multimedia_list'>
	</section>
	
	<section style='display:inline-block; vertical-align:top;' id='locations_list'>
	</section>
</section>

    <script type="text/javascript">
		
		$(document).on("click",".crop_image",function() {
			var Image = $("#header_image");
			$(Image).Jcrop({ onSelect: showCoords });
		});
		
		function showCoords(c) {
			var Image = $("#header_image");
			var Url = $("#header_image_url").val();
			
			var Form = 
				"<form action='<?php echo base_url().'article/CropHeaderImage'; ?>' method='post' id='image_crop_form'>"+
					"<input type='hidden' name='crop[x]' value='"+c.x+"' id='image_crop_x'>"+
					"<input type='hidden' name='crop[y]' value='"+c.y+"' id='image_crop_y'>"+
					"<input type='hidden' name='crop[w]' value='"+c.w+"' id='image_crop_w'>"+
					"<input type='hidden' name='crop[h]' value='"+c.h+"' id='image_crop_h'>"+
					"<input type='hidden' name='crop[url]' value='"+Url+"' id='image_crop_url'>"+
					"<input type='submit' value='done cropping'>"+
				"</form>";

			$(Image).before(Form);
		};
		
		$("#SaveButton").on("click",function(e) {
			console.log($("#contentTags").val());
			
			if(CheckForEmpty("contentTags") || CheckForEmpty("contentText")) {
				e.preventDefault();
				alert("Prosim vpišite vsaj eno ključno besedo.");
			}
		});
		
		$(document).on("click",".remove_appended",function() {
			$(this).parents("div:first").remove();
		});
		
		$(document).on("click",".remove_attachment",function(e) {
			e.preventDefault();
			var attacthment_id = $(this).attr("id");
			$(this).parent().remove();
			
			/* TODO */
			
		});
		
		$("#add_event").on("click",function(e) {
			e.preventDefault();
			
			var Event = 
				"<div class='appended event' style='display:inline-block; margin-right:15px;'>"+
				"<h3>Nov dogodek</h3>"+
				"<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='eventForm' enctype='multipart/form-data'>"+
					"<label>Ime dogodka</label><br>"+
					"<input type='text' required name='content[name]'><br>"+
					"<label>Opis</label><br>"+
					"<input type='text' required name='content[description]'><br>"+
					"<label>Začetek</label><br>"+
					"<input type='text' required name='content[start_date]'><br>"+
					"<label>Konec</label><br>"+
					"<input type='text' required name='content[end_date]'><br>"+
					"<label>Slika</label><br>"+
					"<input type='file' name='content[image]' value='' accept='image/*' /><br/>"+
					"<input type='submit' style='min-width:auto; margin-right:15px;' value='Shrani'>"+
					"<input type='button' style='min-width:auto;' class='remove_appended' value='Odstrani'>"+
					"<input type='hidden' name='content[asoc_id]' value='<?php echo $article->id; ?>'>"+
					"<input type='hidden' name='content[type]' value='event'>"+
				"</form>"+
				"</div>";
				
			$("#event_list").prepend(Event);
		});
		
		$("#add_multimedia").on("click",function(e) {
			e.preventDefault();
			
			var Multimedia = 
				"<div class='appended multimedia' style='display:inline-block; margin-right:15px;'>"+
				"<h3>Nova multimedija</h3>"+
				"<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='multimediaForm' enctype='multipart/form-data'>"+
					"<label>Naslov</label><br>"+
					"<input required type='text' name='content[name]'><br>"+
					"<label>Kratek opis</label><br>"+
					"<input required type='text' name='content[description]'><br>"+
					"<label>Slika</label><br>"+
					"<input required type='file' name='content[image]' accept='image/*,video/*'><br>"+
					"<input type='submit' style='min-width:auto; margin-right:15px;' value='Shrani'>"+
					"<input type='button' style='min-width:auto;' class='remove_appended' value='Odstrani'>"+
					"<input type='hidden' name='content[asoc_id]' value='<?php echo $article->id; ?>'>"+
					"<input type='hidden' name='content[type]' value='image'>"+
				"</form>"+
				"</div>";
				
			$("#multimedia_list").prepend(Multimedia);
		});
		
		$("#add_location").on("click",function(e) {
			e.preventDefault();
			
			var Location = 
				"<div class='appended locations' style='display:inline-block; margin-right:15px;'>"+
				"<h3>Nova lokacija</h3>"+
				"<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='locationsForm'>"+
					"<label>Mesto</label><br>"+
					"<input required type='text' name='content[city]'><br>"+
					"<label>Poštna številka</label><br>"+
					"<input required type='text' name='content[post_number]'><br>"+
					"<label>Ulica</label><br>"+
					"<input required type='text' name='content[street_village]'><br>"+
					"<label>Hišna številka</label><br>"+
					"<input type='text' name='content[house_number]'><br>"+
					"<label>Država</label><br>"+
					"<input required type='text' name='content[country]' value='Slovenija'><br>"+
					"<input type='submit' style='min-width:auto; margin-right:15px;' value='Shrani'>"+
					"<input type='button' style='min-width:auto;' class='remove_appended' value='Odstrani'>"+
					"<input type='hidden' name='content[asoc_id]' value='<?php echo $article->id; ?>'>"+
					"<input type='hidden' name='content[type]' value='location'>"+
				"</form>"+
				"</div>";
				
			$("#locations_list").prepend(Location);
		});
		/*
		function CheckForEmpty(Element) {
			if($("#"+Element).val() == "" || $("#"+Element).val() == " " || 	typeof $("#"+Element).val() == "undefined")
				return true;
			else return false;
		}
	
	
		$("#articleNaslovnaSlikaURL").on("change",function() {
			var ImageUrl = $(this).val();
			$("#articleNaslovnaSlika").removeAttr("required");
			ChangePicture(ImageUrl);
		});
		
		function ChangePicture(ImageUrl) {
			$("#IzbiraNaslovneSlike").val(ImageUrl);
			$("#IkonaNaslovnaSlika").attr("href",ImageUrl);
			$("#IkonaNaslovnaSlika img").attr("src",ImageUrl);
		}
	
		$(document).ready(function() {
			var Width = $("#WidthMessurement").width();
			$(".GetWidth").css("width",Width+"px");
			
			if($("#IzbiraNaslovneSlike").val() != "" && typeof $("#IzbiraNaslovneSlike").val() != "undefined") {
				$("#articleNaslovnaSlika").removeAttr("required");
			}
		});
		
		window.onresize = function() {
			var Width = $("#WidthMessurement").width();
			$(".GetWidth").css("width",Width+"px");
		}
	
		$(".gallery-image").on("click",function() {
			var ImageUrl = $(this).attr("src");
			$("#articleNaslovnaSlika").removeAttr("required");
			$(".gallery-image").removeClass("SelectedImage");
			ChangePicture(ImageUrl);
			$(this).addClass("SelectedImage");
		});
	
		$("#contentTags").tagsInput({
			'autocomplete_url': '<?php echo base_url()."content/AutocompleteTags"; ?>',
			'minChars':'3',
			'maxChars':'50',
			'onRemoveTag': function(tag) { RemoveTag(tag); },
			'defaultText': 'Dodajte novo ključno besedo',
			'placeholderColor': '#333',
			'width': '550px',
			'height': '70px'
		});
		
		jQuery("#contentTags").importTags(' <?php foreach($article->tags as $Tag) echo $Tag->tag.","; ?> ');

		jQuery('.TextEditor').jqte({
			unlink: false
		});
		
		function RemoveTag(tag,articleId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url()."content/RemoveTagFromarticle"; ?>",
				data: { articleId: <?php echo $article->id; ?>, Tag: tag }
			}).fail(function(data) { console.log("Fail: "+JSON.stringify(data)); });
		}
		
		$(function() {
			$(".DatePicker").datepicker({ 
				dateFormat: "yy-mm-dd", 
				minDate: new Date(<?php echo date("Y"); ?>, <?php echo date("m"); ?> - 1, <?php echo date("d"); ?>) 
			});
		});
		
		function articleController($scope) {
			this.Tags = "zelnik.net";
			this.Title = "<?php echo $article->title; ?>";
			$scope.TotalTodos = this.Tags;
		}
		
		setInterval("Update()",3000);
		function Update() {
			var FormData = $("#CreatearticleForm").serialize();

			$.ajax({
				type: "POST",
				url: "<?php echo base_url()."content/Update"; ?>",
				data: FormData
			}).fail(function(data) { console.log("Fail: "+JSON.stringify(data)); });
		}
		
		function Save() {
			Update();
			SaveSuccessor();
		}
		
		function SaveSuccessor() {
			document.location.href = "<?php echo base_url()."article/".$article->id."/".$article->title_url; ?>";
		}
		
		function ChangeSection(Class, Section) {
			$(".article_"+Class).css("display","none");
			$("."+Class).removeClass("selected");
			$("#"+Section).css("display","table-cell");
		}
		
		$('.fancybox').fancybox({
			closeBtn: false,
			helpers: {
				buttons: {}
			}
		});
		*/
	</script>
