<?php error_reporting(E_ALL ^ E_NOTICE);
/*****************************************************************
Created :20/01/2022
Author : worapot pilabut (pros.ake)
E-mail : worapot.bhi@gmail.com
# Check Package Change
 *****************************************************************/
include_once("include/config.inc.php");
include_once("include/function.inc.php");
include_once("include/class.TemplatePower.inc.php");




// ตรวจสอบจองใหม่
$query1 = "SELECT * FROM `$linenotify_check` Order by `id` desc limit 1";
$result1 = $conn->query($query1);
$num = $result1->num_rows;

if ($num == 1) {
    $line1 = $result1->fetch_assoc();
    $lastbooking_idx = $line1['booking_idx'];
} else {
    //sync database ครั้งแรก
    $query2 = "SELECT * FROM `$booking` Order by `booking_idx` ASC";
    $result2 = $conn->query($query2);
    $num2 = $result2->num_rows;
    while ($line2 = $result2->fetch_assoc()) {
        // Sync Database t_m_booking to t_m_linenotify_check
        reset($arrData);
        $query3 = "";
        $key = "";
        $value = "";
        $strFieldTmp = "";
        $strValueTmp = "";

        $arrData = array();
        $arrData['booking_idx'] = $line2['booking_idx'];
        $arrData['package_idx'] = $line2['package_idx'];
        $arrData['booking_num'] = $line2['booking_num'];
        $arrData['booking_status'] = $line2['booking_status']; // 'booking','confirm','cancel','start','finished'
        $arrData['status'] = $line2['status']; // s=show , h=hide


        $query3 = "INSERT INTO `$linenotify_check`(`booking_idx`,`package_idx`,`booking_num`,`booking_status`,`status`) VALUES('" . $line2['booking_idx'] . "',
        '" . $line2['package_idx'] . "',
        '" . $line2['booking_num'] . "',
        '" . $line2['booking_status'] . "',
        '" . $line2['status'] . "')";
        $result3 = $conn->query($query3);
        //echo "Message:200";        

    }
}

// ตรวจสอบการจองใหม่
$query4 = "SELECT * FROM `$booking` WHERE `booking_idx`>'" . $lastbooking_idx . "' Order by `booking_idx` ASC";
$result4 = $conn->query($query4);
while ($line4 = $result4->fetch_assoc()) {

    // Select Token 
    $query9 = "SELECT * FROM `$linenotify_key` WHERE `package_idx`='" . $line4['package_idx'] . "'";
    $result9 = $conn->query($query9);
    $num9 = $result9->num_rows;

    if ($num9 > 0) {
        $line9 = $result9->fetch_assoc();
        $Token = $line9['line_key'];
        if ($Token == "") {
            $Token = "znSs1L0W3Cld44Rp66OgZf0ewylJrR7v3U6Z3Ng72g5";
        }
    }

    // อัพเดท $linenotify_check
    $query10 = "INSERT INTO `$linenotify_check`(`booking_idx`,`package_idx`,`booking_num`,`booking_status`,`status`) VALUES('" . $line4['booking_idx'] . "',
    '" . $line4['package_idx'] . "',
    '" . $line4['booking_num'] . "',
    '" . $line4['booking_status'] . "',
    '" . $line4['status'] . "')";
    $result10 = $conn->query($query10);


    // อัพเดท $linenotify_log
    $arrData = array();
    $arrData['booking_idx'] = $line4['booking_idx'];
    $arrData['package_idx'] = $line4['package_idx'];
    $arrData['line_key'] = $Token;
    $arrData['dep_idx'] = $line4['dep_idx'];
    $arrData['cc_idx'] = $line4['cc_idx'];
    $arrData['package_nm_th'] = $line4['package_nm_th'];
    $arrData['package_owner'] = $line4['package_owner'];
    $arrData['booking_num'] = $line4['booking_num'];
    $arrData['booking_date'] = $line4['booking_date'];
    $arrData['booking_start'] = $line4['booking_start'];
    $arrData['booking_expired'] = $line4['booking_expired'];
    $arrData['booking_status'] = $line4['booking_status'];
    $arrData['desc_th'] = $line4['desc_th'];
    $arrData['nm_th'] = $line4['nm_th'];
    $arrData['email'] = $line4['email'];
    $arrData['mobile'] = $line4['mobile'];
    $arrData['send_notify_tdate'] = $strDateTime;
    foreach ($arrData as $key => $value) {
        $arrFieldTmp[] = "`$key`";
        $arrValueTmp[] = "'$value'";
    }
    $strFieldTmp = implode(",", $arrFieldTmp);
    $strValueTmp = implode(",", $arrValueTmp);
    $query10 = "INSERT INTO `$send_log`($strFieldTmp) VALUES($strValueTmp)";
    echo $query10 . "<br>";
    $result10 = $conn->query($query10);









    // แจ้งเตือนการจองใหม่
    // Send Line Alert
    $message = ">
    ------
    จองใหม่
    -------------------
    วันที่จอง $line4[booking_date]
    รหัสการจอง $line4[booking_idx]
    แพ็จเกจ : $line4[package_nm_th]
    จองตั้งแต่ $line4[booking_start] -$line4[booking_expired]
    จำนวนผู้เข้าพัก $line4[booking_num]
    ข้อมูลผู้จอง : $line6[nm_th] เบอร์โทร $line4[mobile]
    Email $line4[mail]
    หมายเหตุอื่นๆ : $line4[desc_th]
    ------------------
    ส่งโดย : Chomchon Line Notify เมื่อ $strDateTime
    ";
    // Select TOKEN from USER DATABASE    

    $lineapi = $Token; // ใส่ token key ที่ได้มา
    $mms = trim($message); // ข้อความที่ต้องการส่ง
    date_default_timezone_set("Asia/Bangkok");
    $chOne = curl_init();
    curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    // SSL USE
    curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
    //POST
    curl_setopt($chOne, CURLOPT_POST, 1);
    curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $mms);
    //curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
    $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $lineapi . '',);
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($chOne);
    //Check error
    if (curl_error($chOne)) {
        echo 'error:' . curl_error($chOne);
    } else {
        $result_ = json_decode($result, true);
        // อัพเดท Log
    }
    curl_close($chOne);







    // อัพเดท Log

}
// ตรวจสอบการเปลี่ยนแปลงสถานะ
$query5 = "SELECT * FROM `$linenotify_check` Order by `id` asc";
$result5 = $conn->query($query5);
while ($line5 = $result5->fetch_assoc()) {
    // ตรวจสอบการเปลี่ยนแปลงสถานะ
    $query6 = "SELECT * FROM `$booking` WHERE `booking_idx`='" . $line5['booking_idx'] . "'";
    $result6 = $conn->query($query6);
    $line6 = $result6->fetch_assoc();
    if ($line5['booking_status'] != $line6['booking_status']) {
        // อัพเดท $linenotify_check
        $query7 = "UPDATE `$linenotify_check` SET `booking_status`='" . $line6['booking_status'] . "' WHERE `booking_idx`='" . $line5['booking_idx'] . "'";
        $result7 = $conn->query($query7);

        //$Token = "znSs1L0W3Cld44Rp66OgZf0ewylJrR7v3U6Z3Ng72g5"; // ส่วนกลาง
        // Select Token 
        $query8 = "SELECT * FROM `$linenotify_key` WHERE `package_idx`='" . $line6['package_idx'] . "'";
        $result8 = $conn->query($query8);
        $num8 = $result8->num_rows;

        if ($num8 > 0) {
            $line8 = $result8->fetch_assoc();
            $Token = $line8['line_key'];
            if ($Token == "") {
                $Token = "znSs1L0W3Cld44Rp66OgZf0ewylJrR7v3U6Z3Ng72g5";
            }
        }
        // Send Line Alert
        $message = ">
        ------------------
        เปลี่ยนสถานะ : $line6[booking_status]
        -------------------
        วันที่จอง $line6[booking_date]
        รหัสการจอง $line6[booking_idx]
        แพ็จเกจ : $line6[package_nm_th]
        จองตั้งแต่ $line6[booking_start] -$line6[booking_expired]
        จำนวนผู้เข้าพัก $line6[booking_num]
        ข้อมูลผู้จอง : $line6[nm_th] เบอร์โทร $line6[mobile]
        Email $line6[mail]
        หมายเหตุอื่นๆ : $line6[desc_th]
        ------------------
        ส่งโดย : Chomchon Line Notify เมื่อ $strDateTime
        ";
        // Select TOKEN from USER DATABASE    

        $lineapi = $Token; // ใส่ token key ที่ได้มา
        $mms = trim($message); // ข้อความที่ต้องการส่ง
        date_default_timezone_set("Asia/Bangkok");
        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        // SSL USE
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        //POST
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $mms);
        //curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $lineapi . '',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);
        //Check error
        if (curl_error($chOne)) {
            echo 'error:' . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            // อัพเดท Log
        }
        curl_close($chOne);
    }
}
