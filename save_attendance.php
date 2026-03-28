<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $status = $_POST['status'];
    $attendance_date = date('Y-m-d'); // تاريخ اليوم

    // 1. الفحص: هل يوجد سجل لهذا الموظف في تاريخ اليوم؟
    $check_query = "SELECT id FROM attendance_records WHERE employee_id = '$employee_id' AND attendance_date = '$attendance_date'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // إذا وجد سجل، اظهر رسالة تنبيه وارجع للخلف
        echo "<script>
                alert('عذراً! تم تسجيل حضور/غياب هذا الموظف مسبقاً لهذا اليوم.');
                window.location.href = 'take_attendance.php';
              </script>";
    } else {
        // 2. إذا لم يوجد سجل، قم بعملية الإدخال بشكل طبيعي
        $sql = "INSERT INTO attendance_records (employee_id, status, attendance_date) VALUES ('$employee_id', '$status', '$attendance_date')";
        
        if (mysqli_query($conn, $sql)) {
            header("Location: view_attendance.php");
        } else {
            echo "خطأ في التسجيل: " . mysqli_error($conn);
        }
    }
}
?>
