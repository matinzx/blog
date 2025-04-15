<?php
$conn = new mysqli("localhost", "root", "", "myblog_db");
if ($conn->connect_error) {
    die("مشکل در اتصال: " . $conn->connect_error);
}
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");

include 'includes/header.php';
?>

<h2 class="text-3xl font-bold mb-6 text-blue-300 text-center">آخرین پست‌ها</h2>

<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
<?php while ($row = $result->fetch_assoc()): ?>
    <article class="bg-white/10 border border-white/10 backdrop-blur-sm text-white p-4 rounded-2xl shadow hover:shadow-lg transition-all duration-300">
        <img src="<?= htmlspecialchars($row['image']) ?>" alt="تصویر پست" class="w-full h-48 object-cover rounded-xl mb-4">
        <h3 class="text-xl font-semibold mb-2 text-blue-300">
            <a href="post.php?id=<?= $row['id'] ?>" class="hover:underline">
                <?= htmlspecialchars($row['title']) ?>
            </a>
        </h3>
        <p class="text-gray-300 mb-3"><?= nl2br(htmlspecialchars(substr($row['content'], 0, 100))) ?>...</p>
        <div class="flex justify-between items-center text-sm">
            <a href="post.php?id=<?= $row['id'] ?>" class="text-blue-400 hover:text-blue-200">ادامه مطلب</a>
            <span class="text-gray-500 text-xs"><?= $row['created_at'] ?></span>
        </div>
    </article>
<?php endwhile; ?>
</div>

<?php
$conn->close();
include 'includes/footer.php';
?>
