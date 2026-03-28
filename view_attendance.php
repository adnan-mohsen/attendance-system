<div style="text-align: left; margin-bottom: 10px;">
    <button onclick="window.print()" class="btn-filter" style="background-color: #28a745;">🖨️ طباعة التقرير (PDF)</button>
</div>
<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقارير الحضور والغياب</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f8f9fa; margin: 20px; text-align: right; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        
        /* تصميم البطاقات الإحصائية */
        .stats-container { display: flex; gap: 20px; margin-bottom: 25px; justify-content: center; }
        .stat-card { background: white; padding: 15px 30px; border-radius: 10px; border: 1px solid #eee; text-align: center; min-width: 150px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .stat-card h4 { margin: 0; color: #666; font-size: 14px; }
        .stat-card .number { font-size: 28px; font-weight: bold; margin-top: 5px; }
        .present-stat { border-top: 4px solid #28a745; color: #28a745; }
        .absent-stat { border-top: 4px solid #dc3545; color: #dc3545; }

        .filter-box { background: #f1f3f5; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 15px; align-items: center; justify-content: center; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dee2e6; padding: 12px; text-align: center; }
        th { background-color: #6f42c1; color: white; }
        .status-present { background-color: #d4edda; color: #155724; border-radius: 4px; padding: 4px 8px; font-weight: bold; }
        .status-absent { background-color: #f8d7da; color: #721c24; border-radius: 4px; padding: 4px 8px; font-weight: bold; }
        .btn-filter { background-color: #007bff; color: white; border: none; padding: 8px 20px; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <h2 style="text-align: center; color: #4b2c85;">📊 تقارير الحضور والغياب</h2>

    <?php
    // تحديد التاريخ للفلترة (اليوم كافتراضي)
    $filter_date = $_GET['filter_date'] ?? date('Y-m-d');
    
    // استعلام لجلب الإحصائيات بناءً على التاريخ المختار
    $stats_query = "SELECT 
        SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_count,
        SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent_count
        FROM attendance_records WHERE attendance_date = '$filter_date'";
    $stats_res = mysqli_query($conn, $stats_query);
    $stats = mysqli_fetch_assoc($stats_res);
    ?>

    <div class="stats-container">
        <div class="stat-card present-stat">
            <h4>إجمالي الحاضرين</h4>
            <div class="number"><?php echo $stats['present_count'] ?? 0; ?></div>
        </div>
        <div class="stat-card absent-stat">
            <h4>إجمالي الغائبين</h4>
            <div class="number"><?php echo $stats['absent_count'] ?? 0; ?></div>
        </div>
    </div>
    
    <div class="filter-box">
        <form method="GET" style="display: flex; gap: 10px; align-items: center;">
            <label>عرض سجلات تاريخ:</label>
            <input type="date" name="filter_date" value="<?php echo $filter_date; ?>">
            <button type="submit" class="btn-filter">تصفية</button>
            <a href="view_attendance.php" style="font-size: 13px; color: #666; text-decoration: none;">إعادة تعيين</a>
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
            $sql = "SELECT attendance_records.*, employees.name 
                    FROM attendance_records 
                    JOIN employees ON attendance_records.employee_id = employees.id 
                    WHERE attendance_date = '$filter_date'
                    ORDER BY id DESC";
            
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
    
    <div style="margin-top: 30px; text-align: center;">
        <a href="employees.php" style="text-decoration: none; color: #007bff; font-weight: bold;">⬅️ العودة للوحة تحكم الموظفين</a>
    </div>
</div>

</body>
</html>
