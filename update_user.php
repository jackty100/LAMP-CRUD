<?php
include 'db_connection.php';  // 引入資料庫連接文件

// 初始化$user變量
$user = null;

// 檢查 GET 請求中是否有 id 參數
if (isset($_GET['id']) && $_GET['id'] !== '') {
    $id = $_GET['id'];  // 從 URL 獲取會員 ID

    // 準備 SQL 語句並執行，以獲取會員訊息
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "找不到指定的會員。";
    }
    $stmt->close();
} else {
    echo "會員ID未指定或不正確。";
}

$conn->close();

// 如果$user為null，則不輸出表單和後續內容
if ($user === null) {
    exit;
}
?>

<!-- 會員更新表單 -->
<form action="update_user_process.php" method="post">
    <label for="id">會員ID:</label><br>
    <input type="text" id="id" name="id" value="<?php echo $user['id']; ?>" disabled><br>

    <!-- 隱藏欄位，用於表單提交 -->
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

    <label for="name">姓名:</label><br>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>

    <label for="phone">電話:</label><br>
    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required><br><br>

    <input type="submit" value="更新">
</form>
