<?php error_reporting(E_ALL ^ E_NOTICE);

/*
$db_config = array(
	"host" => "localhost",
	"user" => "chumch_db",
	"pass" => "chumchon2019",
	"dbname" => "chumch_db",
	"charset" => "utf8"
);



*/
$db_config = array(
	"host" => "203.146.252.149",
	"user" => "fufudev_ch",
	"pass" => "chumchon201",
	"dbname" => "fufudev_ch",
	"charset" => "utf8"
);



date_default_timezone_set("Asia/Bangkok");
$strDateTime          = date("Y-m-d h:i:s");
$tnow                  = date("h:i:s");

$tableAdmin         = "t_m_linenotify_admin_user";
$tableAdminMenu     = "t_m_linenotify_admin_menu";
$tableMessage       = "t_m_linenotify_message";
$tableSetting		= "t_m_linenotify_setting";
// Table Main Chumchon
$users              = "t_m_user";
$package            = "t_m_package";
$booking            = "t_m_booking";

// Line Notify
$linenotify_check     = "t_m_linenotify_check";
$linenotify_key     = "t_m_linenotify_package_linekey";
$send_log           = "t_m_linenotify_send_log";


session_start();

// Connect MySQL
$conn = @new mysqli($db_config["host"], $db_config["user"], $db_config["pass"], $db_config["dbname"]);
//$conn->set_charset($db_config["charset"]);
