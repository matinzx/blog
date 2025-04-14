<?php
$conn = new mysqli("localhost", "root", "", "myblog_db");

if ($conn->connect_error) {
    die("مشکل در اتصال: " . $conn->connect_error);
}

// گرفتن ID از URL و امن کردنش
$id = (int) $_GET['id'];

// اجرای کوئری برای گرفتن پست خاص
$result = $conn->query("SELECT * FROM posts WHERE id = $id");

// اگر پستی پیدا نشد
if ($result->num_rows == 0) {
    die("پست مورد نظر پیدا نشد.");
}

$post = $result->fetch_assoc();

include 'includes/header.php';
?>

<article class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-3xl font-bold mb-4"><?= htmlspecialchars($post['title']) ?></h2>
    <p class="text-gray-600 mb-4">منتشر شده در: <?= $post['created_at'] ?></p>
    <div class="text-gray-800 leading-relaxed">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </div>
    <a href="index.php" class="inline-block mt-4 text-blue-500 hover:underline">بازگشت به صفحه اصلی</a>
</article>

<?php
$conn->close();
include 'includes/footer.php';
?>
