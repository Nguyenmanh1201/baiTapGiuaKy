<?php
// Lấy ID từ URL
$id = $_GET['id'];

// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'qlsv_nguyencongmanh');

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xóa sinh viên
$sql = "DELETE FROM table_students WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Sinh viên đã được xóa thành công!";
    header("Location: index.php");
} else {
    echo "Lỗi: " . $conn->error;
}

$conn->close();
?>
