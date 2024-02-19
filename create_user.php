<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 連接到資料庫
    require 'db_connection.php';

    // 從表單獲取資料
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    // 插入資料到資料庫
    $sql = "INSERT INTO users (name, phone) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $phone);

    if ($stmt->execute()) {
        // 新會員添加成功，重定向到 index.php
        $stmt->close();
        $conn->close();
        header("Location: index.php");
        exit;
    } else {
        // 如果執行失敗，則顯示錯誤信息
        echo "錯誤：" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- 創建會員的 HTML 表單 -->
<form method="post" action="create_user.php">
    <label for="name">姓名:</label><br>
    <input type="text" id="name" name="name" required><br>
    <label for="phone">電話:</label><br>
    <input type="text" id="phone" name="phone" required><br><br>
    <input type="submit" value="提交">
</form>
