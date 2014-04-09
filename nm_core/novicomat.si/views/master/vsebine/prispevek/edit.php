
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
	
</style>

<?php echo form_open_multipart("vsebine/Create",array("id" => "CreatePrispevekForm", "name" => "Prispevek")); ?>
    	<input type="hidden" value='<?php echo $Prispevek->id; ?>' name='Prispevek[id]'>
        
<section id='PrispevekForm' >

	<!-- UREJANJE SECTION -->
    <section style="display:table; width:100%; margin:20px 0px 20px 0px; padding:10px 0px 10px 0px; background-color:#3e57c5;">

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
    <section style="display:table; width:100%; margin:20px 0px 20px 0px; padding:10px 0px 10px 0px; background-color:#3e57c5; ">
    	
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
            
            <label>Naslovna slika <span class="required">*</span> <small> slika naj bo formata .jpg, .png ali .gif</small></label><br>
            <a class='fancybox' href='<?php echo $Prispevek->slika; ?>'><img title="Naloži sliko" style="height:200px; max-width:500px;" id="IkonaNaslovnaSlika" src="<?php echo $Prispevek->slika; ?>" alt="Ikona za nalaganje slike"></a><br>

            <label for="PrispevekNaslovnaSlika" style="display:inline;">Naloži naslovno sliko iz računalnika</label><br>	
            <input type="file" tabindex="3" accept="image/gif,image/jpeg,image/png" name='Prispevek[slika]' id='PrispevekNaslovnaSlika' required><br>
			<input type='hidden' name='Prispevek[slika]' value='<?php echo $Prispevek->slika; ?>'>
			
        </section>
        
		<!-- PRIPONKE SLIKE SECTION -->
        <section class='prispevek_section prispevek_priponke' id='prispevek_slike'>  
        	<header>
            	<h3>Slike</h3>
            </header>
        
        	<label for="PrispevekPriponke">Priponke:</label>
            <input size="40" multiple type="file" name="Prispevek[dokument_priponka]" id="PrispevekPriponke" 
                accept="application/x-zip-compressed,application/msexcel,application/msword,application/pdf,application/rtf"><br>
            
            <label for="PrispevekSlika">Naloži slike iz računalnika</label>
            <input size="40" multiple type="file" name="Prispevek[slika_priponka]" id="PrispevekSlika"><br>
            
            <label for="PrispevekSlikaGalerije">Izberi sliko iz galerije</label>
            <input size="40" multiple type="file" value="" name="Prispevek[galerija_priponka]" id="PrispevekSlikaGalerije"><br>	
        
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
    <section style="display:table; width:100%; margin:20px 0px 50px 0px; padding:10px 0px 10px 0px; background-color:#3e57c5;">
    
		<!-- OBJAVA MENU SECTION -->
    	<header style="display:table-cell; width:200px;">
        	<h2>Objava</h2>
            <ul class='EditButtons'>
            	<li class="EditButton objava selected" onClick="ChangeSection('objava', 'prispevek_keywords'); $(this).addClass('selected');">Ključne besede</li>
                <li class="EditButton objava" onClick="ChangeSection('objava', 'prispevek_date'); $(this).addClass('selected');">Datum objave</li>
                <li class="EditButton objava" onClick="ChangeSection('objava', 'prispevek_portali'); $(this).addClass('selected');">Portali</li>
            </ul>
        </header>
		
		<!-- OBJAVA KEYWORDS SECTION -->
        <section class='prispevek_section prispevek_objava' id='prispevek_keywords' style="display:table-cell;">  
        	<header>
            	<h3>Ključne besede</h3>
            </header>
            
            <label for="VsebineTags">Ključne besede ločite z vejico, vsebujejo naj od 3 do 50 znakov.</label>
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
		jQuery("#VsebineTags").tagsInput({
			'minChars':'3',
			'maxChars':'50',
			'onRemoveTag': function(tag) { RemoveTag(tag); }
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
		
		$('.fancybox').fancybox();
	</script>
