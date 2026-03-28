<?php
$conn = mysqli_connect("localhost", "root", "", "attendance_db");
if (!$conn) { die("خطأ في الاتصال: " . mysqli_connect_error()); }
?>