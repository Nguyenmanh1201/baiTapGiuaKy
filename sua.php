<?php
$conn = new mysqli('localhost', 'root', '', 'qlsv_nguyencongmanh');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra và lấy thông tin sinh viên từ URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    $sql = "SELECT * FROM table_students WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        die("Không tìm thấy sinh viên!");
    }
} else {
    die("ID sinh viên không hợp lệ!");
}

// Xử lý cập nhật dữ liệu khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $gender = intval($_POST['gender']);
    $hometown = $conn->real_escape_string($_POST['hometown']);
    $level = intval($_POST['level']);
    $group_id = intval($_POST['group_id']);

    $sql_update = "UPDATE table_students 
                   SET fullname='$fullname', dob='$dob', gender='$gender', hometown='$hometown', level='$level', group_id='$group_id' 
                   WHERE id=$id";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href = 'index.php';</script>";
    } else {
        echo "Lỗi cập nhật: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin sinh viên</title>
    <link rel="stylesheet" href="style_sua.css">
</head>
<body>
    <div class="container">
        <h1>Cập nhật thông tin sinh viên</h1>
        <form method="POST" action="sua.php?id=<?= $id ?>" class="sua-form">

            <div class="form-group">
                <label for="fullname">Họ và Tên:</label>
                <input type="text" id="fullname" name="fullname" value="<?= htmlspecialchars($student['fullname']) ?>" required>
            </div>

            <div class="form-group">
                <label for="dob">Ngày Sinh:</label>
                <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($student['dob']) ?>" required>
            </div>

            <div class="form-group">
                <label>Giới Tính:</label>
                <label>
                    <input type="radio" name="gender" value="1" <?= $student['gender'] == 1 ? 'checked' : '' ?>> Nam
                </label>
                <label>
                    <input type="radio" name="gender" value="0" <?= $student['gender'] == 0 ? 'checked' : '' ?>> Nữ
                </label>
            </div>

            <div class="form-group">
                <label for="hometown">Quê Quán:</label>
                <input type="text" id="hometown" name="hometown" value="<?= htmlspecialchars($student['hometown']) ?>" required>
            </div>

            <div class="form-group">
                <label for="level">Trình Độ Học Vấn:</label>
                <select id="level" name="level" required>
                    <option value="0" <?= $student['level'] == 0 ? 'selected' : '' ?>>Tiến sĩ</option>
                    <option value="1" <?= $student['level'] == 1 ? 'selected' : '' ?>>Thạc sĩ</option>
                    <option value="2" <?= $student['level'] == 2 ? 'selected' : '' ?>>Kỹ sư</option>
                    <option value="3" <?= $student['level'] == 3 ? 'selected' : '' ?>>Khác</option>
                </select>
            </div>

            <div class="form-group">
                <label for="group_id">Nhóm:</label>
                <input type="number" id="group_id" name="group_id" value="<?= htmlspecialchars($student['group_id']) ?>" required>
            </div>

            <div class="form-group">
                <button type="submit">Cập nhật</button>
            </div>
        </form>
    </div>
</body>
</html>
