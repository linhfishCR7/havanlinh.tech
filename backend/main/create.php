<?php
// Include file cấu hình ban đầu của `Twig`
require_once __DIR__.'/../../bootstrap.php';

// Truy vấn database
// 1. Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
include_once(__DIR__.'/../../dbconnect.php');
if(!isset($_SESSION['email_logged']) && empty($_SESSION['email_logged'])) {
    header('location:../auth/login.php');
}
// 2. Nếu người dùng có bấm nút Đăng ký thì thực thi câu lệnh UPDATE
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
            // Tiến hành di chuyển file từ thư mục tạm trên server vào thư mục chúng ta muốn chứa các file uploads
            // Ví dụ: move file từ C:\xampp\tmp\php6091.tmp -> C:/xampp/htdocs/learning.nentang.vn/php/twig/assets/uploads/hoahong.jpg
            $hsp_tentaptin = $_FILES['Picture']['name'];
            $Picture = date('YmdHis') . '_' .$hsp_tentaptin; //20200530154922_hoahong.jpg
            
            move_uploaded_file($_FILES['Picture']['tmp_name'], $upload_dir. $Picture);
            echo 'File Uploaded';
        }
    }
    // Câu lệnh INSERT
    $sql = "INSERT INTO `main` (Title, LinkTitle, Content,LinkSource,NameSource,Picture,Create_at) VALUES ('" . $Title . "', '". $LinkTitle ."', '". $Content ."', '". $LinkSource ."', '". $NameSource ."', '". $Picture ."', '". $Create_at ."');";

    // Thực thi INSERT
    mysqli_query($conn, $sql);

    // Đóng kết nối
    mysqli_close($conn);

    // Sau khi cập nhật dữ liệu, tự động điều hướng về trang Danh sách
    header('location:index.php');
}

// Yêu cầu `Twig` vẽ giao diện được viết trong file `backend/loaisanpham/create.html.twig`
echo $twig->render('backend/main/create.html.twig');