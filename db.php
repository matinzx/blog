<?php
// db.php

$host = 'localhost';
$db   = 'resume_db';          // نام پایگاه داده‌ای که ایجاد کردید.
$user = 'root';       // نام کاربری پایگاه داده (مثلاً root یا نام دلخواه)
$pass = '';   // رمز عبور مربوط به کاربر
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
