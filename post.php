<?php
$conn = new mysqli("localhost", "root", "", "myblog_db");
if ($conn->connect_error) {
    die("مشکل در اتصال: " . $conn->connect_error);
}
$id = (int) $_GET['id'];
$result = $conn->query("SELECT * FROM posts WHERE id = $id");

if ($result->num_rows == 0) {
    die("پست مورد نظر پیدا نشد.");
}

$post = $result->fetch_assoc();
include 'includes/header.php';
?>

<article class="bg-white/10 backdrop-blur border border-white/10 p-8 rounded-3xl shadow-xl mx-auto max-w-3xl text-white">
    <h2 class="text-4xl font-extrabold mb-4 text-blue-400"><?= htmlspecialchars($post['title']) ?></h2>
    <p class="text-sm text-gray-400 mb-6">منتشر شده در: <?= $post['created_at'] ?></p>
    <div class="text-gray-200 leading-relaxed text-lg">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </div>
    <a href="index.php" class="inline-block mt-8 text-blue-400 hover:text-blue-200 transition-colors">← بازگشت</a>
</article>

<?php
$conn->close();
include 'includes/footer.php';
?>
