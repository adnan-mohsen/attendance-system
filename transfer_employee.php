<?php 
// 1. الاتصال بقاعدة البيانات
include 'db_config.php'; 

// 2. التحقق من وجود ID الموظف في الرابط (الذي أرسلناه من صفحة employees.php)
if(!isset($_GET['id'])) { 
    header("Location: employees.php"); 
    exit(); 
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// 3. جلب بيانات الموظف الحالية لعرض اسمه وفرعه الحالي
$query = "SELECT * FROM employees WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$employee = mysqli_fetch_assoc($result);

// إذا لم يتم العثور على الموظف
if(!$employee) {
    die("الموظف غير موجود في قاعدة البيانات.");
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نقل الموظف: <?php echo $employee['name']; ?></title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .transfer-card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 400px; text-align: center; }
        select, button { width: 100%; padding: 12px; margin-top: 15px; border-radius: 5px; border: 1px solid #ddd; font-size: 16px; }
        button { background-color: #007bff; color: white; border: none; cursor: pointer; font-weight: bold; transition: 0.3s; }
        button:hover { background-color: #0056b3; }
        .back-link { display: block; margin-top: 15px; color: #666; text-decoration: none; font-size: 14px; }
        .employee-name { color: #007bff; font-weight: bold; }
    </style>
</head>
<body>

    <div class="transfer-card">
        <h2>نقل الموظف</h2>
        <p>أنت الآن تقوم بنقل الموظف: <br><span class="employee-name"><?php echo $employee['name']; ?></span></p>
        
        <form action="process_transfer.php" method="POST">
            <input type="hidden" name="employee_id" value="<?php echo $id; ?>">
            
            <label>اختر الفرع الجديد:</label>
            <select name="new_branch_id" required>
                <?php
                // جلب جميع الفروع المتاحة من جدول branches
                $branches_query = "SELECT * FROM branches";
                $branches_result = mysqli_query($conn, $branches_query);
                
                while($branch = mysqli_fetch_assoc($branches_result)) {
                    // جعل الفرع الحالي للموظف هو الخيار المختار افتراضياً
                    $selected = ($branch['id'] == $employee['branch_id']) ? 'selected' : '';
                    echo "<option value='{$branch['id']}' $selected>{$branch['branch_name']}</option>";
                }
                ?>
            </select>

            <button type="submit">تأكيد عملية النقل</button>
        </form>
        
        <a href="employees.php" class="back-link">إلغاء والعودة للقائمة الرئيسية</a>
    </div>

</body>
</html>