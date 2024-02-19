<?php
require 'db_connection.php';

// 確認是否通過 POST 方法接收到了表單資料
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 從 POST 數據中獲取訂單 ID 和更新後的金額
    $order_id = $_POST['order_id'];
    $amount = $_POST['amount'];

    // 準備更新訂單的 SQL 語句
    $sql = "UPDATE orders SET amount = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $amount, $order_id);

    // 執行 SQL 語句並檢查是否成功
    if ($stmt->execute()) {
        // 成功更新訂單後，使用 JavaScript 實現延遲重定向
        echo "<script>
                alert('訂單更新成功。');
                window.location.href='read_order.php';
              </script>";
    } else {
        echo "更新訂單時出錯：" . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "此頁面需要通過 POST 方法訪問。";
}
?>
