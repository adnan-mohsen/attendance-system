<?php
include 'db_config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['branch_name']);
    $sql = "INSERT INTO branches (branch_name) VALUES ('$name')";
    if(mysqli_query($conn, $sql)) {
        header("Location: manage_branches.php");
    }
}
?>