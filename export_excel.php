<?php
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=attendance_report.xls");

include 'db_config.php';
echo "<table border='1'>
        <tr><th>الموظف</th><th>الحالة</th><th>نوع التعاقد</th></tr>";

$res = mysqli_query($conn, "SELECT * FROM employees");
while($row = mysqli_fetch_assoc($res)) {
    $type = ($row['salary_type'] == 'salary_bonus') ? "راتب + بونص" : "راتب فقط";
    echo "<tr><td>{$row['name']}</td><td>حاضر</td><td>{$type}</td></tr>";
}
echo "</table>";
?>