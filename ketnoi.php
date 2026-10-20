<?php
mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$user = "root";
$password = "";
$database = "website_tintuc";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    http_response_code(500);
    exit("Không thể kết nối cơ sở dữ liệu. Hãy kiểm tra MySQL trong XAMPP và file ketnoi.php.");
}

$conn->set_charset("utf8mb4");
