
<style type="text/css" scoped>
	#GalleryContainer { width:100%; -webkit-transition:opacity 0.5s; -moz-transition:opacity 0.5s; transition:opacity 0.5s; opacity:0.5; }
	#GalleryContainer:hover { -webkit-transition:opacity 0.5s; -moz-transition:opacity 0.5s; transition:opacity 0.5s; opacity:1; }
</style>

<?php echo form_open_multipart("content/Create",array("id" => "articleForm", "name" => "article")); ?>
	<input type="hidden" value='<?php echo $article->id; ?>' name='article[id]'>
    <input type="hidden" value='<?php echo $article->ref_id; ?>' name='article[ref_id]'>
</form>

<section style='padding:20px; color:#222;'>
	<p>v bazi se je dodala vrstica v 'vs_content' z osnovnimi informacijami in pravim referenčnim idjem od novo ustvarjene vrstice v tabeli 'vs_articles' (trenutno v namen testiranja ustvarjamo novi prispevek - kasneje bomo prej izbrali kakšno vrsto vsebine želimo dodati).</p>
		<?php var_dump($article); ?>
</section>

    <script type="text/javascript">
		$("#SaveButton").on("click",function(e) {
			console.log($("#contentTags").val());
			
			if(CheckForEmpty("contentTags") || CheckForEmpty("contentText")) {
				e.preventDefault();
				alert("Prosim vpišite vsaj eno ključno besedo.");
			}
		});
		
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
	</script>
