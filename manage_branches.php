<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الفروع</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 20px; text-align: right; }
        .container { max-width: 600px; margin: auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        input { width: 70%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .btn-add { padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border-bottom: 1px solid #eee; padding: 12px; text-align: center; }
        th { background: #f8f9fa; }
    </style>
</head>
<body>

<div class="container">
    <a href="employees.php" style="text-decoration: none; color: #666;">⬅️ العودة</a>
    <h2 style="text-align: center;">إدارة فروع الشركة</h2>

    <form action="save_branch.php" method="POST" style="display: flex; gap: 10px; margin-bottom: 20px;">
        <input type="text" name="branch_name" placeholder="اسم الفرع الجديد (مثلاً: فرع مكة)" required>
        <button type="submit" class="btn-add">إضافة الفرع</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الفرع</th>
                <th>الإجراء</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = mysqli_query($conn, "SELECT * FROM branches");
            while($row = mysqli_fetch_assoc($res)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['branch_name']}</td>
                        <td><a href='delete_branch.php?id={$row['id']}' style='color: red; text-decoration: none;' onclick='return confirm(\"هل تريد حذف الفرع؟\")'>حذف</a></td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>