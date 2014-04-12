
<style type="text/css" scoped>

	#PrispevekForm .EditButtons {
		list-style:none; padding-left:10px;
	}

	#PrispevekForm .EditButton {
		padding:5px; background-color:#174371; margin-bottom:5px; cursor:pointer;
	}
	
	#PrispevekForm .EditButton:hover { background-color:#c8e3ff; color:#333; }
	#PrispevekForm .selected { background-color:#c8e3ff; color:#333; }
	
	.LikeLink { display:inline-block; }
	.LikeLink:hover { color:#d7e9ff; cursor:pointer; }
	
	.InputButton { margin-left:20px; cursor:pointer; }
	.InputButton:hover { background-color:#3b72b5; color:white; }
	
	.gallery-image {
		padding-left:40px;
		height:150px; width:auto; 
		margin-right:20px; 
		border:2px solid white; 
		cursor:pointer;
		background-color:#174371;
	}
	
	.gallery-image:hover {
		background-color:#d7e9ff;
	}
	
	.SelectedImage {
		background-image:url(<?php echo base_url()."style/images/checked.png"; ?>);
		background-position:10px 10px;
		background-repeat:no-repeat;
		
		border:2px solid #9effa3;
	}
	
	#GalleryContainer { width:100%; -webkit-transition:opacity 0.5s; -moz-transition:opacity 0.5s; transition:opacity 0.5s; opacity:0.5; }
	#GalleryContainer:hover { -webkit-transition:opacity 0.5s; -moz-transition:opacity 0.5s; transition:opacity 0.5s; opacity:1; }
</style>

<?php echo form_open_multipart("vsebine/Create",array("id" => "CreatePrispevekForm", "name" => "Prispevek")); ?>
    	<input type="hidden" value='<?php echo $Prispevek->id; ?>' name='Prispevek[id]'>
        
<section id='PrispevekForm' >

	<!-- UREJANJE SECTION -->
    <section style="display:table; width:100%; margin:20px 0px 20px 0px; padding:10px 0px 10px 0px; background-color:#333;">

		<!-- UREJANJE MENU SECTION -->
    	<header style="display:table-cell; width:200px;">
        	<h2>Urejanje</h2>
            <ul class='EditButtons'>
            	<li class="EditButton urejanje selected" onClick="ChangeSection('urejanje', 'prispevek_title'); $(this).addClass('selected');">Naslov in besedilo</li>
            	<li class="EditButton urejanje" onClick="ChangeSection('urejanje', 'prispevek_introtext'); $(this).addClass('selected');">Uvodno besedilo</li>
            </ul>
        </header>
        
		<!-- UREJANJE TITLE & FULLTEXT SECTION -->
        <section class='prispevek_section prispevek_urejanje' id='prispevek_title' style="display:table-cell;">  
        	<header>
            	<h3>Naslov in besedilo</h3>
            </header>

            <label for="PrispevekTitle">Naslov <span class="required">*</span></label>
            <input id="PrispevekTitle" value='<?php echo $Prispevek->title; ?>' tabindex="1"  name="Prispevek[title]" required type="text">

			<label for="VsebineText">Besedilo <span class="required">*</span></label>	
            <textarea id="VsebineText" class='TextEditor' name="Prispevek[fulltext]" tabindex="2" required><?php echo $Prispevek->fulltext; ?></textarea>

        </section>
    
		<!-- UREJANJE INTROTEXT SECTION -->
    	<section class='prispevek_section prispevek_urejanje' id='prispevek_introtext'>
			<header>
            	<h3>Uvodno besedilo</h3>
            </header>
            
			<label for="PrispevekIntrotext">Uvodno besedilo <span class="required">*</span> </label>	
            <textarea rows="3" name="Prispevek[introtext]" style="min-width:40%;" id="PrispevekIntrotext"><?php echo $Prispevek->introtext; ?></textarea>

        </section>

	</section>
    
	<!-- PRIPONKE SECTION -->
    <section style="display:table; width:100%; margin:20px 0px 20px 0px; padding:10px 0px 10px 0px; background-color:#333; ">
    	
		<!-- PRIPONKE MENU SECTION -->
        <header style="display:table-cell; width:200px;">
        	<h2>Priponke</h2>
            <ul class='EditButtons'>
            	<li class="EditButton priponke selected" onClick="ChangeSection('priponke', 'prispevek_naslovka'); $(this).addClass('selected');">Naslovna slika</li>
                <li class="EditButton priponke" onClick="ChangeSection('priponke', 'prispevek_slike'); $(this).addClass('selected');">Slike</li>
                <li class="EditButton priponke" onClick="ChangeSection('priponke', 'prispevek_video'); $(this).addClass('selected');">Video</li>
                <li class="EditButton priponke" onClick="ChangeSection('priponke', 'prispevek_files'); $(this).addClass('selected');">Datoteke</li>
            </ul>
        </header>
        
		<!-- PRIPONKE NASLOVKA SECTION -->
    	<section class='prispevek_section prispevek_priponke' id='prispevek_naslovka' style="display:table-cell;">  
        	<header>
            	<h3>Naslovna slika</h3>
            </header>
            
            <section style='display:table; width:100%;'>
				<div style='display:table-cell;'>
					<label for="PrispevekNaslovnaSlika" style="display:inline;">Naloži naslovno sliko iz računalnika <small>- slika naj bo formata .jpg, .png ali .gif</small></label><br/>	
		            <input type="file" tabindex="3" size='25' accept="image/gif,image/jpeg,image/png" name='Prispevek[slika]' id='PrispevekNaslovnaSlika' required><br>
					<input type='hidden' name='Prispevek[slika]' value='<?php echo $Prispevek->slika; ?>' id='IzbiraNaslovneSlike'><br/>
					
					<label for='PrispevekNaslovnaSlikaURL'>Naloži naslovno sliko iz spletnega naslova</label>
					<input id='PrispevekNaslovnaSlikaURL' size='50' type='url' placeholder='Primer: http://www.images.com/slika.png'/>
				</div>
				
				<div style='display:table-cell;'>
					<label>Naslovna slika <span class='required'>*</span></label>
		            <a class='fancybox' href='<?php echo $Prispevek->slika; ?>' id="IkonaNaslovnaSlika"><img title="Naloži sliko" style="border:thin solid #444; height:200px; max-width:500px;" src="<?php echo $Prispevek->slika; ?>" alt="Ikona za nalaganje slike"></a><br>
				</div>
			</section>

			<br/>

			<div id='WidthMessurement' style='width:99%;'></div>
			<label for="PrispevekSlikaGalerije" style="display:inline;">Izberi sliko iz galerije</label><br/>
			<div id='GalleryContainer'>
				<div class='GetWidth' style='width:500px; height:180px; overflow-y:hidden; overflow-x:scroll; white-space:nowrap;'>
					<?php foreach($GalleryImage as $Image) { ?>
						<img src='<?php echo $Image->url; ?>' alt='<?php echo $Image->description; ?>' class='gallery-image'>
					<?php } ?>
				</div>
			</div>
			
        </section>
        
		<!-- PRIPONKE SLIKE SECTION -->
        <section class='prispevek_section prispevek_priponke' id='prispevek_slike'>  
        	<header>
            	<h3>Slike</h3>
            </header>
        
        	<label for="PrispevekPriponke" style="display:inline;">Priponka kot slika <small>- slika naj bo formata .jpg, .png ali .gif</small></label><br/>
            <input size="40" multiple type="file" name="Prispevek[slike]" id="PrispevekPriponke" 
                accept="application/x-zip-compressed,application/msexcel,application/msword,application/pdf,application/rtf"><br><br/>
            
            <label for="PrispevekSlika" style="display:inline;">Dodaj sliko iz interneta</label><br/>
            <input size="40" multiple type="text" name="Prispevek[slike]" id="PrispevekSlika" placeholder='primer: http://www.images.com/slika.png'><br>

        </section>
        
		<!-- PRIPONKE VIDEO SECTION -->
        <section class='prispevek_section prispevek_priponke' id='prispevek_video'>  
        	<header>
            	<h3>Video</h3>
            </header>
        
            <label for="PrispevekSlikaURL">Naloži sliko iz URL naslova</label>
            <input size="60" type="text" name="Prispevek[slika_url_priponka]" id="PrispevekSlikaURL"><br>
            
            <label for="VsebineVideo">Vstavi video iz <a href='http://www.youtube.com' target="_blank">Youtube.com</a></label>
            <input size="60" name="VsebineVideo" id="Prispevek[video_priponka]" type="text"><br>
            
            <label for="VsebineAvtorAlias">Ime avtorja ali psevdonim&nbsp;&nbsp; <small>(avtor izvirnika: <?php echo $User->name; ?>)</small></label>
            <input size="60" maxlength="256" name="Prispevek[author_alias]" id="VsebineAvtorAlias" value='<?php echo $Prispevek->author_alias; ?>' type="text"><br>	

        </section>
        
		<!-- PRIPONKE DATOTEKE SECTION -->
        <section class='prispevek_section prispevek_priponke' id='prispevek_files'>  
        	<header>
            	<h3>Datoteke</h3>
            </header>
        
        	<label for='PrispevekDatoteka'>Dodaj datoteko iz računalnika</label>
            <input size="40" multiple type="file" name="Prispevek[datoteka]" id="PrispevekDatoteka"><br>
            
            <p class='LikeLink'>dodaj še eno datoteko</p>
        
        </section>
        
    </section>
    
	<!-- OBJAVA SECTION -->
    <section style="display:table; width:100%; margin:20px 0px 50px 0px; padding:10px 0px 10px 0px; background-color:#333;">
    
		<!-- OBJAVA MENU SECTION -->
    	<header style="display:table-cell; width:200px;">
        	<h2>Objava</h2>
            <ul class='EditButtons'>
            	<li class="EditButton objava selected" onClick="ChangeSection('objava', 'prispevek_keywords'); $(this).addClass('selected');">Ključne besede</li>
                <li class="EditButton objava" onClick="ChangeSection('objava', 'prispevek_date'); $(this).addClass('selected');">Datum objave</li>
                <li class="EditButton objava" onClick="ChangeSection('objava', 'prispevek_portali'); $(this).addClass('selected');">Portali</li>
            </ul>
        </header>
		
		<!-- OBJAVA TAGS SECTION -->
        <section class='prispevek_section prispevek_objava' id='prispevek_keywords' style="display:table-cell;">  
        	<header>
            	<h3>Ključne besede</h3>
            </header>
            
            <label for="VsebineTags">Ključne besede <span class='required'>*</span> <small>- ločite jih z vejico, vsebujejo pa naj od 3 do 50 znakov.</small></label>
            <input id="VsebineTags" name="Prispevek[tags]" type="text" tabindex="4" value='' required >

        </section>
        
		<!-- OBJAVA DATE SECTION -->
        <section class='prispevek_section prispevek_objava' id='prispevek_date'>  
        	<header>
            	<h3>Datum objave</h3>
            </header>

			<label for="VsebinePublishUp">Začetek objave <span class="required">*</span> <small>(privzeto današnji datum). Format: <strong>llll-dd-mm</strong></small></label>				
            <input id="VsebinePublishUp" name="Prispevek[publish_up]" class='DatePicker' type='text' value="<?php echo $Prispevek->publish_up; ?>"><br><br>								
            
            <label for="Vsebine_publish_down">Konec objave <small>(v primeru, da je polje prazno se objava nikoli ne izbriše). Format: <strong>llll-dd-mm</strong></small></label>
            <input id="Vsebine_publish_down" name="Prispevek[publish_down]" value="<?php echo $Prispevek->publish_down; ?>" class='DatePicker' type="text" />

        </section>

		<!-- OBJAVA PORTALI SECTION -->
        <section class='prispevek_section prispevek_objava' id='prispevek_portali'>
        	<header>
            	<h3>Portali</h3>
            </header>
			
			<label>Objavi na naslednjih portalih:</label>
            
			<ul style='list-style:none; padding:0px;'>
            <?php foreach($Portali as $Portal) { ?>
            	<li class='Portal' id='Portal<?php echo $Portal->id; ?>'>
					<input type="checkbox" value="<?php echo $Portal->id; ?>" style="min-width:auto; padding-left:0px;" name="Prispevek[portali][]" id='<?php echo $Portal->domena; ?>'
                    	<?php foreach($Prispevek->portali as $CurrentPortal) { if($Portal->id == $CurrentPortal->id) echo "checked"; } ?> >
						
					<img src='http://g.etfv.co/http://www.<?php echo $Portal->domena; ?>' alt="Portal favicon" style="height:13px; width:auto;">
                	<label for='<?php echo $Portal->domena; ?>' style="display:inline-block;"><?php echo $Portal->domena; ?></label>
				</li>
            <?php } ?>
            </ul>
			<br/>
            <input name="Prispevek[frontpage]" style="min-width:auto; padding:0px; margin:0px 5px 0px 0px;" id="VsebineFrontpage" value='1' <?php if($Prispevek->frontpage == 1) echo "checked"; ?> type="checkbox">
            <label for="VsebineFrontpage" style="display:inline;">Prikaži prispevek na prvi strani</label>

        </section>
        
    </section>
	
	
	<!-- BUTTONS SECTION -->
    <section style="display:table; width:100%;">
    
    	<section style="display:table-cell;">
        
        	<input class='InputButton' style="margin-left:0px;" type="submit" value="Pošlji v pregled" name='Editing'
                formaction="<?php echo base_url()."vsebine/SendToEditing"; ?>">
            
            <?php if($User->level > 3) { ?> 
            <input class='InputButton'  type="submit" value="Objavi" 
                formaction="<?php echo base_url()."vsebine/Publish"; ?>">
            <?php } ?>
            
            
            <input class='InputButton attention' style="float:right;" type="button" value="Prekliči"
                onClick="document.location.href='<?php echo base_url()."Domov"; ?>';">
                
            <input class='InputButton' style="float:right;" type="submit" value="Shrani" name="Save" id='SaveButton' tabindex="5"
                formaction="<?php echo base_url()."vsebine/Update"; ?>">
        
        </section>
    
    </section>

    <script type="text/javascript">
		$("#SaveButton").on("click",function(e) {
			console.log($("#VsebineTags").val());
			
			if(CheckForEmpty("VsebineTags") || CheckForEmpty("VsebineText")) {
				e.preventDefault();
				alert("Prosim vpišite vsaj eno ključno besedo.");
			}
		});
		
		function CheckForEmpty(Element) {
			if($("#"+Element).val() == "" || $("#"+Element).val() == " " || 	typeof $("#"+Element).val() == "undefined")
				return true;
			else return false;
		}
	
	
		$("#PrispevekNaslovnaSlikaURL").on("change",function() {
			var ImageUrl = $(this).val();
			$("#PrispevekNaslovnaSlika").removeAttr("required");
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
				$("#PrispevekNaslovnaSlika").removeAttr("required");
			}
		});
		
		window.onresize = function() {
			var Width = $("#WidthMessurement").width();
			$(".GetWidth").css("width",Width+"px");
		}
	
		$(".gallery-image").on("click",function() {
			var ImageUrl = $(this).attr("src");
			$("#PrispevekNaslovnaSlika").removeAttr("required");
			$(".gallery-image").removeClass("SelectedImage");
			ChangePicture(ImageUrl);
			$(this).addClass("SelectedImage");
		});
	
		$("#VsebineTags").tagsInput({
			'autocomplete_url': '<?php echo base_url()."vsebine/AutocompleteTags"; ?>',
			'minChars':'3',
			'maxChars':'50',
			'onRemoveTag': function(tag) { RemoveTag(tag); },
			'defaultText': 'Dodajte novo ključno besedo',
			'placeholderColor': '#333',
			'width': '550px',
			'height': '70px'
		});
		
		jQuery("#VsebineTags").importTags(' <?php foreach($Prispevek->tags as $Tag) echo $Tag->tag.","; ?> ');

		jQuery('.TextEditor').jqte({
			unlink: false
		});
		
		function RemoveTag(tag,prispevekId) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url()."vsebine/RemoveTagFromPrispevek"; ?>",
				data: { PrispevekId: <?php echo $Prispevek->id; ?>, Tag: tag }
			}).fail(function(data) { console.log("Fail: "+JSON.stringify(data)); });
		}
		
		$(function() {
			$(".DatePicker").datepicker({ 
				dateFormat: "yy-mm-dd", 
				minDate: new Date(<?php echo date("Y"); ?>, <?php echo date("m"); ?> - 1, <?php echo date("d"); ?>) 
			});
		});
		
		function PrispevekController($scope) {
			this.Tags = "zelnik.net";
			this.Title = "<?php echo $Prispevek->title; ?>";
			$scope.TotalTodos = this.Tags;
		}
		
		setInterval("Update()",3000);
		function Update() {
			var FormData = $("#CreatePrispevekForm").serialize();

			$.ajax({
				type: "POST",
				url: "<?php echo base_url()."vsebine/Update"; ?>",
				data: FormData
			}).fail(function(data) { console.log("Fail: "+JSON.stringify(data)); });
		}
		
		function Save() {
			Update();
			SaveSuccessor();
		}
		
		function SaveSuccessor() {
			document.location.href = "<?php echo base_url()."Prispevek/".$Prispevek->id."/".$Prispevek->title_url; ?>";
		}
		
		function ChangeSection(Class, Section) {
			$(".prispevek_"+Class).css("display","none");
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
