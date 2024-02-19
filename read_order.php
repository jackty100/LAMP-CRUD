<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>訂單列表</title>
    <style>
        body {
            font-family: 'Microsoft JhengHei', sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a, input[type="submit"] {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }
        a:hover, input[type="submit"]:hover {
            background-color: #0056b3;
        }
        form {
            display: inline;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<h2>訂單列表</h2>
<a href="index.php" class="back-link">回到會員列表</a>

<table>
    <tr>
        <th>會員ID</th>
        <th>訂單ID</th>
        <th>金額</th>
        <th>會員姓名</th>
        <th>操作</th>
    </tr>

    <?php
    require 'db_connection.php';

    $sql = "SELECT users.id AS user_id, orders.id AS order_id, orders.amount, users.name AS user_name FROM orders JOIN users ON orders.user_id = users.id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["user_id"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["order_id"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["amount"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["user_name"]) . "</td>";
            echo "<td>
                    <a href='update_order.php?order_id=" . $row["order_id"] . "'>更新</a>
                    <form method='POST' action='delete_order.php' onsubmit='return confirm(\"確定要刪除這筆訂單嗎？\");'>
                        <input type='hidden' name='order_id' value='" . $row["order_id"] . "'>
                        <input type='submit' value='刪除' class='delete-btn'>
                    </form>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>沒有訂單記錄</td></tr>";
    }
    $conn->close();
    ?>
</table>

</body>
</html>
