<?php
$DB_HOST = 'muffindb.cvzp6pu50kcj.us-east-1.rds.amazonaws.com';
$DB_DATABASE = 'muffindb';
$DB_PORT = '3306';
$DB_USER = 'vguncheva';
$DB_PASS = '12345678';
$CHARSET = 'utf8';

try {
    $dns = "mysql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_DATABASE};charset={$CHARSET}";
    $conn = new PDO($dns, $DB_USER, $DB_PASS);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage() . '<br/>';
    die();
}
?>