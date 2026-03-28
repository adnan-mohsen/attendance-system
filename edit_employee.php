<?php 
include 'db_config.php'; 
include 'header.php'; // لإظهار شريط التنقل العلوي

// جلب بيانات الموظف بناءً على الرقم المرسل في الرابط
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $res = mysqli_query($conn, "SELECT * FROM employees WHERE id = $id");
    $emp = mysqli_fetch_assoc($res);
} else {
    header("Location: employees.php");
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل بيانات موظف</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 20px; }
        .edit-card { max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        input, select, button { width: 100%; padding: 12px; margin-top: 15px; border-radius: 8px; border: 1px solid #ddd; box-sizing: border-box; }
        button { background: #ffc107; color: #212529; font-weight: bold; border: none; cursor: pointer; transition: 0.3s; }
        button:hover { background: #e0a800; }
    </style>
</head>
<body>

<div class="edit-card">
    <h3 style="text-align: center;">تعديل بيانات: <?php echo $emp['name']; ?></h3>
    <form action="update_employee_process.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $emp['id']; ?>">
        
        <label>الاسم الحالي:</label>
        <input type="text" name="name" value="<?php echo $emp['name']; ?>" required>
        
        <label>نظام التعاقد:</label>
        <select name="salary_type">
            <option value="salary_only" <?php if($emp['salary_type'] == 'salary_only') echo 'selected'; ?>>راتب أساسي</option>
            <option value="salary_bonus" <?php if($emp['salary_type'] == 'salary_bonus') echo 'selected'; ?>>راتب + بونص</option>
        </select>
        
        <button type="submit">تحديث البيانات الآن</button>
        <a href="employees.php" style="display:block; text-align:center; margin-top:15px; color:#666; text-decoration:none;">إلغاء والعودة</a>
    </form>
</div>

</body>
</html>
