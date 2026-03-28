<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الحضور اليومي</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; text-align: right; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: center; }
        th { background-color: #28a745; color: white; }
        .btn-save { background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; width: 100%; font-size: 16px; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2 style="text-align: center;">تسجيل الحضور - تاريخ اليوم: <?php echo date('Y-m-d'); ?></h2>
    
    <form action="save_attendance.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>اسم الموظف</th>
                    <th>حاضر</th>
                    <th>غائب</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM employees");
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td><input type='radio' name='status[{$row['id']}]' value='present' required></td>
                            <td><input type='radio' name='status[{$row['id']}]' value='absent'></td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
        <button type="submit" class="btn-save">حفظ سجل الحضور</button>
    </form>
    <p style="text-align: center;"><a href="employees.php">العودة لإدارة الموظفين</a></p>
</div>

</body>
</html>