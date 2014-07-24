<h1 style='margin:0px; padding:3px;'><a href='<?php echo base_url()."domov"; ?>' title="Nazaj domov" style="color:white;"><?php echo $user->name; ?></a><span style="margin-left: 10px; font-size: 0.7em; opacity: 0.8; font-weight: 300;"><?php echo $user->level_name; ?></span></h1>

<nav id="cbp-hrmenu" class="cbp-hrmenu">
    <ul>
        <li><a class="icon file3-icon" href="#">dodaj</a>
            <div class="cbp-hrsub">
                <div class="cbp-hrsub-inner">
                    <div>
                        <h4>Članki</h4>
                        <ul>
                            <li class="icon file-icon"><a href="<?php echo base_url()."content/Create"; ?>" target="_self">Nov Članek</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Mediji</h4>
                        <ul>
                            <li class="icon email-icon"><a href="<?php echo base_url()."content/GetModal/new-media"; ?>" target="_self">Dodaj Svoj Medij</a></li>
                            <li class="icon unlocked-icon"><a href="#" target="_self">Zaprosi za dovoljenje</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Multimedija</h4>
                        <ul>
                            <li class="icon images-icon"><a href="<?php echo base_url()."content/GetModal/new-image"; ?>" target="_self">Nova Slika</a></li>
                            <li class="icon video-icon"><a href="<?php echo base_url()."content/GetModal/new-video"; ?>" target="_self">Nov Video</a></li>
                            <li class="icon music-icon"><a href="<?php echo base_url()."content/GetModal/new-audio"; ?>" target="_self">Nov Glasbeni Posnetek</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Dogodki in lokacije</h4>
                        <ul>
                            <li class="icon clock-icon"><a href="<?php echo base_url()."content/GetModal/new-event"; ?>" target="_self">Nov Dogodek</a></li>
                            <li class="icon location-icon"><a href="<?php echo base_url()."content/GetModal/new-location"; ?>" target="_self">Nova Lokacija</a></li>
                        </ul>
                    </div>
                </div><!-- /cbp-hrsub-inner -->
            </div><!-- /cbp-hrsub -->
        </li>
        <li><a class="icon edit2-icon" href="#">urejanje</a>
            <div class="cbp-hrsub">
                <div class="cbp-hrsub-inner">
                    <div>
                        <h4>Članki</h4>
                        <ul>
                            <li class="icon file-icon"><a href="#" target="_self">Urejanje Člankov</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Mediji in ključne besede</h4>
                        <ul>
                            <li class="icon email-icon"><a href="#" target="_self">Urejanje Medijev</a></li>
                            <li class="icon tags-icon"><a href="#" target="_self">Urejanje Ključnih Besed</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Multimedija</h4>
                        <ul>
                            <li class="icon images-icon"><a href="#" target="_self">Urejanje Slik</a></li>
                            <li class="icon video-icon"><a href="#" target="_self">Video Vsebine</a></li>
                            <li class="icon music-icon"><a href="#" target="_self">Glasbeni posnetki</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Dogodki in lokacije</h4>
                        <ul>
                            <li class="icon clock-icon"><a href="#" target="_self">Urejanje Dogodkov</a></li>
                            <li class="icon location-icon"><a href="#" target="_self">Urejanje Lokacij</a></li>
                        </ul>
                    </div>
                </div><!-- /cbp-hrsub-inner -->
            </div><!-- /cbp-hrsub -->
        </li>
        <li><a class="icon address2-icon" href="#">upravljanje</a>
            <div class="cbp-hrsub">
                <div class="cbp-hrsub-inner">
                    <div>
                        <h4>Uporabniki</h4>
                        <ul>
                            <li class="icon user-icon"><a href="#" target="_self">Nov uporabnik</a></li>
                            <li class="icon users-icon"><a href="#" target="_self">Upravljanje z uporabniki</a></li>
                            <li class="icon locked-icon"><a href="#" target="_self">Dodeljevanje pravic</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Mediji</h4>
                        <ul>
                            <li class="icon plus-icon"><a href="#" target="_self">Nova podstran</a></li>
                            <li class="icon email-icon"><a href="#" target="_self">Upravljanje medijev</a></li>
                            <li class="icon locked-icon"><a href="#" target="_self">Dodeljevanje pravic</a></li>
                        </ul>
                    </div>
                </div><!-- /cbp-hrsub-inner -->
            </div><!-- /cbp-hrsub -->
        </li>
        <li><a class="icon settings-icon" href="#">razvoj</a>
            <div class="cbp-hrsub">
                <div class="cbp-hrsub-inner">
                    <div>
                        <h4>Pregled</h4>
                        <ul>
                            <li class="icon bug2-icon"><a href="<?php echo base_url()."content/Errors"; ?>" target="_self">Poročila o napakah</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Nastavitve</h4>
                        <ul>
                            <li class="icon link-icon"><a href="#" target="_self">Preusmeritev strani</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Obvestila</h4>
                        <ul>
                            <li class="icon mail-icon"><a href="#" target="_self">Novo javno obvestilo</a></li>
                            <li class="icon edit-icon"><a href="#" target="_self">Urejaj javna obvestila</a></li>
                        </ul>
                    </div>
                </div><!-- /cbp-hrsub-inner -->
            </div><!-- /cbp-hrsub -->
        </li>
        <li><a class="icon pie-icon" href="#">statistika</a>
            <div class="cbp-hrsub">
                <div class="cbp-hrsub-inner">
                    <div>
                        <h4>Poročila</h4>
                        <ul>
                            <li class="icon bars-icon"><a href="#" target="_self">Poročilo o obiskanosti</a></li>
                        </ul>
                    </div>
                </div><!-- /cbp-hrsub-inner -->
            </div><!-- /cbp-hrsub -->
        </li>
        <li style="float:right"><a class="icon user2-icon" href="#">profil</a>
            <div class="cbp-hrsub">
                <div class="cbp-hrsub-inner">
                    <div>
                        <h4>Urejanje</h4>
                        <ul>
                            <li class="icon user-icon"><a href="#" target="_self">Osebni podatki</a></li>
                            <li class="icon edit-icon"><a href="#" target="_self">Kontakt</a></li>
                            <li class="icon email-icon"><a href="#" target="_self">Spremeni e-naslov</a></li>
                            <li class="icon twitter-icon"><a href="#" target="_self">Twitter</a></li>
                            <li class="icon facebook-icon"><a href="#" target="_self">Facebook</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Pregled</h4>
                        <ul>
                            <li class="icon mail2-icon"><a href="#" target="_self">Obvestila</a></li>
                            <li class="icon mail-icon"><a href="#" target="_self">Novo sporočilo</a></li>
                            <li class="icon question-icon"><a href="#" target="_self">Kontaktirajte nas</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Nastavitve</h4>
                        <ul>
                            <li class="icon exit-icon"><a href="<?php echo base_url()."auth/Logout"; ?>" target="_self">Odjava</a></li>
                            <li class="icon bug2-icon" style="margin-bottom: 30px;"><a href="<?php echo base_url()."content/GetModal/new-bug"; ?>" target="_self">Javi napako</a></li>
                            <li class="icon cancel-icon"><a href="#" target="_self">Deaktiviraj profil</a></li>
                        </ul>
                    </div>
                </div><!-- /cbp-hrsub-inner -->
            </div><!-- /cbp-hrsub -->
        </li>
    </ul>
</nav>
