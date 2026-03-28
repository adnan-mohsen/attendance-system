<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نظام إدارة الموظفين المتكامل</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f4f7f6; text-align: right; }
        
        /* شريط التنقل العلوي */
        nav { background: #343a40; padding: 15px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        nav a { color: white; text-decoration: none; margin: 0 15px; font-weight: bold; font-size: 16px; }
        nav a:hover { color: #ffc107; }

        .container { max-width: 1100px; margin: 30px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        h2 { text-align: center; color: #333; margin-bottom: 30px; }

        /* تنسيق النموذج */
        .form-container { background: #f8f9fa; padding: 25px; border-radius: 12px; border: 1px solid #e9ecef; margin-bottom: 30px; }
        input, select { padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; outline: none; }
        input:focus { border-color: #007bff; }

        /* الجدول */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; border-radius: 10px; overflow: hidden; }
        th { background-color: #007bff; color: white; padding: 15px; font-size: 15px; }
        td { padding: 15px; border-bottom: 1px solid #eee; text-align: center; color: #555; }
        tr:hover { background-color: #fcfcfc; }

        /* --- الهدية الختامية: تنسيق الأزرار العصري --- */
        .btn { 
            padding: 8px 18px; 
            border: none; 
            border-radius: 6px; 
            cursor: pointer; 
            color: white; 
            text-decoration: none; 
            font-size: 13px; 
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease; /* تأثير النعومة */
        }
        .btn:hover { 
            transform: translateY(-3px); /* رفعة بسيطة عند التمرير */
            box-shadow: 0 5px 12px rgba(0,0,0,0.15); 
        }
        .btn-add { background-color: #28a745; padding: 12px 25px; }
        .btn-edit { background-color: #ffc107; color: #212529; }
        .btn-transfer { background-color: #17a2b8; }
        .btn-delete { background-color: #dc3545; }

        /* رابط الملف الشخصي */
        .emp-name { color: #007bff; text-decoration: none; font-weight: bold; }
        .emp-name:hover { text-decoration: underline; color: #0056b3; }
    </style>
</head>
<body>

<nav>
    <a href="employees.php">👥 إدارة الموظفين</a>
    <a href="take_attendance.php">📝 تسجيل الحضور</a>
    <a href="view_attendance.php">📊 التقارير العامة</a>
</nav>

<div class="container">
    <h2>إدارة طاقم العمل</h2>

    <div class="form-container">
        <form action="save_employee.php" method="POST" style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <input type="text" name="name" placeholder="اسم الموظف الثلاثي" required style="flex: 1; min-width: 200px;">
            
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

            <button type="submit" class="btn btn-add">➕ إضافة للأنظمة</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الموظف (اضغط للملف)</th>
                <th>نظام الراتب</th>
                <th>الفرع</th>
                <th>إدارة البيانات</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT employees.*, branches.branch_name 
                      FROM employees 
                      LEFT JOIN branches ON employees.branch_id = branches.id 
                      ORDER BY employees.id DESC";
            $result = mysqli_query($conn, $query);
            $sn = 1;

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $type = ($row['salary_type'] == 'salary_only') ? 'أساسي' : 'بونص';
                    echo "<tr>
                            <td>$sn</td>
                            <td>
                                <a href='employee_profile.php?id={$row['id']}' class='emp-name'>
                                    {$row['name']}
                                </a>
                            </td>
                            <td>$type</td>
                            <td>" . ($row['branch_name'] ?? '---') . "</td>
                            <td>
                                <a href='edit_employee.php?id={$row['id']}' class='btn btn-edit'>تعديل</a>
                                <a href='transfer_employee.php?id={$row['id']}' class='btn btn-transfer'>نقل</a>
                                <a href='delete_employee.php?id={$row['id']}' class='btn btn-delete' onclick='return confirm(\"حذف الموظف نهائياً؟\")'>حذف</a>
                            </td>
                          </tr>";
                    $sn++;
                }
            } else {
                echo "<tr><td colspan='5'>القاعدة فارغة.. ابدأ بإضافة موظفيك!</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
