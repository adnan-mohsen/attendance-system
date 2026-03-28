<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['employee_id'])) {
    $employee_id = intval($_POST['employee_id']); // تحويله لرقم لضمان الأمان
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $attendance_date = date('Y-m-d');

    // 1. فحص التكرار
    $check = mysqli_query($conn, "SELECT id FROM attendance_records WHERE employee_id = $employee_id AND attendance_date = '$attendance_date'");
    
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('هذا الموظف مسجل مسبقاً اليوم!'); window.location.href='take_attendance.php';</script>";
    } else {
        // 2. الإدخال
        $sql = "INSERT INTO attendance_records (employee_id, status, attendance_date) VALUES ($employee_id, '$status', '$attendance_date')";
        if (mysqli_query($conn, $sql)) {
            header("Location: view_attendance.php");
        } else {
            echo "خطأ في قاعدة البيانات: " . mysqli_error($conn);
        }
    }
} else {
    echo "خطأ: لم يتم استلام بيانات الموظف.";
}
?>
