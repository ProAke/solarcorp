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
$tpl->assignInclude("body", "_tp_index.html");
$tpl->prepare();





$tpl->printToScreen();
