
<style type="text/css" scoped>
	#Preview {
		width:50%;
		margin-left:auto;
		margin-right:auto;
		border:thin solid #888;
		padding:2%;
	}
	
	#Preview header { margin:0px; padding:0px; }
	
	#Preview h3 {
		font-size:1.4em; margin:0px; padding:0px;
	}
	
	#Preview h4 {
		font-weight:normal;
		font-size:0.9em; margin:5px 0px 0px 0px; padding:0px 0px 0px 15px;
	}
	
	.keyword { background-color:#ccdde2; border:1px solid #999; padding:3px 6px; margin-left:5px; margin-right:5px; }
	#PrispevekForm label { font-weight:500; }
	#PrispevekForm small { font-size:0.8em; opacity:0.8; }
</style>

<script type="text/javascript">
	angular.module('prispevekJS',[]).controller('PrispevekController',function() {
		this.Tags = "";
		
		this.filterKeyWords = function filter(Tags) {
			if(Tags == " " || Tags == "" || typeof Tags == "undefined")
				this.Tags = "";
			else
				this.Tags = Tags.split(',');
		}
		
		this.Add = function AddKeyWord(Portal) {
			this.Tags = "";
		}
	});
</script>

<section id='PrispevekForm' ng-app="prispevekJS" ng-controller="PrispevekController as Ctrl">
	<h2>Urejanje prispevka</h2>
            
    
    <?php echo form_open_multipart("Vsebine/Create",array("id" => "CreatePrispevekForm", "name" => "Prispevek")); ?>
    	<input type="hidden" value='<?php echo $Prispevek->id; ?>' name='Prispevek[id]'>
    
        <table style="width:100%;">
        	<thead>
            	<tr>
                	<td colspan="2" style="width:70%;">
                    	<label for="PrispevekTitle">Naslov <span class="required">*</span></label><br>
        				<input id="PrispevekTitle" value='<?php echo $Prispevek->title; ?>' style="width:30%;" tabindex="1"  name="Prispevek[title]" required type="text"><br>

                        <label for="PrispevekIntrotext">Uvodno besedilo <span class="required">*</span> </label><br>		
                        <textarea rows="3" cols="80" tabindex="2" name="Prispevek[introtext]" id="PrispevekIntrotext" required><?php echo $Prispevek->introtext; ?></textarea>
                    </td>
                    <td rowspan="2">
                    	<label>Naslovna slika <span class="required">*</span></label><br>
                    	<img title="Naloži sliko" style="width:265px;" id="IkonaNaslovnaSlika" src="<?php echo $Prispevek->slika; ?>" alt="Ikona za nalaganje slike"><br>
                        
                    	<label for="PrispevekNaslovnaSlika">Naloži naslovno sliko iz računalnika</label><br>	
                        <input size="40" type="file" accept="image/gif,image/jpeg,image/png,image/bmp" name='Prispevek[slika]' id='PrispevekNaslovnaSlika'><br>
                        
                        <label for="PrispevekNaslovnaSlikaURL">Naloži naslovno sliko iz URL naslova</label><br>
                        <input size="60" name="Prispevek[slika]" id="PrispevekNaslovnaSlikaURL" type="url" value='<?php if($Prispevek->slika != base_url()."style/images/image_upload.png") echo $Prispevek->slika; ?>' >

                    </td>
                </tr>
				<tr>
                	<td colspan="2">
                    	<label for="VsebineText">Besedilo <span class="required">*</span></label><br>		
						<textarea id="VsebineText" class='TextEditor' name="Prispevek[fulltext]" required><?php echo $Prispevek->fulltext; ?></textarea>
                    </td>
                </tr>
            </thead>
            
            <tbody>
            	<tr>
                	<td colspan="3"><hr>&nbsp;</td>
                </tr>
            	<tr>
                    <td>
                    	<label for="PrispevekPriponke">Priponke:</label><br>
                        <input size="40" multiple type="file" name="Prispevek[priponke]" id="PrispevekPriponke" 
                        	accept="application/x-zip-compressed,application/msexcel,application/msword,application/pdf,application/rtf"><br>
                        
                        <label for="PrispevekSlika">Naloži slike iz računalnika</label><br>
                        <input size="40" multiple type="file" name="Prispevek[slika]" id="PrispevekSlika"><br>
                        
                        <label for="PrispevekSlikaGalerije">Izberi sliko iz galerije</label><br>
                        <input size="40" multiple type="file" value="" name="Prispevek[galerija]" id="PrispevekSlikaGalerije"><br>													
                    </td>
                    <td>
                    	<label for="PrispevekSlikaURL">Naloži sliko iz URL naslova</label><br>
                        <input size="60" type="text" name="Prispevek[slikaURL]" id="PrispevekSlikaURL"><br>
                        
                        <label for="VsebineVideo">Vstavi video iz <a href='http://www.youtube.com' target="_blank">Youtube.com</a></label><br>
                        <input size="60" name="VsebineVideo" id="Prispevek[video]" type="text"><br>
                        
                        <label for="VsebineAvtorAlias">Ime avtorja ali psevdonim&nbsp;&nbsp; <small>(avtor izvirnika: <?php echo $User->name; ?>)</small></label><br>
                        <input size="60" maxlength="256" name="Prispevek[author_alias]" id="VsebineAvtorAlias" value='<?php echo $Prispevek->author_alias; ?>' type="text"><br>	
                    </td>
                    <td>
						<label for="VsebinePublishUp">Začetek objave <span class="required">*</span> <small>(privzeto današnji datum)</small></label><br>				
                        <input id="VsebinePublishUp" name="Prispevek[publish_up]" class='DatePicker' tabindex="4" type='text' value="<?php echo $Prispevek->publish_up; ?>"><br>									
						
                        <label for="Vsebine_publish_down">Konec objave <small>(v primeru, da je polje prazno se objava nikoli ne izbriše)</small></label><br>
                        <input id="Vsebine_publish_down" name="Prispevek[publish_down]" value="<?php echo $Prispevek->publish_down; ?>" class='DatePicker' tabindex="5" type="text" />
                    </td>
                </tr>
            </tbody>
            
            <tfoot>
            	<tr>
                	<td colspan="3" style="border-top:thin solid #999; padding-top:15px;">
                    	                       
                        <input name="Prispevek[frontpage]" id="VsebineFrontpage" value='1' <?php if($Prispevek->frontpage == 1) echo "checked"; ?> type="checkbox">
                        <label for="VsebineFrontpage">Prikaži prispevek na prvi strani</label><br><br>
                        <div>
                        
                            <label for="VsebineTags">Ključne besede <span class="required">*</span> 
                                <small style="margin-left:5px;">(ključne besede ločite z vejico, vključujejo pa lahko le velike in male črke, piko in številke)</small>
                            </label>
                            <br>
                            <input required size="60" id="VsebineTags" name="Prispevek[tags]" type="text" ng-model="Tags" pattern="[A-Za-z\s,.0-9]*" value='<?php foreach($Prispevek->tags as $Tag) echo $Tag->tag.","; ?>' >
                            <br>
                            {{Ctrl.filterKeyWords(Tags)}}
                            
                            <?php foreach($Prispevek->tags as $Tag) { echo "<span class='keyword'>".$Tag."</span>"; } ?>
                            
                            <span class='keyword' ng-repeat="k in Ctrl.Tags">
                         		{{k}}
                        	</span>

                        </div>
                    </td>
                </tr>
                <tr>
                	<td colspan="3" style="padding-top:15px;">
                        <label>Objavi na portalih:</label><br>
                        
                        <?php foreach($Portali as $Portal) { ?>
                        	<div class='Portal' id='Portal<?php echo $Portal->id; ?>'>
                                <img src='http://g.etfv.co/http://www.<?php echo $Portal->domena; ?>' alt="Link favicon" 
                                    style="height:18px; opacity:0.7; width:auto; margin-right:3px;">
                                
                                <input type="checkbox" value="<?php echo $Portal->id; ?>" name="Prispevek[portali][]" id='<?php echo $Portal->domena; ?>'
                                	<?php foreach($Prispevek->portali as $CurrentPortal) { if($Portal->id == $CurrentPortal->id) echo "checked"; } ?>
                                >
                                <label for='<?php echo $Portal->domena; ?>'><?php echo $Portal->domena; ?></label>
                                
                            </div>
                        <?php } ?>

                    </td>
                </tr>
                <tr>
                	<td colspan="3" style="padding-top:30px;">
                        <input class='InputButton'  type="submit" value="Pošlji v pregled" 
                        	formaction="<?php echo base_url()."Vsebine/createPrispevek"; ?>">
						
                        <?php if($User->level > 3) { ?> 
						<input class='InputButton'  type="submit" value="Objavi" 
                        	formaction="<?php echo base_url()."Vsebine/createPrispevek"; ?>">
                        <?php } ?>
						
                        
                        <input class='InputButton attention' style="float:right;" type="button" value="Prekliči"
                        	onClick="document.location.href='<?php echo base_url()."Home"; ?>';">
                            
                        <input class='InputButton' style="float:right;" type="button" value="Shrani" id='SaveButton'
                        	onClick="Save();">
                    </td>
                </tr>
            </tfoot>
        </table>
	</form>
    <hr>
</section>


    <script type="text/javascript">
		jQuery(function($){
			$('.CropImage').Jcrop();
		});

		jQuery('.TextEditor').jqte({
			unlink: false
		});
		
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
				url: "<?php echo base_url()."Vsebine/Update"; ?>",
				data: FormData
			}).fail(function(data) { console.log("Fail: "+JSON.stringify(data)); });
		}
		
		function Save() {
			Update();
			SaveSuccessor();
		}
		
		function SaveSuccessor() {
			
		}
	</script>
