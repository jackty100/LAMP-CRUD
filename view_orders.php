<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>會員訂單列表</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>會員訂單列表</h2>

<?php
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    require 'db_connection.php';

    // 根據會員 ID 查詢相關的訂單資訊
    $sql = "SELECT id, amount, user_id FROM orders WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>訂單ID</th><th>金額</th><th>會員ID</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['amount']) . "</td>";
            echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "該會員沒有訂單記錄。";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "未指定會員 ID。";
}
?>

</body>
</html>
