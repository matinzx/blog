<?php
session_start();

// اگر کاربر وارد نشده باشد، به صفحه ورود هدایت می‌شود.
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require 'db.php'; // فایل اتصال به MySQL

// تعیین صفحه فعلی بر اساس پارامتر GET (به‌طور پیش‌فرض داشبورد)
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$message = '';

// در صورت انتخاب بخش "رزومه"، در هنگام ارسال فرم (POST) اطلاعات به‌روزرسانی می‌شود.
if ($page === 'resume') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name         = $_POST['name'] ?? '';
        $englishName  = $_POST['englishName'] ?? '';
        $profileImage = $_POST['profileImage'] ?? '';
        $aboutMe      = $_POST['aboutMe'] ?? '';
        $contactEmail = $_POST['contactEmail'] ?? '';

        $sql = "UPDATE resume_info SET name = ?, englishName = ?, profileImage = ?, aboutMe = ?, contactEmail = ? WHERE id = 1";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$name, $englishName, $profileImage, $aboutMe, $contactEmail])) {
            $message = "اطلاعات به‌روزرسانی شد.";
        } else {
            $message = "خطا در به‌روزرسانی اطلاعات.";
        }
    }
    // خواندن اطلاعات فعلی رزومه از جدول resume_info
    $stmt = $pdo->query("SELECT * FROM resume_info LIMIT 1");
    $resume_info = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>
    پنل مدیریت - <?php echo ($page === 'dashboard') ? "داشبورد" : (($page === 'resume') ? "ویرایش رزومه" : "پنل مدیریت"); ?>
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* استایل‌های سفارشی برای اسکرول در حالت تاریک */
    ::-webkit-scrollbar {
      width: 8px;
    }
    ::-webkit-scrollbar-track {
      background: #2d3748;
    }
    ::-webkit-scrollbar-thumb {
      background: #4a5568;
      border-radius: 4px;
    }
  </style>
</head>
<body class="bg-gray-900 text-gray-300">
  <div class="flex h-screen">
    <!-- Sidebar (ناوبری سمت چپ) -->
    <div class="w-64 bg-gray-800 p-6">
      <h2 class="text-white text-2xl font-bold mb-8">پنل مدیریت</h2>
      <nav class="space-y-2">
        <a href="admin.php?page=dashboard" class="block py-2 px-4 rounded hover:bg-gray-700 <?php echo ($page === 'dashboard') ? 'bg-gray-700' : ''; ?>">داشبورد</a>
        <a href="admin.php?page=resume" class="block py-2 px-4 rounded hover:bg-gray-700 <?php echo ($page === 'resume') ? 'bg-gray-700' : ''; ?>">رزومه</a>
        <!-- سایر منوها (در صورت نیاز) -->
      </nav>
      <div class="mt-8">
        <a href="logout.php" class="text-purple-400 hover:underline">خروج</a>
      </div>
    </div>
    <!-- Main Content (محتوای اصلی) -->
    <div class="flex-1 p-8 overflow-auto">
      <!-- نوار بالایی (هدر) -->
      <div class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-bold">
          <?php 
            if ($page === 'dashboard') {
              echo 'داشبورد';
            } elseif ($page === 'resume') {
              echo 'ویرایش رزومه';
            } else {
              echo 'پنل مدیریت';
            }
          ?>
        </h1>
      </div>
      <!-- محتوای صفحه بر اساس انتخاب در منو -->
      <?php if ($page === 'dashboard'): ?>
        <div class="bg-gray-800 p-6 rounded shadow">
          <p>به پنل مدیریت خوش آمدید. از منوی کناری می‌توانید بخش‌های مختلف را انتخاب کنید.</p>
        </div>
      <?php elseif ($page === 'resume'): ?>
        <div class="bg-gray-800 p-6 rounded shadow">
          <?php if ($message): ?>
            <div class="bg-green-600 text-white p-2 rounded mb-4">
              <?php echo htmlspecialchars($message); ?>
            </div>
          <?php endif; ?>
          <form method="POST" action="admin.php?page=resume">
            <div class="mb-4">
              <label class="block mb-1 font-semibold">نام فارسی:</label>
              <input type="text" name="name" value="<?php echo htmlspecialchars($resume_info['name'] ?? ''); ?>" class="w-full p-2 bg-gray-700 border border-gray-600 rounded" required>
            </div>
            <div class="mb-4">
              <label class="block mb-1 font-semibold">نام انگلیسی:</label>
              <input type="text" name="englishName" value="<?php echo htmlspecialchars($resume_info['englishName'] ?? ''); ?>" class="w-full p-2 bg-gray-700 border border-gray-600 rounded">
            </div>
            <div class="mb-4">
              <label class="block mb-1 font-semibold">تصویر پروفایل (مسیر):</label>
              <input type="text" name="profileImage" value="<?php echo htmlspecialchars($resume_info['profileImage'] ?? ''); ?>" class="w-full p-2 bg-gray-700 border border-gray-600 rounded">
            </div>
            <div class="mb-4">
              <label class="block mb-1 font-semibold">درباره من:</label>
              <textarea name="aboutMe" rows="5" class="w-full p-2 bg-gray-700 border border-gray-600 rounded"><?php echo htmlspecialchars($resume_info['aboutMe'] ?? ''); ?></textarea>
            </div>
            <div class="mb-4">
              <label class="block mb-1 font-semibold">ایمیل تماس:</label>
              <input type="email" name="contactEmail" value="<?php echo htmlspecialchars($resume_info['contactEmail'] ?? ''); ?>" class="w-full p-2 bg-gray-700 border border-gray-600 rounded">
            </div>
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded">ذخیره تغییرات</button>
          </form>
        </div>
      <?php else: ?>
        <p>صفحه مورد نظر یافت نشد.</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
