<?php
/// Copyright (c) 2004-2008, Needlworks / Tatter Network Foundation
/// All rights reserved. Licensed under the GPL.
/// See the GNU General Public License for more details. (/doc/LICENSE, /doc/COPYRIGHT)
require ROOT . '/lib/includeForBlog.php';
$IV = array(
	'GET' => array(
		'owner' => array('email'),
		'blogid' => array('id')
	) 
);
requireStrictRoute();

$userid=getUserIdByEmail($_GET['owner']);
$blogid=$_GET['blogid'];

$sql = "UPDATE `{$database['prefix']}Teamblog` SET acl = 0 WHERE blogid = ".$blogid." and acl = " . BITWISE_OWNER;
POD::execute($sql);

$acl = POD::queryCell("SELECT acl FROM {$database['prefix']}Teamblog WHERE blogid='$blogid' and userid='$userid'");

if( $acl === null ) { // If there is no ACL, add user into the blog.
	POD::query("INSERT INTO `{$database['prefix']}Teamblog`  
		VALUES('$blogid', '$userid', '".BITWISE_OWNER."', UNIX_TIMESTAMP(), '0')");
}
else {
	$sql = "UPDATE `{$database['prefix']}Teamblog` SET acl = ".BITWISE_OWNER." 
		WHERE blogid = ".$blogid." and userid = " . $userid;
	POD::execute($sql);
}

printRespond(array('error' => 0));
?>
