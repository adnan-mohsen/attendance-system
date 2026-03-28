<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقارير الحضور والغياب</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f8f9fa; margin: 20px; text-align: right; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .filter-box { background: #f1f3f5; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 15px; align-items: center; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dee2e6; padding: 12px; text-align: center; }
        th { background-color: #6f42c1; color: white; }
        .status-present { background-color: #d4edda; color: #155724; border-radius: 4px; padding: 4px 8px; }
        .status-absent { background-color: #f8d7da; color: #721c24; border-radius: 4px; padding: 4px 8px; }
        .btn-filter { background-color: #007bff; color: white; border: none; padding: 8px 20px; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <h2 style="text-align: center; color: #4b2c85;">📊 تقارير الحضور والغياب</h2>
    
    <div class="filter-box">
        <form method="GET" style="display: flex; gap: 10px; align-items: center;">
            <label>عرض سجلات تاريخ:</label>
            <input type="date" name="filter_date" value="<?php echo $_GET['filter_date'] ?? date('Y-m-d'); ?>">
            <button type="submit" class="btn-filter">تصفية</button>
            <a href="view_attendance.php" style="font-size: 13px; color: #666;">عرض الكل</a>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>التاريخ</th>
                <th>اسم الموظف</th>
                <th>الحالة</th>
                <th>ساعة التسجيل</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $filter_date = $_GET['filter_date'] ?? '';
            $where_clause = $filter_date ? "WHERE attendance_date = '$filter_date'" : "";

            $sql = "SELECT attendance_records.*, employees.name 
                    FROM attendance_records 
                    JOIN employees ON attendance_records.employee_id = employees.id 
                    $where_clause
                    ORDER BY attendance_date DESC";
            
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $status = ($row['status'] == 'present') ? 'حاضر' : 'غائب';
                    $class = ($row['status'] == 'present') ? 'status-present' : 'status-absent';
                    echo "<tr>
                            <td>{$row['attendance_date']}</td>
                            <td>{$row['name']}</td>
                            <td><span class='$class'>$status</span></td>
                            <td>" . date('H:i', strtotime($row['created_at'])) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>لا توجد سجلات لهذا التاريخ.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <div style="margin-top: 20px; text-align: center;">
        <a href="employees.php" style="text-decoration: none; color: #007bff;">⬅️ العودة للوحة التحكم</a>
    </div>
</div>

</body>
</html>
