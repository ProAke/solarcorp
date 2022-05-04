<?php error_reporting(E_ALL ^ E_NOTICE);
/*****************************************************************
Created :20/01/2022
Author : worapot pilabut (pros.ake)
E-mail : worapot.bhi@gmail.com
# Index Check Session
 *****************************************************************/
include_once("../include/config.inc.php");
include_once("../include/function.inc.php");
include_once("../include/class.TemplatePower.inc.php");




if ($_POST['username'] != "" && $_POST['password'] != "") {
	$query = "SELECT * FROM `$tableAdmin` WHERE `USERNAME`='{$_POST['username']}' && `PASSWORD`='{$_POST['password']}'";
	$result = $conn->query($query);

	if ($result->num_rows == 1) {

		$line = $result->fetch_assoc();
		$_SESSION['USERNAME'] = $line['USERNAME'];
		$_SESSION['PASSWORD'] = $line['PASSWORD'];
		$_SESSION['PRIVILEGES'] = $line['PRIVILEGES'];
		$_SESSION['LAST_LOGIN'] = $line['LAST_LOGIN'];
		$_SESSION['THUMB'] = $line['THUMB'];
		$_SESSION['ADMIN_NAME'] = $line['NAME'];
		$_SESSION['ID'] = $line['ID'];

		// Update Last Login
		$query = "UPDATE `$tableAdmin` SET `LAST_LOGIN`=NOW(),`COUNT`=`COUNT`+1 WHERE `USERNAME`='{$_POST['username']}' && `PASSWORD`='{$_POST['password']}'";
		$result = $conn->query($query);

		header("Location: ../home/index.php");
		exit;
	} else {
		$tpl = new TemplatePower("../template/_tp_login.html");
		$tpl->assignInclude("body", "_tp_index.html");
		$tpl->prepare();

		$tpl->newBlock("ERROR");
		$tpl->assign("strMessage", "ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง");
		$tpl->newBlock("FORM");
	}
} else {

	$tpl = new TemplatePower("../template/_tp_login.html");
	$tpl->assignInclude("body", "_tp_index.html");
	$tpl->prepare();
	$tpl->newBlock("FORM");
}

$tpl->printToScreen();
