<?php error_reporting(E_ALL ^ E_NOTICE);
/*****************************************************************
Created :20/01/2022
Author : worapot pilabut (pros.ake)
E-mail : worapot.bhi@gmail.com
# Index Check Session
 *****************************************************************/
include_once("../include/config.inc.php");
include_once("../include/function.inc.php");




if ($_POST['action'] == 'กดเชื่อมต่อ') {

    $sql = "UPDATE `$linenotify_key` SET `line_key`='" . $_POST['linekey'] . "' WHERE `package_idx`=" . $_POST['package_idx'];
    $conn->query($sql);
    header("Location: index.php");
    exit;
} else {
    $sql = "UPDATE `$linenotify_key` SET `line_key`='' WHERE `package_idx`=" . $_POST['package_idx'];
    $conn->query($sql);
    header("Location: index.php");
    exit;
}
