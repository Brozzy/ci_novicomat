
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
</style>

<script type="text/javascript">
	$("#addLokacije").on("click",function() {
		$.post("Vsebine/createLokacije",function(data) {
			$("#LokacijosPlace").html(data);
		});
	});
</script>

<section id='PrispevekForm' ng-app="keywords" ng-controller="KeywordsController as keyword">
	<h2><?php echo $Prispevek->title; ?></h2>
            
    
    <?php echo form_open_multipart("Vsebine/createPrispevek"); ?>
		
        <table style="width:100%;">
        	<thead>
            	<tr>
                	<td colspan="2" style="width:70%;">
                    	<label for="PrispevekTitle">Naslov <span class="required">*</span></label><br>
        				<input id="PrispevekTitle" value='<?php echo $Prispevek->title; ?>' style="width:30%;" tabindex="1"  name="PrispevekTitle" required type="text"><br>

                        <label for="PrispevekIntrotext">Uvodno besedilo <span class="required">*</span> </label><br>		
                        <textarea rows="3" cols="80" tabindex="2" name="PrispevekIntrotext" id="PrispevekIntrotext" required><?php echo $Prispevek->introtext; ?></textarea>
                    </td>
                    <td rowspan="2">
                    	<label>Naslovna slika <span class="required">*</span></label><br>
                    	<img title="Naloži sliko" style="width:265px;" id="IkonaNaslovnaSlika" src="<?php if($Prispevek->slika == "") echo base_url()."style/images/image_upload.png"; else echo $Prispevek->slika; ?>" alt="Ikona za nalaganje slike"><br>
                        
                    	<label for="PrispevekNaslovnaSlika">Naloži naslovno sliko iz računalnika</label><br>	
                        <input size="40" type="file" accept="image/gif,image/jpeg,image/png,image/bmp" name='PrispevekNaslovnaSlika' id='PrispevekNaslovnaSlika'><br>
                        
                        <label for="PrispevekNaslovnaSlikaURL">Naloži naslovno sliko iz URL naslova</label><br>
                        <input size="60" name="PrispevekNaslovnaSlikaURL" id="PrispevekNaslovnaSlikaURL" type="url">

                    </td>
                </tr>
				<tr>
                	<td colspan="2">
                    	<label for="VsebineText">Besedilo <span class="required">*</span></label><br>		
						<textarea id="VsebineText" class='TextEditor' name="VsebineText"></textarea>
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
                        <input size="40" multiple type="file" name="PrispevekPriponke" id="PrispevekPriponke" 
                        	accept="application/x-zip-compressed,application/msexcel,application/msword,application/pdf,application/rtf"><br>
                        
                        <label for="PrispevekSlika">Naloži slike iz računalnika</label><br>
                        <input size="40" multiple type="file" name="PrispevekSlika" id="PrispevekSlika"><br>
                        
                        <label for="PrispevekSlikaGalerije">Izberi sliko iz galerije</label><br>
                        <input size="40" multiple type="file" value="" name="PrispevekSlikaGalerije" id="PrispevekSlikaGalerije"><br>													
                    </td>
                    <td>
                    	<label for="PrispevekSlikaURL">Naloži sliko iz URL naslova</label><br>
                        <input size="60" type="text" name="PrispevekSlikaURL" id="PrispevekSlikaURL"><br>
                        
                        <label for="VsebineVideo">Vstavi video iz <a href='http://www.youtube.com' target="_blank">Youtube.com</a></label><br>
                        <input size="60" name="VsebineVideo" id="VsebineVideo" type="text"><br>
                        
                        <label for="VsebineAvtorAlias">Ime avtorja ali psevdonim&nbsp;&nbsp; <small>(avtor izvirnika: <?php echo $User->name; ?>)</small></label><br>
                        <input size="60" maxlength="256" name="VsebineAvtorAlias" id="VsebineAvtorAlias" type="text"><br>	
                    </td>
                    <td>
						<label for="VsebinePublishUp">Začetek objave <span class="required">*</span> <small>(privzeto današnji datum)</small></label><br>				
                        <input id="VsebinePublishUp" name="VsebinePublishUp" class='DatePicker' tabindex="4" type="date" value="<?php echo date('m/d/Y'); ?>"><br>									
						
                        <label for="Vsebine_publish_down">Konec objave</label><br>
                        <input id="Vsebine_publish_down" name="Vsebine[publish_down]" class='DatePicker' tabindex="5" type="text" />
                    </td>
                </tr>
            </tbody>
            
            <tfoot>
            	<tr>
                	<td colspan="3" style="border-top:thin solid #999; padding-top:15px;">
                    	<label for="VsebineFrontpage">Prikaži prispevek na prvi strani</label>                       
                        <input name="VsebineFrontpage" id="VsebineFrontpage" tabindex="3" value="1" <?php if($Prispevek->frontpage == 1) echo "checked='checked'"; ?> type="checkbox"><br><br>
                        
                        <div>
                        
                            <label for="VsebineTags">Ključne besede <span class="required">*</span> 
                                <small style="margin-left:5px;">(ključne besede ločite z vejico, vključujejo pa lahko le velike in male črke, piko in številke)</small>
                            </label>
                            <br>
                            <input size="60" id="VsebineTags" name="VsebineTags" type="text" ng-model="Tags" pattern="[A-Za-z\s,.0-9]*">
                            <br>
                            {{keyword.filterKeyWords(Tags)}}
                            
                            <?php foreach($Prispevek->tags as $Tag) { echo "<span class='keyword'>".$Tag."</span>"; } ?>
                            
                            <span class='keyword' ng-repeat="k in keyword.Tags">
                         		{{k}}
                        	</span>

                        </div>
                    </td>
                </tr>
                <tr>
                	<td colspan="3" style="padding-top:15px;">
                        <label>Objavi na portalih:</label><br>
                        
                        <div class='Portal'>
                        	<img src='http://g.etfv.co/http://www.zelnik.net' alt="Link favicon" 
                            	style="height:18px; opacity:0.7; width:auto; margin-right:3px;">
                            
                            <input type="checkbox" value="1" ng-click="keyword.Add('zelnik.net');" name="PrispevekPortal[1]" class="Portal" id="zelnik.net">
                            <label for='zelnik.net'>zelnik.net</label>
                        </div>
                        
                        <div class='Portal'>
                        	<img src='http://g.etfv.co/http://www.klub-gros.com' alt="Link favicon" 
                            	style="height:18px; opacity:0.7; width:auto; margin-right:3px;">
                                
                            <input type="checkbox" value="2" name="PrispevekPortal[2]" class="Portal" id="klub-gros.com">
                            <label for='klub-gros.com'>klub-gros.com</label>
                        </div>
                        
                        <div class='Portal'>
                        	<img src='http://g.etfv.co/http://www.ivancna-gorica.si' alt="Link favicon" 
                            	style="height:18px; opacity:0.7; width:auto; margin-right:3px;">
                                
                            <input type="checkbox" value="3" name="PrispevekPortal[3]" class="Portal" id="ivancna-gorica.si">
                            <label for='ivancna-gorica.si'>ivancna-gorica.si</label>
                        </div>
                    </td>
                </tr>
                <tr>
                	<td colspan="3" style="padding-top:30px;">
                        <input class='InputButton'  type="submit" value="Pošlji v pregled" 
                        	formaction="<?php echo base_url()."Vsebine/createPrispevek"; ?>">

                        <input class='InputButton attention' style="float:right;" type="button" 
                        	onClick="document.location.href='<?php echo base_url()."Home"; ?>';" value="Prekliči">
                            
                        <input class='InputButton' style="float:right;" type="submit" value="Shrani" 
                        	formaction="<?php echo base_url()."Vsebine/updatePrispevek"; ?>">
                    </td>
                </tr>
            </tfoot>
        </table>
	</form>
</section>
<hr>

    <script type="text/javascript">
		jQuery(function($){
			$('.CropImage').Jcrop();
		});

		jQuery('.TextEditor').jqte({
			unlink: false
		});
		
		$(function() {
			$(".DatePicker").datepicker();
		});
		
		function KeyWordsCtrl($scope) {
			this.Tags = "zelnik.net";
			$scope.TotalTodos = this.Tags;
		}
	</script>
