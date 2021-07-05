<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

include_once(__DIR__ . '/../../dbconnect.php');

if(!isset($_SESSION['email_logged']) && empty($_SESSION['email_logged'])) {
    header('location:../auth/login.php');
}

$time_now = time();    // lưu thời gian hiện tại
$time_out = 60; // khoảng thời gian chờ để tính một kết nối mới (tính bằng giây)
$ip_address = $_SERVER['REMOTE_ADDR'];    // lưu lại IP của kết nối


// kiểm tra xem thời gian hiện tại so với lần truy cập cuối có lớn hơn khoảng thời gian chờ không
    //- nếu không thì thôi
    //- nếu có thì thêm vào như là một kết nối mới
if (!mysqli_num_rows(mysqli_query($conn,"SELECT `ip_address` FROM `counter` WHERE UNIX_TIMESTAMP(`last_visit`) + $time_out > $time_now AND `ip_address` = '$ip_address'")))
    mysqli_query($conn,"INSERT INTO `counter` VALUES ('$ip_address', NOW())");

// đếm số người đang online
$online = mysqli_num_rows(mysqli_query($conn,"SELECT `ip_address` FROM `counter` WHERE UNIX_TIMESTAMP(`last_visit`) + $time_out > $time_now"));

// đếm số người ghé thăm trong ngày (từ 0h ngày hôm đó đến thời điểm hiện tại)
$day = mysqli_num_rows(mysqli_query($conn,"SELECT `ip_address` FROM `counter` WHERE DAYOFYEAR(`last_visit`) = " . (date('z') + 1) . " AND YEAR(`last_visit`) = " . date('Y')));

// đếm số người ghé thăm ngay hôm qua 
$yesterday = mysqli_num_rows(mysqli_query($conn,"SELECT `ip_address` FROM `counter` WHERE DAYOFYEAR(`last_visit`) = " . (date('z') + 0) . " AND YEAR(`last_visit`) = " . date('Y')));

// đếm số người ghé thăm trong tuần (từ 0h ngày thứ 2 đến thời điểm hiện tại)
$week = mysqli_num_rows(mysqli_query($conn,"SELECT `ip_address` FROM `counter` WHERE WEEKOFYEAR(`last_visit`) = " . date('W') . " AND YEAR(`last_visit`) = " . date('Y')));

// đếm số người ghé thăm tuần trước
$lastweek = mysqli_num_rows(mysqli_query($conn,"SELECT `ip_address` FROM `counter` WHERE WEEKOFYEAR(`last_visit`) = " . (date('W') - 1). " AND YEAR(`last_visit`) = " . date('Y')));

// đếm số người ghé thăm trong tháng
$month = mysqli_num_rows(mysqli_query($conn,"SELECT `ip_address` FROM `counter` WHERE MONTH(`last_visit`) = " . date('n') . " AND YEAR(`last_visit`) = " . date('Y')));

// đếm số người ghé thăm trong năm
$year = mysqli_num_rows(mysqli_query($conn,"SELECT `ip_address` FROM `counter` WHERE YEAR(`last_visit`) = " . date('Y')));

// đếm tổng số người đã ghé thăm
$visit = mysqli_num_rows(mysqli_query($conn,"SELECT `ip_address` FROM `counter`"));


echo $twig->render('backend/pages/dashboard.html.twig', [
    'online' => $online,
    'day' => $day,
    'yesterday' => $yesterday,
    'week' => $week,
    'lastweek' => $lastweek,
    'month' => $month,
    'year' => $year,
    'visit' => $visit,

] );