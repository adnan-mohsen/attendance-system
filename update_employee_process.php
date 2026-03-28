<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $salary_type = $_POST['salary_type'];

    // تنفيذ عملية التحديث
    $sql = "UPDATE employees SET name='$name', salary_type='$salary_type' WHERE id=$id";
    
    if(mysqli_query($conn, $sql)) {
        // العودة لصفحة الموظفين بعد النجاح
        header("Location: employees.php");
    } else {
        echo "خطأ في التحديث: " . mysqli_error($conn);
    }
}
?>