# LiteSpeed Cache — cấu hình Nước Đá Sạch 168

## Có cần bật không?

**Có.** Hosting dùng LiteSpeed (`lscache`). Plugin **LiteSpeed Cache** cung cấp page cache server-level — theme không thay thế được phần này.

Theme đã tự tối ưu: critical CSS, async CSS, defer JS, preload LCP, lazy có chọn lọc. Cấu hình dưới đây **bật cache + WebP**, **tắt** các tối ưu trùng (combine CSS/JS, async CSS, defer JS, Guest Mode).

## Cài đặt nhanh

1. **Plugins → Kích hoạt** LiteSpeed Cache (7.x).
2. **LiteSpeed Cache → Toolbox → Import / Export**.
3. Import file trong theme:

   `wp-content/themes/oceanwp-child-theme-master/config/LSCWP_NuocDa168_v2.data`

   (sau deploy Git: cùng path trên hosting)

4. **LiteSpeed Cache → Toolbox → Purge All**.
5. (Tuỳ chọn) **Image Optimization → Pull / Optimize** để tạo WebP.

## Điểm khớp với theme

| Mục LSCWP | Giá trị | Lý do |
|-----------|---------|--------|
| Page Cache | Bật | TTFB / LCP |
| Guest Mode / Guest Optm | Tắt | Tránh đụng critical CSS theme |
| CSS Combine / UCSS / Async CSS | Tắt | Theme đã async + inline critical |
| JS Combine / JS Defer | Tắt | Theme đã defer riêng |
| CSS/JS Minify | Bật | An toàn, giảm byte |
| Lazy Load | Bật | Loại trừ `h168-hero__bg`, `no-lazy`, `skip-lazy`, `litespeed-no-lazy`, `wp-post-image` |
| WebP | Bật | Ảnh nhẹ hơn mobile |
| Exclude cache | Giỏ / thanh toán / tài khoản | WooCommerce |

## Không bật thêm

- Critical CSS / CCSS của LSCWP  
- Unique CSS (UCSS)  
- JS Delay / Guest Optimization  
- Instant Click  

## Sau mỗi lần Deploy Git

**LiteSpeed Cache → Purge All** (hoặc Purge → Purge All Pages).
