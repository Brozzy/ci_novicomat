<style type="text/css" scoped>
	input { padding:5px; font-size:1.1em; }
	
	#createLokacija { display:none; }
	#addDetails { display:none; }
	#FormButtons { display:none; }
	
	label { font-size:1.3em; color:#333; }
	.TextInput { padding:9px 7px 9px 7px; font-size:1.2em; margin:10px 10px 0px 10px; border:1px solid #222;  }
	
	#LocationInput { 
		background-image:url(/PHP/novicomat/slike/mglass.png); 
		background-position:left; 
		background-repeat:no-repeat; 
		background-size:auto 20px;
		width:100%;
		padding-left:12%;
	}
	
	#LocationNewButton { 
		width:115%;
		margin:0px;
		border:1px dashed #999; 
		background-color:transparent;
		font-size:1.3em; 
		text-transform:lowercase;
		cursor:pointer;
		display:none;
		
		transition:color 0.4s, border-color 0.4s;
		-webkit-transition:color 0.4, border-color 0.4ss;
		-moz-transition:color 0.4s, border-color 0.4s;
		color:#777;
	}
	
	#LocationNewButton:hover { 
		transition:color 0.4s, border-color 0.4s;
		-webkit-transition:color 0.4, border-color 0.4ss;
		-moz-transition:color 0.4s, border-color 0.4s;
		color:#222;
		border-color:#222;
	}
	
	.LocationFound {
		width:115%;
		margin:0px 10px 0px 10px;
		padding-left:8.3%;
		cursor:pointer;
		transition:background-color 0.5s;
		-webkit-transition:background-color 0.5s;
		-moz-transition:background-color 0.5s;
	}
	.LocationFound:hover {
		transition:background-color 0.3s;
		-webkit-transition:background-color 0.3s;
		-moz-transition:background-color 0.3s;
		background-color:#88cdef;
	}

	fieldset { width:45%; margin:0px; padding:0px; border:none; }
	.Invisible { display:none; opacity:0; }
	
	#LocationsList { list-style:none; width:40%; }
	.NewlyAddedLocation { border:thin solid #555;; padding:1%; font-size:1.2em; }
	
	.NewLocation input { margin-bottom:20px; }
	
</style>

<h2>Lokacije Form</h2>

<fieldset id='Location' style="border:none; padding:0px; margin:0px;">
    <legend>Lokacija</legend>
    <header id='searchLokacija'>
        <input type="text" name='LocationSearch' class='TextInput' id='LocationInput' placeholder="ulica, mesto, država ali naziv">				 			<br>
        <input type="button" value='Dodaj novo lokacijo' id='LocationAdd' class="Invisible TextInput" onClick="LocationAdd();">
        <input type="hidden" value='' name='LocationId'>
        
        <input id='LocationNewButton' value='Ustvari novo' type="button" onClick="ShowCreate();">
    </header>
    
    <br>
    
    <section id='createLokacija'>
        <label for="Lokacije_drzava" class="required">Država <span class="required">*</span></label>            <input required="required" value="Slovenija" name="Lokacije[drzava]" id="Lokacije_drzava" type="text" maxlength="265" />                
        <label for="Lokacije_ulica_vas">Ulica ali vas</label>            <input size="50" name="Lokacije[ulica_vas]" id="Lokacije_ulica_vas" type="text" maxlength="256" />                        
        <label for="Lokacije_h_st">Hišna številka</label>            <input size="5" name="Lokacije[h_st]" id="Lokacije_h_st" type="text" maxlength="8" />                        
        <label for="Lokacije_postna_st">Poštna številka</label>            <input size="5" name="Lokacije[postna_st]" id="Lokacije_postna_st" type="text" maxlength="8" />                        
        <label for="Lokacije_kraj">Kraj</label>            <input name="Lokacije[kraj]" id="Lokacije_kraj" type="text" maxlength="256" />                    </section>
    
    <section id="addDetails">        
        <label for="Lokacije_obcina">Občina</label>            <input name="Lokacije[obcina]" id="Lokacije_obcina" type="text" maxlength="250" />                        
        <label for="Lokacije_ime_lokacije">Ime Lokacije</label>            <input name="Lokacije[ime_lokacije]" id="Lokacije_ime_lokacije" type="text" maxlength="256" />                        
        <label for="Lokacije_ime_prostora">Ime Prostora</label>            <input name="Lokacije[ime_prostora]" id="Lokacije_ime_prostora" type="text" maxlength="250" />                        
        <label for="Lokacije_ime_stavbe">Ime Stavbe</label>            <input name="Lokacije[ime_stavbe]" id="Lokacije_ime_stavbe" type="text" maxlength="250" />                        
        <label for='OpisLokacije'>Opis</label>
        <textarea id='OpisLokacije' name='OpisLokacije'></textarea>
    </section>

    <footer class="row buttons" id='FormButtons'>
        <input type="button" value='Dodaj podrobnosti' onClick="AddDetails();" id='AddDetailsButton'>
        <input type="button" value='Prekliči' onClick="CencelNew();" id='CencelNewButton'>
        <input type="submit" name="yt0" value="Shrani" />        </footer>

</fieldset>