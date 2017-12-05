<?php

function PurifyString($str) {
	$str = trim(htmlentities($str));
	$str = str_replace("\x1F", "", $str);
	$str = str_replace("\x1E", "", $str);
	$str = str_replace("\n", " ", $str);
	$str = str_replace("\r", " ", $str);
	return $str;
}

function AddComment($pseudo, $website, $text, $fileurl, $sizelimit) {
	$pseudo = PurifyString($pseudo);
	$website = PurifyString($website);
	$text = PurifyString($text);
	if($pseudo != '' && $text != '' && strlen($text) <= $sizelimit) {
		$comment = uniqid()."\x1F\n";
		$comment .= $pseudo."\x1F\n";
		$comment .= $website."\x1F\n";
		$comment .= time()."\x1F\n";
		$comment .= $text."\n\x1E\n";
		file_put_contents($fileurl, $comment, FILE_APPEND);
	}
}

function ReadComments($fileurl, $dateformat) {
	$html = "<div class='comments'>\n";
	if(!file_exists($fileurl)) {
		$html .= "	<div class='nocomment'>No comment.</div>\n";
	}
	else {
		$file = file_get_contents($fileurl);
		$comments = explode("\n\x1E\n", $file, -1);
		for($i=0 ; $i<sizeof($comments) ; $i++)
			$comments[$i] = explode("\x1F\n", $comments[$i]);
		foreach($comments as $c) {
			$date = date($dateformat, $c[3]);
			$html .= "	<div class='comment' id='$c[0]'>\n";
			$html .= "		<div class='cominfo'>\n";
			$html .= "			<span class='author'>$c[1]</span>\n";
			$html .= "			<span class='website'>$c[2]</span>\n";
			$html .= "			<span class='date'>$date</span>\n";
			$html .= "		</div>\n";
			$html .= "		<p>$c[4]</p>\n";
			$html .= "	</div>\n";
		}
	}
	$html .= "</div>\n";
	$html .= "<form class='newcomment' method='POST'>\n";
	$html .= "	<input type='text' placeholder='Name'
                 name='nanocomments_pseudo'>\n";
	$html .= "	<input type='text' placeholder='Website'
	             name='nanocomments_website'>\n";
	$html .= "	<textarea name='nanocomments_text'></textarea>\n";
	$html .= "<button>Send</button>";
	$html .= "</form>\n";		
	return $html;
}

if(!isset($nanocomments_dateformat))
	$nanocomments_dateformat = "Y-m-d H:i:s";

if(!isset($nanocomments_sizelimit))
	$nanocomments_sizelimit = 1000;

if(isset($_POST['nanocomments_pseudo']) &&
   isset($_POST['nanocomments_website']) &&
   isset($_POST['nanocomments_text'])) {
	AddComment($_POST['nanocomments_pseudo'],
	           $_POST['nanocomments_website'],
	           $_POST['nanocomments_text'],
	           $nanocomments_sizelimit);
}

echo ReadComments($nanocomments_dir."/".$nanocomments_pageid,
                  $nanocomments_dateformat);

?>

