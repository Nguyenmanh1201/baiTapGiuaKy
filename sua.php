<?php
$conn = new mysqli('localhost', 'root', '', 'qlsv_nguyencongmanh');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy id sinh viên từ URL (tham số GET)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy thông tin sinh viên từ cơ sở dữ liệu
    $sql = "SELECT * FROM table_students WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        die("Không tìm thấy sinh viên!");
    }
}

// Xử lý form khi người dùng nhấn nút Cập nhật
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $hometown = $_POST['hometown'];
    $level = $_POST['level'];
    $group_id = $_POST['group_id'];

    // Cập nhật thông tin sinh viên
    $sql_update = "UPDATE table_students SET fullname='$fullname', dob='$dob', gender='$gender', hometown='$hometown', level='$level', group_id='$group_id' WHERE id=$id";
    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Thông tin sinh viên đã được cập nhật thành công!'); window.location.href = 'index.php?updated=1';</script>";
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
   
    <link rel="stylesheet" href="style_sua.css">
</head>
<body>
    <div class="container">
        <h1>Sửa thông tin sinh viên</h1>
        <form method="post" action="sua.php?id=<?= $id ?>" class="sua-form">
        <h1>Sửa Sinh Viên</h1>

        <!-- Nhóm label và input cho Họ và Tên -->
        <div>
            <label for="fullname">Họ và Tên:</label>
            <input type="text" id="fullname" name="fullname" value="<?= $row['fullname'] ?>" required>
        </div>

        <!-- Nhóm label và input cho Ngày Sinh -->
        <div>
            <label for="dob">Ngày Sinh:</label>
            <input type="date" id="dob" name="dob" required>
        </div>

        <!-- Nhóm label và radio cho Giới Tính -->
        <div>
            <label for="gender">Giới Tính:</label>
            <input type="radio" name="gender" value="1" <?= $row['gender'] == 1 ? 'checked' : '' ?>> Nam
            <input type="radio" name="gender" value="0" <?= $row['gender'] == 0 ? 'checked' : '' ?>> Nữ
        </div>

        <!-- Nhóm label và input cho Quê Quán -->
        <div>
            <label for="hometown">Quê Quán:</label>
            <input type="text" name="hometown" value="<?= $row['hometown'] ?>" required>
        </div>

        <!-- Nhóm label và select cho Trình Độ Học Vấn -->
        <div>
            <label for="level">Trình Độ Học Vấn:</label>
            <select name="level" id="level" required>
                <option value="0" <?= $row['level'] == 0 ? 'selected' : '' ?>>Tiến sĩ</option>
                <option value="1" <?= $row['level'] == 1 ? 'selected' : '' ?>>Thạc sĩ</option>
                <option value="2" <?= $row['level'] == 2 ? 'selected' : '' ?>>Kỹ sư</option>
                <option value="3" <?= $row['level'] == 3 ? 'selected' : '' ?>>Khác</option>
            </select>
        </div>

        <!-- Nhóm label và input cho Nhóm -->
        <div>
            <label for="group_id">Nhóm:</label>
            <input type="id" name="group_id" value="<?= $row['group_id'] ?>" required>
        </div>

        <!-- Nút submit -->
        <div>
            <input type="submit" value="Cập nhật">
        </div>
    </form>
    </div>
</body>
</html>