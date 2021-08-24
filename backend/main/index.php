<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

// Truy vấn database để lấy danh sách
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');

<<<<<<< HEAD
if(!isset($_SESSION['email_logged']) && empty($_SESSION['email_logged']) ) {
    header('location:../auth/login.php');
=======
if(!isset($_SESSION['email_logged']) && empty($_SESSION['email_logged'])) {
    header('location:index.php');
>>>>>>> 20867eaa43e4cff75385aa59e336516d6c7a1231
}

// $pana = mysqli_query($conn, 'select count(ID) as total from main');
//         $row = mysqli_fetch_assoc($pana);
//         $total_records = $row['total'];
//  //print($total_records);die;
//         // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
//         $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
//         $limit = 5;
 
//         // BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
//         // tổng số trang
//         $total_page = ceil($total_records / $limit);
 
//         // Giới hạn current_page trong khoảng 1 đến total_page
//         if ($current_page > $total_page){
//             $current_page = $total_page;
//         }
//         else if ($current_page < 1){
//             $current_page = 1;
//         }
 
//         // Tìm Start
//         $start = ($current_page - 1) * $limit;

// // 2. Chuẩn bị câu truy vấn $sql
// $sql = "select * from `main` LIMIT $start, $limit ";
$sql = "select * from `main`";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu
$result = mysqli_query($conn, $sql);

// 4. Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
// Thông thường, chúng ta sẽ sử dụng vòng lặp while để duyệt danh sách các dòng dữ liệu được SELECT
// Ta sẽ tạo 1 mảng array để chứa các dữ liệu được trả về

$data = [];
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $data[] = array(
        'ID' => $row['ID'],
        'Title' => $row['Title'],
        'LinkTitle' => $row['LinkTitle'],
        'Content' => $row['Content'],
        'LinkSource' => $row['LinkSource'],
        'NameSource' => $row['NameSource'],
        'Picture' => $row['Picture'],
        'Create_at' => $row['Create_at'],
    );
}

echo $twig->render('backend/main/index.html.twig', 
[
    'main' => $data,
    //'current_page' => $current_page,
    //'total_page' => $total_page,

] );