<?php
$servername = "db";  // Docker Compose 中定義的 MySQL 服務名稱
$username = "user";  // MySQL 用戶名
$password = "password";  // MySQL 密碼
$database = "testdb";  // 數據庫名稱

// 建立連接
$conn = new mysqli($servername, $username, $password, $database);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}
?>
