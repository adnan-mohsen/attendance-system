<?php
// 1. الاتصال بقاعدة البيانات
include 'db_config.php';

// 2. التأكد من أن البيانات أرسلت عبر POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $salary_type = $_POST['salary_type'];
    $branch_id = 1; // القيمة الافتراضية للفرع الرئيسي

    // 3. أمر الحفظ
    $sql = "INSERT INTO employees (name, salary_type, branch_id) VALUES ('$name', '$salary_type', '$branch_id')";

    if (mysqli_query($conn, $sql)) {
        // 4. إعادة التوجيه لصفحة الجدول فور النجاح
        header("Location: employees.php");
        exit(); // ضروري جداً لضمان توقف السكربت هنا
    } else {
        echo "خطأ في الحفظ: " . mysqli_error($conn);
    }
} else {
    // إذا دخل شخص للملف مباشرة دون إرسال بيانات
    header("Location: employees.php");
    exit();
}
?>