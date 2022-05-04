<?php error_reporting(E_ALL ^ E_NOTICE);
/*****************************************************************
Created :20/01/2022
Author : worapot pilabut (pros.ake)
E-mail : worapot.bhi@gmail.com
# Check Package Change
 *****************************************************************/
include_once("../include/config.inc.php");
include_once("../include/function.inc.php");
include_once("../include/class.TemplatePower.inc.php");
include_once("../authentication/check_login.php");

$tpl = new TemplatePower("../template/_tp_main.html");
$tpl->assignInclude("body", "_tp_change_password.html");
$tpl->prepare();

// Menu
GetMenuAdmin();
$page_lag=$_GET['page_lag'];
if(!isset($_GET['page_lag'])  && !isset($_SESSION['page_lag']) || $_GET['page_lag']=="" && !isset($_SESSION['page_lag']))  $page_lag="1";
if(!isset($_GET['page_lag'])  && isset($_SESSION['page_lag']) || $_GET['page_lag']=="" && isset($_SESSION['page_lag']))  $page_lag=$_SESSION['page_lag'];
GetMenuLAG($page_lag,$_GET['key'],$_GET['group'],$_GET['id']);

if($_POST['new_pass1'] != "" && $_POST['new_pass1'] == $_POST['new_pass2']){
	// Update Data
	$arrData = array();
	$arrData['PASSWORD'] = $_POST['new_pass1'];
	
	$query = sqlCommandUpdate($tableAdmin,$arrData,"`USERNAME`='{$_SESSION['USERNAME']}'");
	$result = mysql_query($query);

	$_SESSION["PASSWORD"] = $_POST['new_pass1'];

	// Show Message
	$tpl->newBlock("SAVE");
	$tpl->assign("strMessage",GetMessage(4));

}else{
	// Show Form
	$tpl->newBlock("FORM");
}



$tpl->printToScreen();
