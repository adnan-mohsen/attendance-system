<nav style="background: #343a40; padding: 15px; text-align: center; border-radius: 8px; margin-bottom: 20px;">
    <a href="employees.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold;">👥 الموظفين</a>
    <a href="take_attendance.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold;">📝 تسجيل الحضور</a>
    <a href="view_attendance.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold;">📊 التقارير</a>
</nav>
<?php include 'check_login.php'; ?>
<div style="text-align: center; margin-bottom: 20px;">
    <a href="take_attendance.php" class="btn" style="background-color: #28a745;">📝 تسجيل حضور اليوم</a>
    <a href="view_attendance.php" class="btn" style="background-color: #6f42c1;">📊 عرض التقارير</a>
</div>
<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نظام إدارة الموظفين</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 20px; background-color: #f8f9fa; text-align: right; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        
        /* تنسيق النموذج */
        .form-container { background: #e9ecef; padding: 20px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap; justify-content: center; }
        input, select { padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
        
        /* تنسيق الجدول */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #dee2e6; padding: 12px; text-align: center; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        
        /* الأزرار */
        .btn { padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; color: white; text-decoration: none; font-size: 14px; display: inline-block; }
        .btn-add { background-color: #28a745; font-weight: bold; }
        .btn-add:hover { background-color: #218838; }
        .btn-transfer { background-color: #17a2b8; margin-left: 5px; }
        .btn-delete { background-color: #dc3545; }
        .btn-delete:hover { background-color: #c82333; }
    </style>
</head>
<body>

<div class="container">
    <h2>إدارة الموظفين</h2>

    <div class="form-container">
        <form action="save_employee.php" method="POST" style="display: flex; gap: 10px; flex-wrap: wrap;">
            <input type="text" name="name" placeholder="اسم الموظف الجديد" required style="width: 250px;">
            
            <select name="salary_type">
                <option value="salary_only">راتب أساسي</option>
                <option value="salary_bonus">راتب + بونص</option>
            </select>

            <select name="branch_id" required>
                <option value="">اختر الفرع</option>
                <?php
                $branches = mysqli_query($conn, "SELECT * FROM branches");
                while($b = mysqli_fetch_assoc($branches)) {
                    echo "<option value='{$b['id']}'>{$b['branch_name']}</option>";
                }
                ?>
            </select>

            <button type="submit" class="btn btn-add">إضافة موظف الآن</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>نظام الراتب</th>
                <th>الفرع الحالي</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // استعلام جلب الموظفين مع اسم الفرع
            $query = "SELECT employees.*, branches.branch_name 
                      FROM employees 
                      LEFT JOIN branches ON employees.branch_id = branches.id 
                      ORDER BY employees.id DESC";
            $result = mysqli_query($conn, $query);

            $sn = 1; // عداد التسلسل الرقمي

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $type = ($row['salary_type'] == 'salary_only') ? 'أساسي' : 'بونص';
                    echo "<tr>
                            <td>$sn</td>
                            <td>{$row['name']}</td>
                            <td>$type</td>
                            <td>" . ($row['branch_name'] ?? 'غير محدد') . "</td>
                            <td>
                                <a href='transfer_employee.php?id={$row['id']}' class='btn btn-transfer'>نقل فرع</a>
                                <a href='delete_employee.php?id={$row['id']}' class='btn btn-delete' onclick='return confirm(\"هل أنت متأكد من حذف الموظف {$row['name']}؟\")'>حذف</a>
                            </td>
                          </tr>";
                    $sn++;
                }
            } else {
                echo "<tr><td colspan='5'>لا يوجد موظفين حالياً. أضف موظفك الأول!</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
