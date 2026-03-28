<?php include 'db_config.php'; ?>
<form action="save_employee.php" method="POST">
    <input type="text" name="name" placeholder="اسم الموظف" required>
    <select name="salary_type">
        <option value="salary_only">راتب أساسي</option>
        <option value="salary_bonus">راتب + بونص</option>
    </select>
    <button type="submit">إضافة موظف</button>
</form>

<table border="1">
    <tr>
        <th>الاسم</th>
        <th>النظام</th>
        <th>الفرع الحالي</th>
        <th>نقل لفرع آخر</th>
    </tr>
    <?php
    $res = mysqli_query($conn, "SELECT * FROM employees");
    while($row = mysqli_fetch_assoc($res)) {
        echo "<tr>
                <td>{$row['name']}</td>
                <td>".($row['salary_type']=='salary_bonus' ? 'مستحق للبونص' : 'راتب أساسي')."</td>
                <td>{$row['branch_id']}</td>
                <td>
                    <form action='update_branch.php' method='POST'>
                        <input type='hidden' name='emp_id' value='{$row['id']}'>
                        <select name='new_branch' onchange='this.form.submit()'>
                            <option value=''>اختر الفرع...</option>
                            <option value='1'>فرع الرياض</option>
                            <option value='2'>فرع جدة</option>
                        </select>
                    </form>
                </td>
              </tr>";
    }
    ?>
</table>