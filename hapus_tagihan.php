<?php
include 'config/db.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM tagihan WHERE id_tagihan = $id");
header("Location: index.php");
?>