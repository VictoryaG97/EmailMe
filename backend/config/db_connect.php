<?php
$DB_HOST = '';
$DB_DATABASE = '';
$DB_PORT = '';
$DB_USER = '';
$DB_PASS = '';
$CHARSET = 'utf8';

try {
    $dns = "mysql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_DATABASE};charset={$CHARSET}";
    $conn = new PDO($dns, $DB_USER, $DB_PASS);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage() . '<br/>';
    die();
}
?>
