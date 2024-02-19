<?php
include 'db_connection.php';  // 引入資料庫連接文件

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $sql = "UPDATE users SET name = ?, phone = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $phone, $id);

    // 執行更新操作前不輸出任何內容
    if ($stmt->execute()) {
        // 關閉 statement 和連接
        $stmt->close();
        $conn->close();

        // 重定向前沒有任何輸出
        header("Location: index.php");
        exit();
    } else {
        // 如果更新失敗，則處理錯誤
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        // 使用輸出緩衝可以避免 headers already sent 錯誤
        ob_start();
        echo "錯誤：" . $error;
        ob_end_flush();
    }
} else {
    echo "這個頁面需要通過 POST 方法訪問。";
}
?>
