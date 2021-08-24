<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__ . '/../../bootstrap.php';

// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__ . '/../../dbconnect.php');

// Đã đăng nhập rồi -> điều hướng về trang chủ
<<<<<<< HEAD
if(isset($_SESSION['email_logged']) && !empty($_SESSION['email_logged']) ) {
    header('location:../pages/dashboard.php');
=======
if(isset($_SESSION['email_logged']) && !empty($_SESSION['email_logged'])) {
    // echo 'Bạn đã đăng nhập rồi. <a href="/havanlinh.tech/backend/">Bấm vào đây để quay về trang chủ.</a>';
>>>>>>> 20867eaa43e4cff75385aa59e336516d6c7a1231
}
else {
    if(isset($_POST['btnLogin'])) {
        // Kiểm tra đăng nhập...
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = md5($password);
        // Câu lệnh SELECT
        $sqlSelect = <<<EOT
        SELECT *
        FROM khachhang kh
        WHERE kh.kh_email = '$email' AND kh.kh_matkhau = '$password';
EOT;

        // Thực thi SELECT
        $result = mysqli_query($conn, $sqlSelect);

        // Sử dụng hàm `mysqli_num_rows()` để đếm số dòng SELECT được
        // Nếu có bất kỳ dòng dữ liệu nào SELECT được <-> Người dùng có tồn tại và đã đúng thông tin USERNAME, PASSWORD
        if (mysqli_num_rows($result) > 0) {
            echo 'Đăng nhập thành công!';
            // redirect đi đâu đó...
            header('location:../main/index.php');
            // Lưu thông tin Email user đã đăng nhập
            $_SESSION['email_logged'] = $email;

        } else {
            echo 'Đăng nhập thất bại!';
        }
    } else {
        echo $twig->render('backend/auth/login.html.twig');
    }
}
?>