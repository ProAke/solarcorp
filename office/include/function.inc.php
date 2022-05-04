<?php error_reporting(E_ALL ^ E_NOTICE);
/*****************************************************************
Created :01/10/2021
Author : worapot bhilarbutra (pros.ake)
E-mail : worapot.bhi@gmail.com
Website : https://www.vpslive.com
Copyright (C) 2021-2025, VPS Live Digital togethers all rights reserved.
 *****************************************************************/



/*
tb_page
*/

// Check User /////////////////////////////
function CheckLogin($user = "")
{
	global $tpl;
	if ($user == "") {
		$tpl->newBlock("LOGIN");
	} else {
		$tpl->newBlock("LOGON");
		$tpl->assign("fname", $_SESSION['sfname']);
		$tpl->assign("lname", $_SESSION['slname']);
	}
}








/*
# Function sqlInsert
# Example

$arrData = array();
$arrData['A'] = "aaaa";
$arrData['B'] = "bbbb";
$arrData['C'] = "cccc";
sqlCommandInsert("table",$arrData);
*/


function sqlCommandInsert($strTableName, $arrFieldValue)
{

	$arrFieldTmp = "";
	$arrValueTmp = "";

	$strFieldTmp = "";
	$strValueTmp = "";

	foreach ($arrFieldValue as $key => $value) {
		$arrFieldTmp[] = "`$key`";
		$arrValueTmp[] = "'$value'";
	}

	$strFieldTmp = implode(",", $arrFieldTmp);
	$strValueTmp = implode(",", $arrValueTmp);

	$strSql = "INSERT INTO `$strTableName`($strFieldTmp) VALUES($strValueTmp)";

	return $strSql;
}

/*
# Function sqlCommandUpdate
# Example

$arrData = array();
$arrData['A'] = "aaaa";
$arrData['B'] = "bbbb";
$arrData['C'] = "cccc";
sqlCommandUpdate("table",$arrData,"`ID`='1'");
*/

function sqlCommandUpdate($strTableName, $arrFieldValue, $strWhere)
{

	$arrFieldValueTmp = "";
	$strFieldValueTmp = "";

	foreach ($arrFieldValue as $key => $value) {
		$arrFieldValueTmp[] = "`$key`='$value'";
	}

	$strFieldValueTmp = implode(",", $arrFieldValueTmp);

	$strSql = "UPDATE `$strTableName` SET $strFieldValueTmp WHERE $strWhere";

	return $strSql;
}




/*
# Function ThaiDate Log พร้อมด้วยเวลา

*/
function ThaiToday($strDateTime, $tnow)
{
	$arrThaiMonth = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	list($strYMD, $strTime) = explode(" ", $strDateTime);
	list($intY, $intM, $intD) = explode("-", $strYMD);
	$intY = $intY + 543;
	$strM = $arrThaiMonth[$intM * 1];
	$intD = $intD * 1;
	$TodayThai = " " . $intD . " " . $strM . " " . $intY . " เวลา :" . $tnow;
	return $TodayThai;
}


/*
รอแก้ไขเพราะส่งค่า $booTime มาแล้วไม่ทำงาน 
# Function ThaiDateShort
# Example

ThaiDateShort("YYYY-mm-dd hh:ii:ss",false);
*/

function ThaiDateShort($strDateTime, $booTime)
{
	$arrThaiMonth = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ษ.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");

	list($strYMD, $strTime) = explode(" ", $strDateTime);
	list($intY, $intM, $intD) = explode("-", $strYMD);

	$intY = $intY + 543;
	$strM = $arrThaiMonth[$intM * 1];
	$intD = $intD * 1;

	if ($booTime) $strShowTime = $strTime;

	return "$intD $strM $intY $strShowTime";
}

/*
# Function EngDateLong
# Example

EngDateLong("YYYY-mm-dd hh:ii:ss",false);
*/



function EngDateLong($strDateTime, $booTime)
{
	$arrThaiMonth = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

	list($strYMD, $strTime) = explode(" ", $strDateTime);
	list($intY, $intM, $intD) = explode("-", $strYMD);

	$intY = $intY;
	$strM = $arrThaiMonth[$intM * 1];
	$intD = $intD * 1;

	if ($booTime) $strShowTime = $strTime;

	return "$intD $strM $intY $strShowTime";
}

/*
# Function EngDateShort
# Example

EngDateShort("YYYY-mm-dd hh:ii:ss",false);
*/

function EngDateShort($strDateTime, $booTime)
{
	$arrThaiMonth = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

	list($strYMD, $strTime) = explode(" ", $strDateTime);
	list($intY, $intM, $intD) = explode("-", $strYMD);

	$intY = $intY;
	$strM = $arrThaiMonth[$intM * 1];
	$intD = $intD * 1;

	if ($booTime) $strShowTime = $strTime;

	return "$intD $strM $intY $strShowTime";
}
