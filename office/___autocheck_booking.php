// Check booking_idx last send
$query1 = "SELECT * FROM `$send_log` Order by `id` desc limit 1";
$result1 = $conn->query($query1);
while ($line1 = $result1->fetch_assoc()) {
$lastbooking_idx = $line1['booking_idx'];
}

// Connect to booking | t_m_booking
$query2 = "SELECT * FROM `$booking` WHERE `booking_idx`>'" . $lastbooking_idx . "' Order by `booking_idx` ASC";
$result2 = $conn->query($query2);
while ($line = $result2->fetch_assoc()) {

//

$booking_date = $line['booking_date'];
$booking_idx = $line['booking_idx'];
$package_idx = $line['package_idx'];
$package_nm_thai = $line['package_nm_thai'];
$booking_start = $line['booking_start'];
$booking_end = $line['booking_end'];
$booking_num = $line['booking_num'];
// Select linenotify_key from t_m_linenotify
$query3 = "SELECT * FROM `$linenotify_key` WHERE `package_idx`='" . $line['package_idx'] . "'";
$result3 = $conn->query($query3);
if ($line3 = $result3->fetch_assoc()) {
// send to line notify
$Token = $line3['line_key'];
} else {
$Token = "znSs1L0W3Cld44Rp66OgZf0ewylJrR7v3U6Z3Ng72g5";
// ส่วนกลาง
}

$message = ">
------------------
วันที่จอง $booking_date
รหัสการจอง $booking_idx
แพ็จเกจ : $package_idx : $package_nm_th
จองตั้งแต่ $booking_start - $booking_expired
จำนวนผู้เข้าพัก $booking_num
ข้อมูลผู้จอง : $nm_th เบอร์โทร $mobile
Email $mail
หมายเหตุอื่นๆ : $desc_th
------------------
ส่งโดย : Chomchon Line Notify เมื่อ $strDateTime;
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
// insert to send_log /////////////////////////////////
$arrData = array();
$arrData['booking_idx'] = $line['booking_idx'];
$arrData['package_idx'] = $line['package_idx'];
$arrData['line_key'] = $Token;
$arrData['dep_idx'] = $line['dep_idx'];
$arrData['cc_idx'] = $line['cc_idx'];
$arrData['package_nm_th'] = $line['package_nm_th'];
$arrData['package_owner'] = $line['package_owner'];
$arrData['booking_num'] = $line['booking_num'];
$arrData['booking_date'] = $line['booking_date'];
$arrData['booking_start'] = $line['booking_start'];
$arrData['booking_expired'] = $line['booking_expired'];
$arrData['booking_status'] = $line['booking_status'];
$arrData['desc_th'] = $line['desc_th'];
$arrData['nm_th'] = $line['nm_th'];
$arrData['email'] = $line['email'];
$arrData['mobile'] = $line['mobile'];
$arrData['send_notify_tdate'] = $strDateTime;
foreach ($arrData as $key => $value) {
$arrFieldTmp[] = "`$key`";
$arrValueTmp[] = "'$value'";
}
$strFieldTmp = implode(",", $arrFieldTmp);
$strValueTmp = implode(",", $arrValueTmp);
$query = "INSERT INTO `$send_log`($strFieldTmp) VALUES($strValueTmp)";
echo $query . "<br>";
$result = $conn->query($query);
///////////////////////////////////////////////////////

}
curl_close($chOne);
}





// Update Status at t_m_booking Confirm : Cancel