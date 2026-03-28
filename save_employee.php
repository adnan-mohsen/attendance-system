<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == $_POST) {
    $name = $_POST['name'];
    $salary_type = $_POST['salary_type'];
    $branch_id = 1; // تعيين فرع افتراضي حالياً

    $sql = "INSERT INTO employees (name, salary_type, branch_id) VALUES ('$name', '$salary_type', '$branch_id')";

    if (mysqli_query($conn, $sql)) {
        header("Location: employees.php"); // العودة لصفحة الموظفين بعد الحفظ
    } else {
        echo "خطأ: " . mysqli_error($conn);
    }
}
?>