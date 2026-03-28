<?php
// 1. الاتصال بقاعدة البيانات
include 'db_config.php';

// 2. التأكد أن البيانات قادمة من النموذج (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // استلام البيانات وتأمينها
    $emp_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $new_branch = mysqli_real_escape_string($conn, $_POST['new_branch_id']);

    // 3. كتابة أمر التحديث (Update)
    // نطلب من القاعدة وضع رقم الفرع الجديد للموظف الذي نملك رقمه (ID)
    $sql = "UPDATE employees SET branch_id = '$new_branch' WHERE id = '$emp_id'";

    // 4. تنفيذ الأمر والتحقق من النجاح
    if (mysqli_query($conn, $sql)) {
        // إذا نجح التعديل، ارجع لصفحة الموظفين مع رسالة نجاح بسيطة في الرابط
        header("Location: employees.php?msg=success");
        exit();
    } else {
        // في حال وجود خطأ في القاعدة
        echo "خطأ في عملية النقل: " . mysqli_error($conn);
    }
} else {
    // إذا حاول شخص فتح الملف مباشرة دون إرسال بيانات، نعيده للرئيسية
    header("Location: employees.php");
    exit();
}
?>