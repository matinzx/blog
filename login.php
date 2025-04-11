<?php
// login.php
session_start();

// اگر قبلاً وارد شده باشد به admin.php هدایت شود
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: admin.php");
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // اعتبارسنجی ورود (برای محیط تولید از روش‌های امن‌تر استفاده کنید)
    $valid_username = 'admin';
    $valid_password = '123456';

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['logged_in'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $message = 'نام کاربری یا رمز عبور اشتباه است.';
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <title>ورود به پنل مدیریت</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h1 class="text-2xl font-bold mb-4 text-center">ورود به پنل مدیریت</h1>
    <?php if ($message): ?>
      <div class="bg-red-200 text-red-800 p-2 rounded mb-4">
        <?php echo htmlspecialchars($message); ?>
      </div>
    <?php endif; ?>
    <form method="POST" action="login.php">
      <div class="mb-4">
        <label for="username" class="block mb-1">نام کاربری:</label>
        <input type="text" name="username" id="username" class="w-full p-2 border rounded" required>
      </div>
      <div class="mb-4">
        <label for="password" class="block mb-1">رمز عبور:</label>
        <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
      </div>
      <button type="submit" class="w-full bg-purple-600 text-white p-2 rounded hover:bg-purple-700">ورود</button>
    </form>
  </div>
</body>
</html>
