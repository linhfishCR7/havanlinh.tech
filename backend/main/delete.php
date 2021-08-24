<?php
// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');
<<<<<<< HEAD
if(!isset($_SESSION['email_logged']) && empty($_SESSION['email_logged'])) {
    header('location:../auth/login.php');
}
=======

>>>>>>> 20867eaa43e4cff75385aa59e336516d6c7a1231
$ID = $_POST['ID'];
$sqlSelect = "SELECT * FROM `main` WHERE ID=$ID;";

// Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record cần update
$resultSelect = mysqli_query($conn, $sqlSelect);
$mainRow = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC); // 1 record

// 2. Chuẩn bị câu truy vấn $sql
// Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
// $ID = $_POST['ID'];
$sql = "DELETE FROM `main` WHERE ID=" . $ID;

// 3. Thực thi câu lệnh DELETE
$result = mysqli_query($conn, $sql);

$upload_dir = "./../../assets/uploads/";

$old_file = $upload_dir.$mainRow['Picture'];
if(file_exists($old_file)) {
    unlink($old_file);
}
// 4. Đóng kết nối
mysqli_close($conn);
    
// Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
header('location:index.php');
