<?php error_reporting (E_ALL ^ E_NOTICE);
/*****************************************************************
Created : 7/01/2011
Author : JIE'software 
E-mail : jie@pacificserver.net
Website : www.pacificserver.net
Blog : www.digitalmediathai.com
Copyright (C) 2011, JIE SOFT by Diigtal Media Advance Services Co.,Ltd. all rights reserved.
*****************************************************************/

include_once("../../include/config.inc.php");
include_once("../../include/function.inc.php");
include_once("../../include/class.inc.php");
include_once("../../include/class.TemplatePower.inc.php");
include_once("../authentication/check_login.php");

if($_GET["type"]=="contact"){
	// Update Data
	$arrData = array();
	$arrData['READ'] = "1";	
	$query = sqlCommandUpdate($tableMailContact,$arrData,"`ID`='{$_GET['id']}' ");
	$result = mysql_query($query);
}

elseif($_GET["type"]=="contactdel"){
	// Update Data
	$arrData = array();
	$arrData['DEL'] = "1";	
	$query = sqlCommandUpdate($tableContactUs,$arrData,"`ID`='{$_GET['id']}' ");
	$result = mysql_query($query);
}

elseif($_GET["type"]=="product"){
	// Update Data
	$arrData = array();
	$arrData['READ'] = "1";	
	$query = sqlCommandUpdate($tableMailProduct,$arrData,"`ID`='{$_GET['id']}' ");
	$result = mysql_query($query);
}

elseif($_GET["type"]=="productdel"){
	// Update Data
	$arrData = array();
	$arrData['DEL'] = "1";	
	$query = sqlCommandUpdate($tableMailProduct,$arrData,"`ID`='{$_GET['id']}' ");
	$result = mysql_query($query);
}


?>