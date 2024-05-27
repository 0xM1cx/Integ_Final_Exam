<?php

require "../model/database.php";

$sql = "DELETE FROM books WHERE book_id = ?";
$sql_prep = $conn->prepare($sql);
$sql_prep->bind_param("i", $_GET['book_id']);
$sql_prep->execute();
header("Location: ../index.php?deleted=1");
