<?php
ob_start();  // 啟動輸出緩衝區

require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $user_id = $_POST['id'];

    // 刪除該會員的所有訂單
    $sql = "DELETE FROM orders WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // 然後刪除會員本身
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "會員及其訂單刪除成功。";
    } else {
        echo "刪除會員時發生錯誤：" . $conn->error;
    }

    $stmt->close();
    $conn->close();

    // 處理完成後重定向到 index.php
    header("Location: index.php");
    exit();
} else {
    echo "請求方法不正確或缺少會員 ID。";
}

ob_end_flush();  // 發送緩衝區內容並關閉緩衝區
?>
