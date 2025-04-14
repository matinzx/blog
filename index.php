<?php
// اتصال به دیتابیس
$conn = new mysqli("localhost", "root", "", "myblog_db");

// بررسی اتصال
if ($conn->connect_error) {
    die("مشکل در اتصال: " . $conn->connect_error);
}

// خواندن همه پست‌ها
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");

// اضافه کردن هدر
include 'includes/header.php';
?>

<h2 class="text-2xl font-bold mb-4">پست‌های اخیر</h2>

<?php while ($row = $result->fetch_assoc()): ?>
    <article class="bg-white p-4 rounded-lg shadow mb-4">
        <h3 class="text-xl font-semibold mb-2">
            <a href="post.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">
                <?= htmlspecialchars($row['title']) ?>
            </a>
        </h3>
        <p class="text-gray-700"><?= nl2br(htmlspecialchars(substr($row['content'], 0, 150))) ?>...</p>
        <a href="post.php?id=<?= $row['id'] ?>" class="text-sm text-blue-500 hover:underline">ادامه مطلب</a>
    </article>
<?php endwhile; ?>

<?php
// بستن دیتابیس و اضافه کردن فوتر
$conn->close();
include 'includes/footer.php';
?>
