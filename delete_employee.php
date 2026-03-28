<?php
include 'db_config.php';

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // أمر الحذف من قاعدة البيانات
    $sql = "DELETE FROM employees WHERE id = '$id'";

    if(mysqli_query($conn, $sql)) {
        // العودة لصفحة الموظفين بعد الحذف
        header("Location: employees.php");
        exit();
    } else {
        echo "خطأ في الحذف: " . mysqli_error($conn);
    }
}
?>