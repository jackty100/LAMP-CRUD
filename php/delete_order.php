<?php
require 'db_connection.php';  // 匯入資料庫連線設定

// 確認是否透過 POST 方法接收到訂單 ID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];  // 從 POST 資料中取得訂單 ID

    // 準備刪除訂單的 SQL 語句
    $sql = "DELETE FROM orders WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);  // 綁定參數

    // 執行 SQL 語句並檢查是否成功
    if ($stmt->execute()) {
        // 刪除成功，重定向到訂單列表頁面
        header("Location: read_order.php");
        exit();
    } else {
        // 刪除失敗，顯示錯誤訊息
        echo "刪除訂單時發生錯誤：" . $conn->error;
    }

    $stmt->close();  // 關閉 statement
} else {
    echo "請求方法不正確或缺少訂單 ID。";
}

$conn->close();  // 關閉資料庫連線
?>
