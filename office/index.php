<?php error_reporting(E_ALL ^ E_NOTICE);
/*****************************************************************
Created :20/01/2022
Author : worapot pilabut (pros.ake)
E-mail : worapot.bhi@gmail.com
# Index Check Session
 *****************************************************************/
include_once("include/config.inc.php");
include_once("include/function.inc.php");
include_once("include/class.TemplatePower.inc.php");


$query = "SELECT * FROM `$tableAdmin` WHERE `USERNAME`='{$_SESSION['USERNAME']}' && `PASSWORD`='{$_SESSION['PASSWORD']}'";
$result = $conn->query($query);
if($result->num_rows == 0){
	header("Location: authentication/index.php");
	exit;
}else{
	header("Location: home/index.php");
	exit;

}
