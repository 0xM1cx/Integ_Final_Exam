<?php
require_once "../model/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $book_id = isset($_POST['book_id']) ? filter_var($_POST['book_id'], FILTER_VALIDATE_INT) : 0;
    $title = isset($_POST['edit-title']) ? htmlspecialchars($_POST['edit-title'], ENT_QUOTES, 'UTF-8') : '';
    $synopsis = isset($_POST['edit-synopsis']) ? htmlspecialchars($_POST['edit-synopsis'], ENT_QUOTES, 'UTF-8') : '';
    $author = isset($_POST['edit-author']) ? htmlspecialchars($_POST['edit-author'], ENT_QUOTES, 'UTF-8') : '';
    $rating = isset($_POST['edit-rating']) ? filter_var($_POST['edit-rating'], FILTER_VALIDATE_INT) : 0;

    $types = "";
    $values = [];

    $updates = [];

    if ($title !== null) {
        $updates[] = "title = ?";
        $types .= "s";
        $values[] = $title;
    }
    if ($synopsis !== null) {
        $updates[] = "synopsis = ?";
        $types .= "s";
        $values[] = $synopsis;
    }
    if ($author !== null) {
        $updates[] = "author = ?";
        $types .= "s";
        $values[] = $author;
    }
    if ($rating > 0) {
        $updates[] = "rating = ?";
        $types .= "i";
        $values[] = $rating;
    }

    $sql = "UPDATE books SET " . implode(", ", $updates) . " WHERE book_id = ?";
    $types .= "i";
    $values[] = $book_id;

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$values);
    if ($stmt->execute()) {
        header("Location: ../index.php?success=1");
        exit();
    } else {
        header("Location: ../index.php?error=1");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
