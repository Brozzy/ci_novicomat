<?php
    echo "<h1>Installing Novicomat.si files</h1>";
    CopyDir("../../ci.novicomat.si/public_html/","./");

    function CopyDir($source,$destination)
    {
        if(!is_dir($destination)){
            $oldumask = umask(0);
            mkdir($destination, 0755);
            umask($oldumask);

        }

        $dir_handle = @opendir($source) or die("Unable to create system files, aborting!");
        while ($file = readdir($dir_handle))
        {
            if($file!="." && $file!=".." && !is_dir("$source/$file")) {
                echo "--".$file."<br>";
                link("$source/$file","$destination/$file");
            }
            else if($file!="." && $file!=".." && is_dir("$source/$file")) {
                echo "----".$file."<br>";
                if($file == "views" || $file == "style") mkdir("$destination/$file", 0755);
                else CopyDir("$source/$file","$destination/$file");
            }
        }
        closedir($dir_handle);
    }

?>