<?php

// FONCTIONS UTILITAIRES

function sanitize($field) {
	return htmlspecialchars(trim($field));
}

function truncate($str, $limit) {
	return substr($str, 0, $limit);
}

function prettify_website_url($url) {
	if(!empty($url) && substr($url, 0, 4) != 'http') {
		return 'http://'.$url;
	}
	else {
		return $url;
	}
}

function is_filesize_correct($filepath) {
	// Si fichier existant a une taille < 500 Ko
	if(!file_exists($filepath) || filesize($filepath) < 500 * 1024) {
		return true;
	}
	else {
		return false;
	}
}

function is_file_allowed_to_be_created($page_url) {
	// Teste si l'URL donnée correspond à l'hôte de ce script PHP.
	// Position 7 ou 8 correspond au protocole http(s):// dans l'URL donnée.
	$host_pos_in_given_url = strpos($page_url, $_SERVER['HTTP_HOST']);
	if($host_pos_in_given_url != 7 && $host_pos_in_given_url != 8) {
		return false;
	}
	
	// Teste si l'URL donnée correspond à une page réellement existante.
	// Si la page n'existe pas le serveur ne devrait pas retourner un code 200.
	$ch = curl_init($page_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	if($httpcode != 200) {
		return false;
	}
	
	return true;
}

function extract_page_id_from_url($page_url) {
	// http://exemple.net/2020/01/01/bonjour.html  =>  bonjour
	return explode('.', substr($page_url, strrpos($page_url, '/')+1))[0];
}

function add_comment_to_logfile($path, $page_id, $name) {
	$logpath = $_SERVER['DOCUMENT_ROOT'].$path.'/log.txt';
	
	if(file_exists($logpath)) {
		// Si le fichier de log contient + de 100 lignes,
		// alors on retire les 10 premières.
		$loglines = explode("\n", file_get_contents($logpath));
		if(count($loglines) >= 100) {
			$reduced_loglines = array_slice($loglines, 10);
			$reduced_logfile = implode("\n", $reduced_loglines);
			file_put_contents($logpath, $reduced_logfile);
		}
	}
	
	$logline = date("Y-m-d H:i")."\t".$page_id."\t".$name."\n";
	return file_put_contents($logpath, $logline, FILE_APPEND);
}



// SCRIPT PRINCIPAL

// Changer les valeurs pour définir le nombre de caractères max.
$path     = sanitize($_POST['path']);
$page_url = sanitize($_POST['page_url']);
$name     = truncate(sanitize($_POST['name']), 100);
$content  = truncate(sanitize($_POST['content']), 5000);
$website  = prettify_website_url(truncate(sanitize($_POST['website']), 255));

if(empty($path) || empty($name) || empty($content)) {
	echo "error_required_values_missing";
	die();
}
	
$page_id = extract_page_id_from_url($page_url);
$filepath = $_SERVER['DOCUMENT_ROOT'].$path.'/'.$page_id.'.json';

if(file_exists($filepath)) {
	$comments = json_decode(file_get_contents($filepath), true);
}
else {
	if(is_file_allowed_to_be_created($page_url)) {
		$comments = [];
		
	}
	else {
		echo 'error_url_not_linked_to_existing_post';
		die();
	}
}

$comments []= [
	'time' => time(),
	'name' => $name,
	'website' => $website,
	'content' => $content
];

$file = json_encode($comments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

if(is_filesize_correct($filepath)) {
	echo $file;
	file_put_contents($filepath, $file);
	add_comment_to_logfile($path, $page_id, $name);
}
else {
	echo "error_comments_file_too_big";
	add_comment_to_logfile($path, $page_id, '[ERROR] File size exceeded.');
}

