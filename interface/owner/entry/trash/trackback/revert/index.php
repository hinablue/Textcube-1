<?php
/// Copyright (c) 2004-2007, Needlworks / Tatter Network Foundation
/// All rights reserved. Licensed under the GPL.
/// See the GNU General Public License for more details. (/doc/LICENSE, /doc/COPYRIGHT)
require ROOT . '/lib/includeForBlogOwner.php';
requireModel("blog.trackback");

if(isset($suri['id'])) {
	$isAjaxRequest = checkAjaxRequest();

	if (revertTrackback($blogid, $suri['id']) !== true)
		$isAjaxRequest ? respondResultPage(0) : header("Location: ".$_SERVER['HTTP_REFERER']);
	else
		$isAjaxRequest ? respondResultPage(-1) : header("Location: ".$_SERVER['HTTP_REFERER']);
} else {
	$targets = explode('~*_)', $_POST['targets']);
	foreach($targets as $target) {
		if ($target == '')
			continue;
		revertTrackback($blogid, $target);
	}
	respondResultPage(0);
}
?>
