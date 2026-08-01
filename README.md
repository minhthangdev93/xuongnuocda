# Nước Đá Sạch 168 — OceanWP Child Theme

Child theme WordPress cho website **nuocdasach168** / **xuongnuocda.com**, xây trên [OceanWP](https://oceanwp.org/) + WooCommerce.

**Phiên bản:** 1.9.1

## Yêu cầu

| Thành phần | Ghi chú |
|------------|---------|
| WordPress | 6.x trở lên |
| PHP | 7.4+ (khuyến nghị 8.x) |
| Theme cha | **OceanWP** (bản mới nhất) |
| Plugin | WooCommerce (shop & sản phẩm) |

## Cài đặt

1. Clone repo vào thư mục theme WordPress:

```bash
cd wp-content/themes
git clone <URL_GITHUB> xuongnuocda
```

2. Vào **Giao diện → Giao diện** → kích hoạt **OceanWP Child Theme**.

3. Tạo / gán các trang với template tương ứng:

| Trang | Template |
|-------|----------|
| Trang chủ | `Trang chủ 168` hoặc đặt làm Front Page |
| Giới thiệu | `Giới thiệu 168` |
| Liên hệ | `Liên hệ 168` |
| Cửa hàng | WooCommerce → `/san-pham/` |

4. Upload ảnh media vào `wp-content/uploads/` (theme tham chiếu qua `content_url()`, không bundle ảnh trong repo).

## Cấu trúc thư mục

```
xuongnuocda/
├── assets/css/          # CSS modules (01–10)
├── inc/
│   ├── site-data.php    # Hotline, cửa hàng, gallery
│   ├── form-helpers.php # AJAX form liên hệ
│   ├── review-spam.php  # Chống spam đánh giá SP
│   └── performance.php  # Tối ưu Lighthouse
├── js/                  # sticky-header, contact, lightbox…
├── partials/            # Page header tùy chỉnh
├── template-parts/      # Nội dung trang chủ / GT / LH / footer
├── templates/           # Page templates
├── woocommerce/         # Override WC (card, giá Zalo, related)
├── functions.php
├── header.php
├── front-page.php
└── style.css
```

## Cấu hình dữ liệu site

Chỉnh sửa `inc/site-data.php`:

- Hotline, Zalo, email
- Thông tin công ty (mã số thuế khi có)
- Danh sách cửa hàng
- Đường dẫn ảnh nhà máy / chứng nhận (thư mục `uploads/2026/06`)

## Tính năng chính

- Landing trang chủ 12 section (hero LCP, gallery, CTA Zalo)
- Footer & form báo giá AJAX
- WooCommerce: card sản phẩm tùy chỉnh, giá 0đ → nút Zalo, bỏ giỏ hàng single
- Page header + breadcrumb redesign
- Chống spam đánh giá sản phẩm
- Tối ưu performance: tắt Google Fonts, defer JS, async CSS, preload LCP

## Triển khai production

1. **Backup** site trước khi deploy.
2. Pull / upload theme lên `wp-content/themes/xuongnuocda/`.
3. Xóa cache (plugin cache + CDN nếu có).
4. Kiểm tra: trang chủ, shop, single product, form liên hệ, mobile menu.

### Khuyến nghị server (Lighthouse)

- Plugin cache: LiteSpeed Cache hoặc WP Rocket
- Nén Brotli/Gzip, HTTP/2
- Ảnh WebP trong media library
- Object cache nếu TTFB cao

## Không commit lên Git

- `wp-config.php`, `.env`, credentials
- `wp-content/uploads/` (ảnh media)
- Plugin WordPress (cài riêng trên từng môi trường)
- Theme cha OceanWP (cài từ WordPress.org / OceanWP)

## License

Child theme dựa trên OceanWP Child Theme sample. Mã tùy chỉnh cho dự án Nước Đá Sạch 168.
