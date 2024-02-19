<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>更新訂單</title>
</head>
<body>

<?php
require 'db_connection.php';

// 檢查是否通過 URL 傳遞了 order_id
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // 從數據庫獲取訂單信息
    $sql = "SELECT orders.id, orders.amount, orders.user_id FROM orders WHERE orders.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if (!$order) {
        echo "找不到指定的訂單。";
        exit;
    }
} else {
    echo "未指定訂單 ID。";
    exit;
}
?>

<h2>更新訂單</h2>

<form method="post" action="update_order_process.php">
    <p>會員 ID: <?php echo htmlspecialchars($order['user_id']); ?></p>
    <p>訂單 ID: <?php echo htmlspecialchars($order['id']); ?></p>
    <label for="amount">金額:</label><br>
    <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($order['amount']); ?>" required><br><br>
    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($order['user_id']); ?>">
    <input type="submit" value="更新">
</form>

</body>
</html>
