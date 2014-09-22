<?php

/**
 * Class Files
 */
class Files extends Controller
{
    public function index()
    {

    }

    public function newfolder()
    {
        if(isset($_POST['folder']) && !empty($_POST['folder']) && isset($_POST['dir']) && !empty($_POST['dir'])) {
            $dir = trim(htmlentities($_POST['dir']));
            $folder = trim(htmlentities($_POST['folder']));

            if(file_exists($dir.$folder)) {
                header("Location: ".URL."?dir=".$dir);
            }else {
                mkdir($dir.$folder);
                header("Location: ".URL."?dir=".$dir);
            }
        }else {
            header("Location: ".URL);
        }
    }

    public function upload()
    {
        if(isset($_FILES["fileuploader"]) && $_FILES["fileuploader"]["error"] <= 0 && isset($_POST['dir']) && !empty($_POST['dir']))
        {
            ############ Edit settings ##############
            $UploadDirectory    = trim(htmlentities($_POST['dir'])); //specify upload directory ends with / (slash)
            ##########################################
           
            /*
            Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini".
            Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit
            and set them adequately, also check "post_max_size".
            */
           
            //check if this is an ajax request
            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
                header("Location: ".URL."?dir=".$UploadDirectory);
            }
           
           
            //Is file size is less than allowed size.
            if ($_FILES["fileuploader"]["size"] > 500000000) {
                header("Location: ".URL."?dir=".$UploadDirectory);
            }
           
            $File_Name          = strtolower($_FILES['fileuploader']['name']);
            $File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
            $Random_Number      = rand(0, 9999999999); //Random number to be added to name.
            $NewFileName        = $File_Name; //new file name
           
            if(move_uploaded_file($_FILES['fileuploader']['tmp_name'], $UploadDirectory.$NewFileName ))
               {
                // do other stuff
                       header("Location: ".URL."?dir=".$UploadDirectory);
            }else{
                header("Location: ".URL."?dir=".$UploadDirectory);
            }       
        }
        else
        {
            die();
            header("Location: ".URL."?dir=".$UploadDirectory);
        }
    }
}
