<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>新增訂單</title>
</head>
<body>

<?php
// 檢查是否通過 URL 傳遞了 user_id
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}

// 處理表單提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db_connection.php';  // 引入資料庫連接檔案

    // 從表單收集訂單訊息
    $amount = $_POST['amount'];  // 假設訂單有一個金額字段

    // 插入訂單訊息到資料庫
    $sql = "INSERT INTO orders (amount, user_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $amount, $user_id);

    if ($stmt->execute()) {
        echo "新訂單已成功添加。";
        // 訂單添加成功後，可以重定向回會員列表或其他頁面
        // header("Location: index.php");
        // exit();
    } else {
        echo "錯誤：" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<h2>新增訂單</h2>

<form method="post" action="">
    <label for="amount">金額:</label><br>
    <input type="number" id="amount" name="amount" required><br><br>
    <!-- 隱藏字段用於保存會員 ID -->
    <input type="hidden" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
    <input type="submit" value="提交">
</form>

<a href="read_order.php">回訂單列表</a>
</body>
</html>
