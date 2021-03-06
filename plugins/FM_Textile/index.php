<?php
// Textile formatter for Textcube 1.6
// Library by Threshold state.
// Driver by Jeongkyu Shin. (inureyes@gmail.com)
// 2008.1.21

if(!class_exists('Textile')) require_once 'classTextile.php';

function FM_Textile_format($blogid, $id, $content, $keywords = array(), $useAbsolutePath = true, $bRssMode = false) {
	global $service;
	$textile = new Textile();
	$path = __TEXTCUBE_ATTACH_DIR__."/$blogid";
	$url = "{$service['path']}/attach/$blogid";
	if(!function_exists('FM_TTML_bindAttachments')) { // To reduce the amount of loading code!
		require_once 'ttml.php';
	}
	$view = FM_TTML_bindAttachments($id, $path, $url, $content, $useAbsolutePath, $bRssMode);
	$view = $textile->TextileThis($view);
	$view = FM_TTML_bindTags($id, $view);
	return $view;
}

function FM_Textile_summary($blogid, $id, $content, $keywords = array(), $useAbsolutePath = true) {
	global $blog;
	$view = FM_Textile_format($blogid, $id, $content, $keywords, $useAbsolutePath, true);
    if (!$blog['publishWholeOnRSS']) $view = Utils_Unicode::lessen(removeAllTags(stripHTML($view)), 255);
		return $view;
}
?>
