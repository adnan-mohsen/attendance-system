<?php
include 'db_config.php';
$id = $_GET['id'];

// ملاحظة: لا يمكن حذف فرع إذا كان فيه موظفون (لحماية البيانات)
$check = mysqli_query($conn, "SELECT id FROM employees WHERE branch_id = $id");
if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('لا يمكن حذف هذا الفرع لأنه يحتوي على موظفين!'); window.location.href='manage_branches.php';</script>";
} else {
    mysqli_query($conn, "DELETE FROM branches WHERE id = $id");
    header("Location: manage_branches.php");
}
?>