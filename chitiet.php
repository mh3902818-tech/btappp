<?php
require_once __DIR__ . "/ketnoi.php";
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id || $id < 1) { http_response_code(400); exit("Mã bài viết không hợp lệ."); }

$stmt = $conn->prepare("SELECT b.*, d.ten_danh_muc FROM baiviet b LEFT JOIN danhmuc d ON b.danh_muc_id=d.id WHERE b.id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$baiViet = $stmt->get_result()->fetch_assoc();
if (!$baiViet) { http_response_code(404); exit("Không tìm thấy bài viết."); }
?>
<!DOCTYPE html><html lang="vi"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($baiViet['tieu_de']) ?></title><link rel="stylesheet" href="css/style.css">
</head><body>
<header class="header"><div class="container"><h1>NEWS TODAY</h1><p>Cập nhật tin tức mỗi ngày</p></div></header>
<nav class="nav"><div class="container"><a href="index.php">Trang chủ</a><a href="admin/dangnhap.php">Quản trị</a></div></nav>
<main class="container"><article class="article">
<p class="category-label"><?= htmlspecialchars($baiViet['ten_danh_muc'] ?? 'Chưa phân loại') ?></p>
<h1><?= htmlspecialchars($baiViet['tieu_de']) ?></h1>
<p class="muted">Ngày đăng: <?= htmlspecialchars($baiViet['ngay_dang']) ?></p>
<?php if (!empty($baiViet['anh'])): ?><img class="article-image" src="images/<?= htmlspecialchars(basename($baiViet['anh'])) ?>" alt="Ảnh bài viết"><?php endif; ?>
<h3><?= htmlspecialchars($baiViet['tom_tat'] ?? '') ?></h3>
<div class="article-content"><?= htmlspecialchars($baiViet['noi_dung']) ?></div>
<p><a class="read-more" href="index.php">← Quay lại trang chủ</a></p>
</article></main>
<footer class="footer"><p>© 2026 NEWS TODAY</p></footer></body></html>
