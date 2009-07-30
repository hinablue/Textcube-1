<?php
/// Copyright (c) 2004-2009, Needlworks / Tatter Network Foundation
/// All rights reserved. Licensed under the GPL.
/// See the GNU General Public License for more details. (/doc/LICENSE, /doc/COPYRIGHT)
$IV = array(
	'POST' => array(
		'id' => array ('int','min'=>1)
	)
);
require ROOT . '/library/preprocessor.php';
requireStrictRoute();

$line = Line::getInstance();
$line->reset();
$line->setFilter(array('blogid','equals',getBlogId()));
$line->setFilter(array('id','equals',$_POST['id']));

if($line->delete()) {
	respond::ResultPage(0);
} else {
	respond::ResultPage(-1);
}
?>