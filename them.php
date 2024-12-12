<?php

$conn = new mysqli('localhost', 'root', '', 'qlsv_nguyencongmanh');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Khởi tạo biến để lưu dữ liệu sinh viên
$fullname = $dob = $gender = $hometown = $level = $group_id = "";
$isEdit = false;

// Kiểm tra nếu có tham số id trong URL để chỉnh sửa
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $isEdit = true;

    // Lấy thông tin sinh viên từ cơ sở dữ liệu
    $sql = "SELECT * FROM table_students WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fullname = $row['fullname'];
        $dob = $row['dob'];
        $gender = $row['gender'];
        $hometown = $row['hometown'];
        $level = $row['level'];
        $group_id = $row['group_id'];
    } else {
        echo "<script>alert('Sinh viên không tồn tại!'); window.location.href = 'index.php';</script>";
    }
}

// Xử lý form khi người dùng nhấn nút Lưu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $hometown = $_POST['hometown'];
    $level = $_POST['level'];
    $group_id = $_POST['group_id'];

    // Câu lệnh SQL để thêm sinh viên vào cơ sở dữ liệu
    $sql = "INSERT INTO table_students (fullname, dob, gender, hometown, level, group_id) 
            VALUES ('$fullname', '$dob', '$gender', '$hometown', '$level', '$group_id')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Sinh viên đã được thêm thành công!'); window.location.href = 'index.php';</script>";
    } else {
        echo "Lỗi: ". $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Cập nhật sinh viên' : 'Thêm sinh viên' ?></title>
    <link rel="stylesheet" href="style_them.css">
</head>
<body>
    <div class="container">
        <form action="" method="POST">
            <h1><?= $isEdit ? 'Cập nhật thông tin sinh viên' : 'Thêm thông tin sinh viên' ?></h1>

            <label for="fullname">Họ và tên:</label>
            <input type="text" id="fullname" name="fullname" value="<?= htmlspecialchars($fullname) ?>" required><br>

            <label for="dob">Ngày sinh:</label>
            <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($dob) ?>" required><br>

            <label for="gender">Giới tính:</label>
            <input type="radio" id="male" name="gender" value="M" <?= $gender == 'M' ? 'checked' : '' ?> required>
            <label for="male">Nam</label>
            <input type="radio" id="female" name="gender" value="F" <?= $gender == 'F' ? 'checked' : '' ?> required>
            <label for="female">Nữ</label><br>

            <label for="hometown">Quê quán:</label>
            <input type="text" id="hometown" name="hometown" value="<?= htmlspecialchars($hometown) ?>" required><br>

            <label for="level">Trình độ học vấn:</label>
            <select id="level" name="level" required>
                <option value="Tiến sĩ" <?= $level == 'Tiến sĩ' ? 'selected' : '' ?>>Tiến sĩ</option>
                <option value="Thạc sĩ" <?= $level == 'Thạc sĩ' ? 'selected' : '' ?>>Thạc sĩ</option>
                <option value="Kỹ sư" <?= $level == 'Kỹ sư' ? 'selected' : '' ?>>Kỹ sư</option>
                <option value="Khác" <?= $level == 'Khác' ? 'selected' : '' ?>>Khác</option>
            </select><br>

            <label for="group_id">Mã nhóm:</label>
            <input type="number" id="group_id" name="group_id" value="<?= htmlspecialchars($group_id) ?>" required><br>

            <button type="submit" value="Lưu">Lưu</button>
        </form>
    </div>
</body>
</html>
