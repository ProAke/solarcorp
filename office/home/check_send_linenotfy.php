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
$tpl->assignInclude("body", "_tp_check_send_linenotfy.html");
$tpl->prepare();



$query = "SELECT * FROM `$linenotify_key` Order by `id` DESC";
$result = $conn->query($query);
//$allpackage = $result->num_rows;
while ($line = $result->fetch_assoc()) {
    //$tpl->newBlock("PACKAGE_CONNECT");
}

$query2 = "SELECT * FROM `$booking` Order by `booking_idx` ASC";
$result2 = $conn->query($query2);
$allbooking = $result2->num_rows;
while ($line2 = $result2->fetch_assoc()) {
    //$tpl->newBlock("BOOKING");
}


$query3 = "SELECT * FROM `$package` Order by `package_idx` DESC";
$result3 = $conn->query($query3);
$allpacakge = $result3->num_rows;
$num_lineconnect = 0;
while ($line3 = $result3->fetch_assoc()) {

    $tpl->newBlock("PACKAGE_CONNECT");
    $tpl->assign("package_idx", $line3['package_idx']);
    $nm_th = $line3['nm_th'];
    if (strlen($nm_th) > 90)
        $nm_th = substr($nm_th, 0, 90) . '...';
    $tpl->assign("package_name", $nm_th);

    $query4 = "SELECT * FROM `$linenotify_key` WHERE `package_idx` = '" . $line3['package_idx'] . "'";
    $result4 = $conn->query($query4);
    if ($line4 = $result4->fetch_assoc()) {
        $tpl->assign("linekey", $line4['line_key']);
        if ($line4['line_key'] != "") {
            $tpl->assign("btn_status", " disabled");
            $tpl->assign("btn_connect", "เชื่อมต่อแล้ว");
            $tpl->assign("status_badge", "bg-success");
            $tpl->assign("status", "สำเร็จ");
            $tpl->assign("edit", " <input type='submit' name='action' value='ล้างข้อมูล'>");
            $num_lineconnect = $num_lineconnect + 1;
        } else {
            $tpl->assign("btn_status", "");
            $tpl->assign("btn_connect", "กดเชื่อมต่อ");
            $tpl->assign("status", "รอดำเนินการ");
        }
    }





    // list package
    // check key package
    // not have sync
    // have check Linekey
    // have linekey  change status connect | button disable

}






$tpl->assign("_ROOT.numPackage", $allpacakge);
$PercentKeyLine = ($num_lineconnect / $allpacakge) * 100;
$PercentKeyLine = number_format($PercentKeyLine, 2);
$tpl->assign("_ROOT.PercentKeyLine", $PercentKeyLine);

$tpl->assign("_ROOT.numBooking", $allbooking);

$tpl->printToScreen();
