<?php
require_once __DIR__ . "/ketnoi.php";

$sql = "SELECT b.id, b.tieu_de, b.tom_tat, b.anh, b.ngay_dang, d.ten_danh_muc
        FROM baiviet b
        LEFT JOIN danhmuc d ON b.danh_muc_id = d.id
        ORDER BY b.ngay_dang DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NEWS TODAY - Tin tức mới nhất</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="header"><div class="container">
    <h1>NEWS TODAY</h1><p>Cập nhật tin tức mỗi ngày</p>
</div></header>
<nav class="nav"><div class="container">
    <a href="index.php">Trang chủ</a>
    <?php
    $menus = $conn->query("SELECT id, ten_danh_muc FROM danhmuc ORDER BY id");
    while ($menu = $menus->fetch_assoc()):
    ?>
        <a href="danhmuc.php?id=<?= (int)$menu['id'] ?>"><?= htmlspecialchars($menu['ten_danh_muc']) ?></a>
    <?php endwhile; ?>
    <a href="admin/dangnhap.php">Quản trị</a>
</div></nav>
<main class="container">
    <form class="search-form" action="timkiem.php" method="get">
        <input type="search" name="tukhoa" placeholder="Nhập từ khóa cần tìm..." required>
        <button type="submit">Tìm kiếm</button>
    </form>
    <h2 class="section-title">Tin tức mới nhất</h2>
    <div class="news-grid">
    <?php if ($result && $result->num_rows): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <article class="news-card">
                <?php if (!empty($row['anh'])): ?>
                    <img src="images/<?= htmlspecialchars(basename($row['anh'])) ?>" alt="Ảnh bài viết">
                <?php else: ?>
                    <div class="image-placeholder">NEWS TODAY</div>
                <?php endif; ?>
                <div class="news-content">
                    <small><?= htmlspecialchars($row['ten_danh_muc'] ?? 'Chưa phân loại') ?></small>
                    <h3><a href="chitiet.php?id=<?= (int)$row['id'] ?>"><?= htmlspecialchars($row['tieu_de']) ?></a></h3>
                    <p><?= htmlspecialchars($row['tom_tat'] ?? '') ?></p>
                    <a class="read-more" href="chitiet.php?id=<?= (int)$row['id'] ?>">Đọc tiếp →</a>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Chưa có bài viết nào.</p>
    <?php endif; ?>
    </div>
</main>
<footer class="footer"><p>© 2026 NEWS TODAY - Website tin tức PHP</p></footer>
</body></html>
