<?php
$data_file = 'data.json';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // دریافت داده از فرم
    $json_content = $_POST['json_content'] ?? '';
    
    // اعتبارسنجی JSON ورودی
    if (json_decode($json_content) === null && json_last_error() !== JSON_ERROR_NONE) {
        $message = 'فرمت JSON معتبر نمی‌باشد.';
    } else {
        // ذخیره محتوای جدید در فایل
        if(file_put_contents($data_file, $json_content)) {
            $message = 'تغییرات با موفقیت ذخیره شدند.';
        } else {
            $message = 'خطا در ذخیره تغییرات.';
        }
    }
}

// خواندن محتوای فعلی فایل JSON
$current_json = file_get_contents($data_file);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>پنل مدیریت</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800 p-8">
  <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">پنل مدیریت - ویرایش رزومه</h1>
    
    <?php if($message): ?>
      <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
        <?php echo htmlspecialchars($message); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="admin.php">
      <label class="block mb-2 font-semibold">محتوای JSON:</label>
      <textarea name="json_content" rows="20" class="w-full p-2 border border-gray-300 rounded"><?php echo htmlspecialchars($current_json); ?></textarea>
      <button type="submit" class="mt-4 bg-purple-600 text-white py-2 px-4 rounded hover:bg-purple-700">
        ذخیره تغییرات
      </button>
    </form>
  </div>
</body>
</html>
