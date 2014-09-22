<?php
	if(!isset($_SESSION))
	{
	    ob_start();
	    session_start();
	}

	$user_model = $this->loadModel('UserModel');
	if(isset($_SESSION['pc_user']) || isset($_COOKIE['pc_user'])){
        if(isset($_COOKIE['pc_user'])) {
	        $userid = $_COOKIE['pc_user'];
	        $_SESSION['pc_user'] = $userid;
	    }

	    $dir = 'application/PirateChest/';

        if(isset($_GET['dir']) && !empty($_GET['dir'])) {
            $dir = trim(htmlentities($_GET['dir']));
        }
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require 'application/views/_templates/linkrels.php'; ?>
		<title>PirateChest</title>
	</head>

	<body class="metro">
		<header>
			<?php require 'application/views/_templates/header.php'; ?>
		</header>

		<section class="user">
			<div class="box">
				<div class="box20 sidenav">
					<ul class="sidenav">
						<a href="#"><li class="active">All files</li></a>
						<a href="<?php echo URL; ?>chat"><li>Pirate Chat</li></a>
						<a href="<?php echo URL; ?>logout"><li>Logout</li></a>
					</ul>
				</div>

				<div class="box80" style="height: 100%; overflow: scroll;">
					<ul class="nav">
						<li class="no-desktop no-phone on-tablet-portrait">
							<a href="#">
						    	<img src="<?php echo URL; ?>/public/img/pull.png" width="25"/>
						    </a>
						</li>
						<li>
							<?php
								$break_path = explode('/', $dir);

								for ($i = 0; $i < count($break_path); $i++) { 
									if($break_path[$i] == 'PirateChest') {
										echo '
											<a href="'.URL.'">
										    	<img src="'.URL.'/public/img/House.png" width="25"/>
										    	<img src="'.URL.'/public/img/ArrowRight.png" width="20"/>
										    </a>
										';
									}elseif($break_path[$i] != '' && $i >= 2) {
										$_path = '';
										for($j = 0; $j <= $i;$j++) {
											$_path.= $break_path[$j].'/';
										}
										echo '
											<a href="'.URL.'?dir='.$_path.'">
										    	'.$break_path[$i].'
										    	<img src="'.URL.'/public/img/ArrowRight.png" width="20"/>
										    </a>
										';
									}
								}
							?>
						</li>
						<li>
							<button id="newfolder"><img src="<?php echo URL; ?>public/img/White-Folder-Add.png" width="25" /></button>
						</li>
						<li>
							<button id="upload"><img src="<?php echo URL; ?>public/img/White-Upload.png" width="25" /></button>
						</li>

						<li id="newfolderform">
							<form action="<?php echo URL; ?>files/newfolder" method="POST">
								<div class="input-control text">
									<input type="text" name="folder" placeholder="Folder name" />
									<input type="hidden" name="dir" value="<?php echo $dir; ?>">
								</div>
							</form>
						</li>

						<li id="uploadstatus">
							<form action="<?php echo URL; ?>files/upload" method="POST" enctype="multipart/form-data">
								<input type="file" id="fileuploader" name="fileuploader" style="display: none">
								<input type="hidden" name="dir" value="<?php echo $dir; ?>">
								<button id="uploadbtn" class="fg-white" name="uploadbtn">Upload</button>
							</form>
						</li>
					</ul>
				    <!-- Files Table -->
				    <table class="table hovered sortable" style="width:100%">
                        <thead>
	                        <tr>
	                            <th class=""></th>
	                            <th class="text-left">Name</th>
	                            <th class="text-left">Size</th>
	                            <th class="text-left">Modified</th>
	                            <th class="text-left"></th>
	                        </tr>
                        </thead>

                        <tbody>
                        	<?php
                        		$path = $dir;
                        		/*if(trim(htmlentities($_SERVER['QUERY_STRING']=="hidden"))){
                        			$hide = "";
									$ahref = "./";
									$atext = "Hide";
								}else{
									$hide = ".";
									$ahref = "./?hidden";
									$atext = "Show";
								}*/

                        		if(is_dir($path)) {
                        			if($files = opendir($path)) {
	                        			while (($file = readdir($files)) !== false) {
	                        				if($file != '.' && $file != '..') {
		                        				if(filetype($path.$file) == 'dir') {
		                        					$fileImg = URL.'public/img/File-Types/folder.png';
		                        					echo '
				                        				<tr>
				                        					<td><img src="'.$fileImg.'" width="32"/></td>
				                        					<td><a href="'.URL.'?dir='.$path.$file.'/">'.$file.'</a></td>
				                        					<td sorttable_customkey="0"></td>
				                        					<td sorttable_customkey="'.filemtime($path.$file).'">'.$user_model->pretty_timeago(filemtime($path.$file)).'</td>
				                        					<td></td>
				                        				</tr>
			                        				';
		                        				}
		                        			}
	                        			}

	                        			closedir($files);

	                        			$files = opendir($path);
	                        			while (($file = readdir($files)) !== false) {
	                        				if($file != '.' && $file != '..') {
		                        				if (filetype($path.$file) == 'file') {
		                        					if(file_exists('public/img/File-Types/'.pathinfo($path.$file)['extension'].'.png')) {
		                        						$fileImg = URL.'public/img/File-Types/'.pathinfo($path.$file)['extension'].'.png';
		                        					}else {
		                        						$fileImg = URL.'public/img/File-Types/file.png';
		                        					}
		                        					echo '
				                        				<tr>
				                        					<td><img src="'.$fileImg.'" width="32"/></td>
				                        					<td><a href="'.URL.'download/?dir='.$path.'&file='.$file.'">'.$file.'</a></td>
				                        					<td sorttable_customkey="'.filesize($path.$file).'">'.$user_model->pretty_filesize(filesize($path.$file)).'</td>
				                        					<td sorttable_customkey="'.filemtime($path.$file).'">'.$user_model->pretty_timeago(filemtime($path.$file)).'</td>
				                        					<td>
				                        						<a href="'.URL.'download/?dir='.$path.'&file='.$file.'"><img src="'.URL.'public/img/Download.png" width="32"/></a>
				                        						<a href="'.URL.'delete?dir='.$path.'&file='.$file.'"><img src="'.URL.'public/img/Red-Bin.png" width="32"/></a>
				                        					</td>
				                        				</tr>
			                        				';
		                        				}
		                        			}
	                        				//echo "filename: $file : filetype:". filetype($path.$file)." : filetime: ".filemtime($path.$file)." : filesize: ".filesize($path.$file)." : filemime: ".pathinfo($path.$file)['extension']. "\n";
	                        			}
	                        			closedir($files);
	                        		}
                        		}
                        	?>
	    				</tbody>
						</table>

                        </tbody>

                        <tfoot></tfoot>
                    </table>
				</div>
			</div>
		</section>
	</body>
</html>
<?php
	}elseif (isset($_SESSION['anonymous']) && $_SESSION['anonymous'] == true) {
	$dir = 'application/PirateChest/';

    if(isset($_GET['dir']) && !empty($_GET['dir'])) {
        $dir = trim(htmlentities($_GET['dir']))."/";
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require 'application/views/_templates/linkrels.php'; ?>
		<title>PirateChest</title>
	</head>

	<body class="metro">
		<header>
			<?php require 'application/views/_templates/header.php'; ?>
		</header>

		<section class="user">
			<div class="box">
				<div class="box20 sidenav">
					<ul class="sidenav">
						<a href="#"><li class="active">All files</li></a>
						<a href="<?php echo URL; ?>chat"><li>Pirate Chat</li></a>
						<a href="<?php echo URL; ?>logout"><li>Logout</li></a>
					</ul>
				</div>

				<div class="box80" style="height: 100%; overflow: scroll;">
					<ul class="nav">
						<li class="no-desktop no-phone on-tablet-portrait">
							<a href="#">
						    	<img src="<?php echo URL; ?>/public/img/pull.png" width="25"/>
						    </a>
						</li>
						<li>
							<?php
								$break_path = explode('/', $dir);

								for ($i = 0; $i < count($break_path); $i++) { 
									if($break_path[$i] == 'PirateChest') {
										echo '
											<a href="'.URL.'">
										    	<img src="'.URL.'/public/img/House.png" width="25"/>
										    	<img src="'.URL.'/public/img/ArrowRight.png" width="20"/>
										    </a>
										';
									}elseif($break_path[$i] != '' && $i >= 2) {
										$_path = '';
										for($j = 0; $j <= $i;$j++) {
											$_path.= $break_path[$j].'/';
										}
										echo '
											<a href="'.URL.'?dir='.$_path.'">
										    	'.$break_path[$i].'
										    	<img src="'.URL.'/public/img/ArrowRight.png" width="20"/>
										    </a>
										';
									}
								}
							?>
						</li>
						<li>
							<button id="newfolder"><img src="<?php echo URL; ?>public/img/White-Folder-Add.png" width="25" /></button>
						</li>
						<li>
							<button id="upload"><img src="<?php echo URL; ?>public/img/White-Upload.png" width="25" /></button>
						</li>

						<li id="newfolderform">
							<form action="<?php echo URL; ?>files/newfolder" method="POST">
								<div class="input-control text">
									<input type="text" name="folder" placeholder="Folder name" />
									<input type="hidden" name="dir" value="<?php echo $dir; ?>">
								</div>
							</form>
						</li>

						<li id="uploadstatus">
							<form action="<?php echo URL; ?>files/upload" method="post" enctype="multipart/form-data" id="MyUploadForm">
								<input type="file" id="fileuploader" name="fileuploader" style="display: none">
								<input type="hidden" name="dir" value="<?php echo $dir; ?>">
								<button id="uploadbtn" class="fg-white" name="uploadbtn">Upload</button>
							</form>
						</li>
					</ul>
				    <!-- Files Table -->
				    <table class="table hovered sortable" style="width:100%">
                        <thead>
	                        <tr>
	                            <th class=""></th>
	                            <th class="text-left">Name</th>
	                            <th class="text-left">Size</th>
	                            <th class="text-left">Modified</th>
	                            <th class="text-left"></th>
	                        </tr>
                        </thead>

                        <tbody>
                        	<?php
                        		$path = $dir;

                        		if(is_dir($path)) {
                        			if($files = opendir($path)) {
	                        			while (($file = readdir($files)) !== false) {
	                        				if($file != '.' && $file != '..') {
		                        				if(filetype($path.$file) == 'dir') {
		                        					$fileImg = URL.'public/img/File-Types/folder.png';
		                        					echo '
				                        				<tr>
				                        					<td><img src="'.$fileImg.'" width="32"/></td>
				                        					<td><a href="'.URL.'?dir='.$path.$file.'/">'.$file.'</a></td>
				                        					<td sorttable_customkey="0"></td>
				                        					<td sorttable_customkey="'.filemtime($path.$file).'">'.$user_model->pretty_timeago(filemtime($path.$file)).'</td>
				                        					<td></td>
				                        				</tr>
			                        				';
		                        				}
		                        			}
	                        			}

	                        			closedir($files);

	                        			$files = opendir($path);
	                        			while (($file = readdir($files)) !== false) {
	                        				if($file != '.' && $file != '..') {
		                        				if (filetype($path.$file) == 'file') {
		                        					if(file_exists('public/img/File-Types/'.pathinfo($path.$file)['extension'].'.png')) {
		                        						$fileImg = URL.'public/img/File-Types/'.pathinfo($path.$file)['extension'].'.png';
		                        					}else {
		                        						$fileImg = URL.'public/img/File-Types/file.png';
		                        					}
		                        					echo '
				                        				<tr>
				                        					<td><img src="'.$fileImg.'" width="32"/></td>
				                        					<td><a href="'.URL.'download/?dir='.$path.'&file='.$file.'">'.$file.'</a></td>
				                        					<td sorttable_customkey="'.filesize($path.$file).'">'.$user_model->pretty_filesize(filesize($path.$file)).'</td>
				                        					<td sorttable_customkey="'.filemtime($path.$file).'">'.$user_model->pretty_timeago(filemtime($path.$file)).'</td>
				                        					<td>
				                        						<a href="'.URL.'download/?dir='.$path.'&file='.$file.'"><img src="'.URL.'public/img/Download.png" width="32"/></a>
				                        					</td>
				                        				</tr>
			                        				';
		                        				}
		                        			}
	                        				//echo "filename: $file : filetype:". filetype($path.$file)." : filetime: ".filemtime($path.$file)." : filesize: ".filesize($path.$file)." : filemime: ".pathinfo($path.$file)['extension']. "\n";
	                        			}
	                        			closedir($files);
	                        		}
                        		}
                        	?>
	    				</tbody>
						</table>

                        </tbody>

                        <tfoot></tfoot>
                    </table>
				</div>
			</div>
		</section>
	</body>
</html>
<?php
    }else {
 ?>
<!DOCTYPE html>
<html>
	<head>
		<?php require 'application/views/_templates/linkrels.php'; ?>
		<title>PirateChest</title>
	</head>

	<body class="metro login-page">
		<header>
			<?php //require 'application/views/_templates/header.php'; ?>
		</header>

		<section>
			<img src="<?php echo URL; ?>public/img/PirateChest.png" height="120" width="98%">
			<?php
				$users = $user_model->db->select("pc_user");
				if(empty($users)) {

					?>
			<form action="<?php echo URL; ?>user/register" method="POST">
				<?php
					if(isset($_SESSION['error'])) {
						echo '<div class="notice marker-on-bottom bg-red" style="margin-bottom: 10px;">
								<b>Error: </b>'.$_SESSION['error'].'
							</div>';
						unset($_SESSION['error']);
					}else if(isset($_SESSION['success'])) {
						echo '<div class="notice marker-on-bottom bg-green" style="margin-bottom: 10px;">
								<b>Success: </b>'.$_SESSION['success'].'
							</div>';
						unset($_SESSION['success']);
					}
				?>
				<div>
					<label class="no-large no-desktop no-tablet no-tablet-portrait on-phone">Username:</label>
					<input type="text" id="username" name="username" placeholder="Username" data-transform="input-control" />
				</div>
				<div>
					<label class="no-large no-desktop no-tablet no-tablet-portrait on-phone">Password:</label>
					<input type="password" id="password" name="password" placeholder="Password" data-transform="input-control" />
				</div>
			    <div class="grid">
				    <div class="row" style="overflow: hidden">
					    <div class="text-right" style="float:right; width:49%;"><button class="large fg-white" style="background-color: #333" id="register" name="register">Register</button></div>
				    	<div style="float:right; width:49%;"></div>
				    </div>
			    </div>
			</form>
					<?php
				}else {
					?>
			<form action="<?php echo URL; ?>user/login" method="POST">
				<?php
					if(isset($_SESSION['error'])) {
						echo '<div class="notice marker-on-bottom bg-red" style="margin-bottom: 10px;">
								<b>Error: </b>'.$_SESSION['error'].'
							</div>';
						unset($_SESSION['error']);
					}else if(isset($_SESSION['success'])) {
						echo '<div class="notice marker-on-bottom bg-green" style="margin-bottom: 10px;">
								<b>Success: </b>'.$_SESSION['success'].'
							</div>';
						unset($_SESSION['success']);
					}
				?>
				<div>
					<label class="no-large no-desktop no-tablet no-tablet-portrait on-phone">Username:</label>
					<input type="text" id="username" name="username" placeholder="Username" data-transform="input-control" />
				</div>
				<div>
					<label class="no-large no-desktop no-tablet no-tablet-portrait on-phone">Password:</label>
					<input type="password" id="password" name="password" placeholder="Password" data-transform="input-control" />
				</div>
			    <div class="grid">
				    <div class="row" style="overflow: hidden">
					    <div class="text-right" style="float:right; width:49%;"><button class="large fg-white" style="background-color: #333">Login</button></div>
				    	<div style="float:right; width:49%;">
						    <div class="input-control checkbox">
								<label>
									<input type="checkbox" id="remember" name="remember" />
									<span class="check"></span>
									remember
								</label>
							</div>
						</div>
				    </div>
			    </div>
			</form>
					<?php
				}
			?>
			<p><a href="<?php echo URL; ?>home/anonymous" style="color: #CCC">Visitor? Open Chest Anonymously</a></p>
		</section>

		<footer>
			<p style="color:#333 !important"><b>PirateChest</b> - share files anonymously</p>
		</footer>
	</body>
</html>
 <?php
    }
?>