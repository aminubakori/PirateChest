<?php

/**
 * Class Download
 */
class Download extends Controller
{
    public function index()
    {
        if(isset($_GET['dir']) && !empty($_GET['dir']) && is_dir($_GET['dir']) && isset($_GET['file']) && !empty($_GET['file']) && is_file(trim(htmlentities($_GET['dir'].$_GET['file'])))) {
        	$allowed_ext = array (
			  // archives
			  'zip' => 'application/zip',

			  // documents
			  'pdf' => 'application/pdf',
			  'doc' => 'application/msword',
			  'xls' => 'application/vnd.ms-excel',
			  'ppt' => 'application/vnd.ms-powerpoint',
			  
			  // executables
			  'exe' => 'application/octet-stream',

			  // images
			  'gif' => 'image/gif',
			  'png' => 'image/png',
			  'jpg' => 'image/jpeg',
			  'jpeg' => 'image/jpeg',

			  // audio
			  'mp3' => 'audio/mpeg',
			  'wav' => 'audio/x-wav',

			  // video
			  'mpeg' => 'video/mpeg',
			  'mpg' => 'video/mpeg',
			  'mpe' => 'video/mpeg',
			  'mov' => 'video/quicktime',
			  'avi' => 'video/x-msvideo'
			);

			$fext = pathinfo(trim(htmlentities($_GET['dir'].$_GET['file'])))['extension'];

			if (!array_key_exists($fext, $allowed_ext) || $allowed_ext[$fext] == '') {
			  	$mtype = '';
			  	// mime type is not set, get from server settings
			  	if (function_exists('mime_content_type')) {
			    	$mtype = mime_content_type(trim(htmlentities($_GET['dir'].$_GET['file'])));
			 	}
			  	else if (function_exists('finfo_file')) {
				    $finfo = finfo_open(FILEINFO_MIME); // return mime type
				    $mtype = finfo_file($finfo, trim(htmlentities($_GET['dir'].$_GET['file'])));
				    finfo_close($finfo);  
			  	}
			  	if ($mtype == '') {
			    	$mtype = "application/force-download";
			  	}
			}else {
  				$mtype = $allowed_ext[$fext];
			}

			$fname = trim(htmlentities($_GET['file']));
			$file = trim(htmlentities($_GET['dir'].$_GET['file']));

			// set headers
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header("Content-Type: $mtype");
			header("Content-Disposition: attachment; filename=\"$fname\"");
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: " . filesize($file));
			readfile($file);
        }else {
        	header("Location: ". URL);
        }
    }
}
