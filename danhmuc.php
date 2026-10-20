<?php
require_once __DIR__ . "/ketnoi.php";
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id || $id < 1) { http_response_code(400); exit("Danh mục không hợp lệ."); }

$stmtDM = $conn->prepare("SELECT id, ten_danh_muc FROM danhmuc WHERE id=?");
$stmtDM->bind_param("i", $id);
$stmtDM->execute();
$danhMuc = $stmtDM->get_result()->fetch_assoc();
if (!$danhMuc) { http_response_code(404); exit("Không tìm thấy danh mục."); }

$stmt = $conn->prepare("SELECT id, tieu_de, tom_tat, anh, ngay_dang FROM baiviet WHERE danh_muc_id=? ORDER BY ngay_dang DESC");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html><html lang="vi"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($danhMuc['ten_danh_muc']) ?> - NEWS TODAY</title><link rel="stylesheet" href="css/style.css"></head><body>
<header class="header"><div class="container"><h1>NEWS TODAY</h1><p>Cập nhật tin tức mỗi ngày</p></div></header>
<nav class="nav"><div class="container"><a href="index.php">Trang chủ</a><a href="admin/dangnhap.php">Quản trị</a></div></nav>
<main class="container"><h2 class="section-title"><?= htmlspecialchars($danhMuc['ten_danh_muc']) ?></h2>
<div class="news-grid">
<?php if ($result->num_rows): while ($row = $result->fetch_assoc()): ?>
<article class="news-card">
<?php if (!empty($row['anh'])): ?><img src="images/<?= htmlspecialchars(basename($row['anh'])) ?>" alt="Ảnh bài viết"><?php else: ?><div class="image-placeholder">NEWS TODAY</div><?php endif; ?>
<div class="news-content"><h3><a href="chitiet.php?id=<?= (int)$row['id'] ?>"><?= htmlspecialchars($row['tieu_de']) ?></a></h3>
<p><?= htmlspecialchars($row['tom_tat'] ?? '') ?></p><a class="read-more" href="chitiet.php?id=<?= (int)$row['id'] ?>">Đọc tiếp →</a></div>
</article>
<?php endwhile; else: ?><p>Danh mục này chưa có bài viết.</p><?php endif; ?>
</div></main><footer class="footer"><p>© 2026 NEWS TODAY</p></footer></body></html>
