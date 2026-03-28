<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نظام الحضور والغياب</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        .form-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: center; }
        th { background-color: #007bff; color: white; }
        .btn { padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; color: white; }
        .btn-add { background-color: #28a745; }
        .btn-transfer { background-color: #17a2b8; }
    </style>
</head>
<body>

    <h2>إدارة الموظفين</h2>

    <div class="form-container">
        <form action="save_employee.php" method="POST">
            <input type="text" name="name" placeholder="اسم الموظف الجديد" required style="padding: 8px; width: 250px;">
            
            <select name="salary_type" style="padding: 8px;">
                <option value="salary_only">راتب أساسي</option>
                <option value="salary_bonus">راتب + بونص</option>
            </select>

            <button type="submit" class="btn btn-add">إضافة موظف الآن</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>الاسم</th>
                <th>نظام الراتب</th>
                <th>الفرع الحالي</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // جلب البيانات مع اسم الفرع
            $query = "SELECT employees.*, branches.branch_name 
                      FROM employees 
                      LEFT JOIN branches ON employees.branch_id = branches.id";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $type = ($row['salary_type'] == 'salary_only') ? 'أساسي' : 'بونص';
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>$type</td>
                            <td>" . ($row['branch_name'] ?? 'غير محدد') . "</td>
                            <td><button class='btn btn-transfer'>نقل لفرع آخر</button></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>لا يوجد موظفين حالياً. أضف موظفك الأول!</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
