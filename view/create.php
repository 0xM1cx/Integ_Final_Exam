<?php
require "../model/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST['title']) ? htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8') : '';
    $synopsis = isset($_POST['synopsis']) ? htmlspecialchars($_POST['synopsis'], ENT_QUOTES, 'UTF-8') : '';
    $author = isset($_POST['author']) ? htmlspecialchars($_POST['author'], ENT_QUOTES, 'UTF-8') : '';
    $rating = isset($_POST['rating']) ? filter_var($_POST['rating'], FILTER_VALIDATE_INT) : 0;

    if ($title && $synopsis && $author && $rating) {
        $sql = "INSERT INTO books(title, synopsis, rating, author) VALUES (?, ?, ?, ?);";
        $sql_prep = $conn->prepare($sql);
        $sql_prep->bind_param("ssis", $title, $synopsis, $rating, $author);
        $sql_prep->execute();
        header("Location: ../index.php?added=1");
    }
}
