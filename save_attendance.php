<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = date('Y-m-d');
    
    // التأكد من وجود بيانات مرسلة
    if (isset($_POST['status']) && is_array($_POST['status'])) {
        $statuses = $_POST['status'];

        foreach ($statuses as $emp_id => $status) {
            $emp_id = mysqli_real_escape_string($conn, $emp_id);
            $status = mysqli_real_escape_string($conn, $status);

            // إدخال السجل في قاعدة البيانات
            $sql = "INSERT INTO attendance_records (employee_id, status, attendance_date) 
                    VALUES ('$emp_id', '$status', '$date')";
            mysqli_query($conn, $sql);
        }

        echo "<script>alert('تم تسجيل الحضور بنجاح!'); window.location.href='view_attendance.php';</script>";
    } else {
        echo "لم يتم اختيار أي حالة حضور.";
    }
} else {
    header("Location: take_attendance.php");
}
?>