<?php
$hostCandidates = [
    'localhost:3307',
    'localhost:3306',
    '127.0.0.1:3307',
    '127.0.0.1:3306'
];

$username = 'root';
$password = '';
$dbname = 'ql_anvat';

$con = false;

foreach ($hostCandidates as $host) {
    $connection = @mysqli_connect($host, $username, $password, $dbname);
    if ($connection) {
        $con = $connection;
        break;
    }
}

if (!$con) {
    die('Kết nối CSDL thất bại. Vui lòng kiểm tra MySQL/XAMPP và cổng kết nối (3306/3307).');
}

mysqli_set_charset($con, 'utf8mb4');
?>