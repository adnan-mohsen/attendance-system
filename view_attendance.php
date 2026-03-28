<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سجل الحضور العام</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f7f6; margin: 20px; text-align: right; }
        .container { max-width: 900px; margin: auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #eee; padding: 12px; text-align: center; }
        th { background-color: #007bff; color: white; }
        .status-present { color: #28a745; font-weight: bold; }
        .status-absent { color: #dc3545; font-weight: bold; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <a href="employees.php" class="back-link">⬅️ العودة للرئيسية</a>
    <h2 style="text-align: center;">سجل الحضور والغياب التاريخي</h2>

    <table>
        <thead>
            <tr>
                <th>التاريخ</th>
                <th>اسم الموظف</th>
                <th>الحالة</th>
                <th>وقت التسجيل</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // استعلام لدمج بيانات الحضور مع أسماء الموظفين
            $sql = "SELECT attendance_records.*, employees.name 
                    FROM attendance_records 
                    JOIN employees ON attendance_records.employee_id = employees.id 
                    ORDER BY attendance_records.attendance_date DESC, attendance_records.id DESC";
            
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $status_text = ($row['status'] == 'present') ? 'حاضر' : 'غائب';
                    $status_class = ($row['status'] == 'present') ? 'status-present' : 'status-absent';
                    $formatted_time = date('H:i', strtotime($row['created_at']));
                    
                    echo "<tr>
                            <td>{$row['attendance_date']}</td>
                            <td>{$row['name']}</td>
                            <td class='$status_class'>$status_text</td>
                            <td>$formatted_time</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>لا توجد سجلات حضور حتى الآن.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>