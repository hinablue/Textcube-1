<?php
// POD : PHP Ontology(or Object-Oriented)-based Data model/framework
// Version 0.19a
// By Jeongkyu Shin (jkshin@ncsl.postech.ac.kr)
// Created       : 2007.11.30
// Last modified : 2007.12.21

// (C) 2007 Jeongkyu Shin. All rights reserved. 
// Licensed under the GPL.
// See the GNU General Public License for more details. (/LICENSE, /COPYRIGHT)
// For more information, visit http://pod.nubimaru.com

// NOTE : THIS FILE CONTAINS LEGACY ROUTINE OF DBQuery ONLY.
//        FOR USING FULL FUNCTION, INCLUDE POD.Core.php instead.

require_once 'Needlworks.Database.php';

// Bypass variables are supported. ($_pod_setting);
class POD extends DBQuery {
	/** Pre-definition **/
	// 'var' is deprecated from PHP5.
/*	var $_domain;
	var $_prototype;
	var $_type;
	var $_version;
	var $_isProducedBy;
	var $_tablePrefix;
	var $_numberOfClasses;
	var $_classPointer;
	var $_foreignKeyId;
	var $_isCheckout;
	var $_DBMS;*/

	/** Initialization **/
	function POD($domain = null, $type = null, $prefix = '') {
		global $_pod_setting;
		if($domain != null) $this->_domain = $domain;
		else if(isset($this->domain)) $this->_domain = $this->domain;
		if($type != null) {$this->_prototype = $this->_type = $type;}
		else if(isset($this->prototype)) {$this->_prototype = $this->_type = $this->prototype;}
		if(!empty($prefix)) $this->_tablePrefix = $prefix;
		else if(isset($_pod_setting['tablePrefix'])) $this->_tablePrefix = $_pod_setting['tablePrefix'];
		else $this->_tablePrefix = '';
		if(isset($_pod_setting['DBMS'])) $this->_DBMS = $_pod_setting['DBMS'];
		$this->reset();
		// Should check bind state!
	}

	/** Additional features for Textcube **/
	/** NOTICE : PARTS BELOW EXTENDS DBQuery Class WHICH IS THE BASE OF POD
	             AND WORKS ONLY WITH 'PageCache' Component in Textcube **/
	function queryWithDBCache($query, $prefix = null, $type = 'both', $count = -1) {
//		requireComponent('Needlworks.Cache.PageCache');
		$cache = new queryCache($query, $prefix);
		if(!$cache->load()) {
			$cache->contents = POD::query($query, $type, $count);
			$cache->update();
		}
		return $cache->contents;
	}
	function queryAllWithDBCache($query, $prefix = null, $type = 'both', $count = -1) {
//		requireComponent('Needlworks.Cache.PageCache');
		$cache = new queryCache($query, $prefix);
		if(!$cache->load()) {
			$cache->contents = POD::queryAllWithCache($query, $type, $count);
			$cache->update();
		}
		return $cache->contents;
	}
	function queryRowWithDBCache($query, $prefix = null, $type = 'both', $count = -1) {
//		requireComponent('Needlworks.Cache.PageCache');
		$cache = new queryCache($query, $prefix);
		if(!$cache->load()) {
			$cache->contents = POD::queryRow($query, $type, $count);
			$cache->update();
		}
		return $cache->contents;
	}
	function queryColumnWithDBCache($query, $prefix = null, $type = MYSQL_BOTH, $count = -1) {
//		requireComponent('Needlworks.Cache.PageCache');
		$cache = new queryCache($query, $prefix);
		if(!$cache->load()) {
			$cache->contents = POD::queryColumn($query, $type, $count);
			$cache->update();
		}
		return $cache->contents;
	}
}
?>
