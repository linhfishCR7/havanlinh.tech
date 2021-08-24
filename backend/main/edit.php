<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');
<<<<<<< HEAD
if(!isset($_SESSION['email_logged']) && empty($_SESSION['email_logged'])) {
    header('location:../auth/login.php');
}
=======

>>>>>>> 20867eaa43e4cff75385aa59e336516d6c7a1231
// 2. Chuẩn bị câu truy vấn $sqlSelect, lấy dữ liệu ban đầu của record cần update
// Lấy giá trị khóa chính được truyền theo dạng QueryString Parameter key1=value1&key2=value2...
$ID = $_GET['ID'];
$sqlSelect = "SELECT * FROM `main` WHERE ID=$ID;";

// 3. Thực thi câu truy vấn SQL để lấy về dữ liệu ban đầu của record cần update
$resultSelect = mysqli_query($conn, $sqlSelect);
$mainRow = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC); // 1 record

// 4. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
if(isset($_POST['btnSave'])) 
{
    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
    $Title = $_POST['Title'];
    $LinkTitle = $_POST['LinkTitle'];
    $Content = $_POST['Content'];
    $LinkSource = $_POST['LinkSource'];
    $NameSource = $_POST['NameSource'];
    //$Picture = $_POST['Picture'];
    $Create_at = $_POST['Create_at'];
    // Lấy dữ liệu người dùng hiệu chỉnh gởi từ REQUEST POST
    $ID = $_POST['ID'];

    // Nếu người dùng có chọn file để upload
    if (isset($_FILES['Picture']))
    {
        // Đường dẫn để chứa thư mục upload trên ứng dụng web của chúng ta. Các bạn có thể tùy chỉnh theo ý các bạn.
        // Ví dụ: các file upload sẽ được lưu vào thư mục ../../assets/uploads
        $upload_dir = "./../../assets/uploads/";

        // Đối với mỗi file, sẽ có các thuộc tính như sau:
        // $_FILES['hsp_tentaptin']['name']     : Tên của file chúng ta upload
        // $_FILES['hsp_tentaptin']['type']     : Kiểu file mà chúng ta upload (hình ảnh, word, excel, pdf, txt, ...)
        // $_FILES['hsp_tentaptin']['tmp_name'] : Đường dẫn đến file tạm trên web server
        // $_FILES['hsp_tentaptin']['error']    : Trạng thái của file chúng ta upload, 0 => không có lỗi
        // $_FILES['hsp_tentaptin']['size']     : Kích thước của file chúng ta upload

        // Nếu file upload bị lỗi, tức là thuộc tính error > 0
        if ($_FILES['Picture']['error'] > 0)
        {
            header('location:../errors/500.php');
        }
        else{
            
            $hsp_tentaptin = $_FILES['Picture']['name'];
            $Picture = date('YmdHis') . '_' .$hsp_tentaptin;
            move_uploaded_file($_FILES['Picture']['tmp_name'], $upload_dir.$Picture);
            
            // Xóa file cũ để tránh rác trong thư mục UPLOADS
            $old_file = $upload_dir.$mainRow['Picture'];
            if(file_exists($old_file)) {
                unlink($old_file);
            }
        }
    }
    // Câu lệnh UPDATE
    $sql = "UPDATE `main` SET Title='$Title', LinkTitle='$LinkTitle',Content='$Content', LinkSource='$LinkSource', NameSource='$NameSource', Picture='$Picture', Create_at='$Create_at' WHERE ID=$ID;";
//print($sql);die;
    // Thực thi UPDATE
    mysqli_query($conn, $sql);

    // Đóng kết nối
    mysqli_close($conn);

    // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
    header('location:index.php');
}

// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/loaisanpham/edit.html.twig`
// với dữ liệu truyền vào file giao diện được đặt tên là `loaisanpham`
echo $twig->render('backend/main/edit.html.twig', ['main' => $mainRow] );
