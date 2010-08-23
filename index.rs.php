<?php
	$path = "pages/";
	$default_page = "home";
	$notheme = FALSE;
	
	$allowed_exts = array("php","html","txt","");
	
	// Use default page on no page selected, i.e. "/"
	if (!isset($_GET['page']) || $_GET['page'] == "") :
		$page = $default_page;
	else :
		$page = $_GET['page'];
	endif;
		
	// Remove any bad characters, such as ".."
	// ".." would allow acess to higher up directories
	$bad  = array("..","/","<",">","?");
	$page = str_replace($bad,"",$page);

	// Check for page using "$allowed_exts"
	foreach ($allowed_exts as $ext) {
		if (file_exists($path.$page.".".$ext)) {
			$true_ext = $ext;
			$nofile = FALSE;
			break;
		} else {
			$nofile = TRUE;
		}
	}
	
	// Special cases for pages
	switch ($page) {
		case "rss":
			$notheme = TRUE;
			$nofile = FALSE;
			$page = "rss";
			$true_ext = "php";
			break;
	}
	
	// Send 404 headers on file not found
	if ($nofile == TRUE) {
		header("HTTP/1.0 404 Not Found");
		if (file_exists($path."404.php")) {
			$page = "404";
			$true_ext = "php";
		} else {
			$path = "";
			$page = "theme/404";
			$true_ext = "php";
		}
	}
	
	// Display page
	// Include header, page	and footer
	if ($notheme == FALSE)
		include("theme/header.php");
	include($path.$page.".".$true_ext);
	if ($notheme == FALSE)
		include("theme/footer.php");
?>