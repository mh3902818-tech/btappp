<?php
// Chạy file này một lần trên máy local để tạo tài khoản admin, sau đó xóa file.
require_once __DIR__ . "/ketnoi.php";
$tenDangNhap = "admin";
$matKhau = password_hash("Admin@123", PASSWORD_DEFAULT);
$hoTen = "Quản trị viên";
$vaiTro = "admin";
$stmt = $conn->prepare("SELECT id FROM nguoidung WHERE ten_dang_nhap=?");
$stmt->bind_param("s", $tenDangNhap);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    exit("Tài khoản admin đã tồn tại. Hãy xóa file tao_admin.php.");
}
$stmt = $conn->prepare("INSERT INTO nguoidung(ten_dang_nhap,mat_khau,ho_ten,vai_tro) VALUES(?,?,?,?)");
$stmt->bind_param("ssss", $tenDangNhap, $matKhau, $hoTen, $vaiTro);
if ($stmt->execute()) {
    echo "Tạo admin thành công.<br>Tên đăng nhập: admin<br>Mật khẩu: Admin@123<br>Hãy xóa file tao_admin.php ngay sau khi tạo tài khoản.";
} else {
    echo "Không thể tạo tài khoản.";
}
