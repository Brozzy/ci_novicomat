<?php
    echo "<h1>Installing Novicomat.si files</h1>";
    CopyDir("../../ci.novicomat.si/public_html/","./");

    //echo "<h1>Listing the desired dir</h1>";
    //ListDir("./nm_core/novicomat.si");

    function CopyDir($source,$destination)
    {
        if(!is_dir($destination)){
            $oldumask = umask(0);
            mkdir($destination, 0755);
            umask($oldumask);
        }

        $dir_handle = @opendir($source);
        while ($file = readdir($dir_handle))
        {
            if($file!="." && $file!=".." && !is_dir("$source/$file")) {
                echo "--".$file."<br>";
                link("$source/$file","$destination/$file");
            }
            else if($file!="." && $file!=".." && is_dir("$source/$file")) {
                echo "----".$file."<br>";
                if($file == "views" || $file == "style" || $file == "controllers" || $file == "js") mkdir("$destination/$file", 0755);
                else if($file == "system" || $file == "upload") symlink("$source/$file","$destination/$file");
                else CopyDir("$source/$file","$destination/$file");
            }
        }
        closedir($dir_handle);
    }

    function ListDir($dir) {
        if ($handle = opendir($dir)) {
            echo "Folder: '".$dir."'<hr>";

            echo "<ul>";
            while (false !== ($entry = readdir($handle))) {
                echo "<li>".$entry."</li>";
            }
            echo "<ul>";

            closedir($handle);
        }
    }


?>