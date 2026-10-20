CREATE DATABASE IF NOT EXISTS website_tintuc
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE website_tintuc;

CREATE TABLE IF NOT EXISTS danhmuc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_danh_muc VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS nguoidung (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_dang_nhap VARCHAR(50) NOT NULL UNIQUE,
    mat_khau VARCHAR(255) NOT NULL,
    ho_ten VARCHAR(100),
    vai_tro VARCHAR(20) NOT NULL DEFAULT 'admin'
);

CREATE TABLE IF NOT EXISTS baiviet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tieu_de VARCHAR(255) NOT NULL,
    tom_tat TEXT,
    noi_dung LONGTEXT NOT NULL,
    anh VARCHAR(255) DEFAULT NULL,
    danh_muc_id INT DEFAULT NULL,
    tac_gia_id INT DEFAULT NULL,
    ngay_dang DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_baiviet_danhmuc FOREIGN KEY (danh_muc_id)
        REFERENCES danhmuc(id) ON DELETE SET NULL,
    CONSTRAINT fk_baiviet_nguoidung FOREIGN KEY (tac_gia_id)
        REFERENCES nguoidung(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS binhluan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bai_viet_id INT NOT NULL,
    ten_nguoi_binh_luan VARCHAR(100) NOT NULL,
    noi_dung TEXT NOT NULL,
    ngay_binh_luan DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_binhluan_baiviet FOREIGN KEY (bai_viet_id)
        REFERENCES baiviet(id) ON DELETE CASCADE
);

INSERT INTO danhmuc (ten_danh_muc)
SELECT 'Thời sự' WHERE NOT EXISTS (SELECT 1 FROM danhmuc WHERE ten_danh_muc='Thời sự');
INSERT INTO danhmuc (ten_danh_muc)
SELECT 'Công nghệ' WHERE NOT EXISTS (SELECT 1 FROM danhmuc WHERE ten_danh_muc='Công nghệ');
INSERT INTO danhmuc (ten_danh_muc)
SELECT 'Thể thao' WHERE NOT EXISTS (SELECT 1 FROM danhmuc WHERE ten_danh_muc='Thể thao');
INSERT INTO danhmuc (ten_danh_muc)
SELECT 'Giải trí' WHERE NOT EXISTS (SELECT 1 FROM danhmuc WHERE ten_danh_muc='Giải trí');
INSERT INTO danhmuc (ten_danh_muc)
SELECT 'Giáo dục' WHERE NOT EXISTS (SELECT 1 FROM danhmuc WHERE ten_danh_muc='Giáo dục');

INSERT INTO baiviet (tieu_de, tom_tat, noi_dung, anh, danh_muc_id)
SELECT 'Công nghệ AI đang thay đổi cuộc sống',
       'Trí tuệ nhân tạo đang được ứng dụng trong giáo dục, y tế và nhiều lĩnh vực.',
       'Trí tuệ nhân tạo (AI) đang phát triển nhanh chóng. Công nghệ này giúp con người xử lý dữ liệu, tự động hóa công việc và tạo ra nhiều phương thức học tập mới.',
       NULL, (SELECT id FROM danhmuc WHERE ten_danh_muc='Công nghệ' LIMIT 1)
WHERE NOT EXISTS (SELECT 1 FROM baiviet WHERE tieu_de='Công nghệ AI đang thay đổi cuộc sống');

INSERT INTO baiviet (tieu_de, tom_tat, noi_dung, anh, danh_muc_id)
SELECT 'Những xu hướng công nghệ nổi bật',
       'Nhiều công nghệ mới đang được nghiên cứu và ứng dụng rộng rãi.',
       'Điện toán đám mây, trí tuệ nhân tạo và các thiết bị thông minh đang góp phần thay đổi cách con người làm việc và giao tiếp.',
       NULL, (SELECT id FROM danhmuc WHERE ten_danh_muc='Công nghệ' LIMIT 1)
WHERE NOT EXISTS (SELECT 1 FROM baiviet WHERE tieu_de='Những xu hướng công nghệ nổi bật');

INSERT INTO baiviet (tieu_de, tom_tat, noi_dung, anh, danh_muc_id)
SELECT 'Tin tức thể thao hôm nay',
       'Các sự kiện thể thao thu hút sự quan tâm của đông đảo người hâm mộ.',
       'Thể thao tiếp tục là chủ đề được nhiều người quan tâm. Người hâm mộ theo dõi các giải đấu và thành tích của vận động viên.',
       NULL, (SELECT id FROM danhmuc WHERE ten_danh_muc='Thể thao' LIMIT 1)
WHERE NOT EXISTS (SELECT 1 FROM baiviet WHERE tieu_de='Tin tức thể thao hôm nay');
