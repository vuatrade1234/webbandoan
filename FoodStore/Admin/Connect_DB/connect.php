<?php
$hostCandidates = [
    'localhost:3307',
    'localhost:3306',
    '127.0.0.1:3307',
    '127.0.0.1:3306'
];

$username = 'root';
$pass = '';
$dbname = 'ql_anvat';

$conn = false;

foreach ($hostCandidates as $host) {
    $connection = @mysqli_connect($host, $username, $pass, $dbname);
    if ($connection) {
        $conn = $connection;
        break;
    }
}

if (!$conn) {
    die('Kết nối CSDL Admin thất bại. Vui lòng kiểm tra MySQL/XAMPP và cổng kết nối (3306/3307).');
}

mysqli_set_charset($conn, 'utf8mb4');
?>