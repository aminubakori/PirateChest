<?php

/**
 * Class Delete
 */
class Delete extends Controller
{
    public function index()
    {
        if(isset($_GET['dir']) && !empty($_GET['dir']) && is_dir($_GET['dir']) && isset($_GET['file']) && !empty($_GET['file']) && is_file(trim(htmlentities($_GET['dir'].$_GET['file'])))) {
        	$file = trim(htmlentities($_GET['dir'].$_GET['file']));

        	unlink($file);

        	header("Location: ". URL ."?dir=".trim(htmlentities($_GET['dir'])));
        }else {
        	header("Location: ". URL);
        }
    }
}
