<?php
require_once __DIR__ . "/ketnoi.php";
$tukhoa = trim($_GET['tukhoa'] ?? '');
$result = false;
if ($tukhoa !== '') {
    $mau = "%" . $tukhoa . "%";
    $stmt = $conn->prepare("SELECT id, tieu_de, tom_tat, anh, ngay_dang FROM baiviet WHERE tieu_de LIKE ? OR tom_tat LIKE ? OR noi_dung LIKE ? ORDER BY ngay_dang DESC");
    $stmt->bind_param("sss", $mau, $mau, $mau);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
<!DOCTYPE html><html lang="vi"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tìm kiếm - NEWS TODAY</title><link rel="stylesheet" href="css/style.css"></head><body>
<header class="header"><div class="container"><h1>NEWS TODAY</h1><p>Cập nhật tin tức mỗi ngày</p></div></header>
<nav class="nav"><div class="container"><a href="index.php">Trang chủ</a><a href="admin/dangnhap.php">Quản trị</a></div></nav>
<main class="container">
<form class="search-form" action="timkiem.php" method="get"><input type="search" name="tukhoa" value="<?= htmlspecialchars($tukhoa) ?>" placeholder="Nhập từ khóa cần tìm..." required><button type="submit">Tìm kiếm</button></form>
<h2 class="section-title">Kết quả: <?= htmlspecialchars($tukhoa) ?></h2>
<div class="news-grid">
<?php if ($tukhoa === ''): ?><p>Vui lòng nhập từ khóa.</p>
<?php elseif ($result && $result->num_rows): while ($row = $result->fetch_assoc()): ?>
<article class="news-card"><?php if (!empty($row['anh'])): ?><img src="images/<?= htmlspecialchars(basename($row['anh'])) ?>" alt="Ảnh bài viết"><?php else: ?><div class="image-placeholder">NEWS TODAY</div><?php endif; ?>
<div class="news-content"><h3><a href="chitiet.php?id=<?= (int)$row['id'] ?>"><?= htmlspecialchars($row['tieu_de']) ?></a></h3><p><?= htmlspecialchars($row['tom_tat'] ?? '') ?></p><a class="read-more" href="chitiet.php?id=<?= (int)$row['id'] ?>">Đọc tiếp →</a></div></article>
<?php endwhile; else: ?><p>Không tìm thấy bài viết phù hợp.</p><?php endif; ?>
</div></main><footer class="footer"><p>© 2026 NEWS TODAY</p></footer></body></html>
