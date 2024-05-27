<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASS', '');
define('DB_NAME', 'integ_exam');


$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
