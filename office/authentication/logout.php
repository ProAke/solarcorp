<?php
/*****************************************************************
Created :  5/8/2009
Author : Mr. Khwanchai Kaewyos (LookHin)
E-mail : khwanchai@gmail.com
Website : www.LookHin.com
Blog : www.unzeen.com
Copyright (C) 2005-2010, www.LookHin.com all rights reserved.
*****************************************************************/

include_once("../../include/config.inc.php");
include_once("../../include/function.inc.php");
include_once("../../include/class.inc.php");
include_once("../../include/class.TemplatePower.inc.php");


// Clear Session
$_SESSION = array();

header("Location: index.php");
exit;

?>