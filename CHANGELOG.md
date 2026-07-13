# Changelog — VinaSite Theme

Theme WordPress độc lập của Vinasite Việt Nam, dùng chung cho nhiều website khách.
Quy ước phiên bản: sửa lỗi → tăng số cuối (1.0.1 → 1.0.2); thêm tính năng → 1.0 → 1.1; thay đổi lớn → 1.x → 2.0.

## [Đang phát triển — Bước 1: nền tảng đa-site]
- **Đóng gói sẵn plugin trong theme** (`inc/vinasite-bundled-plugin.php` + `inc/bundled/vinasite-google-indexing.zip`): kích hoạt theme → tự giải nén + kích hoạt plugin "Vinasite Google Indexing"; có nút "Cài & Kích hoạt" trong admin nếu chưa bật. Mảng `vinasite_bundled_plugins()` mở rộng được để bundle thêm plugin.
- **Dọn hardcode Dragon (5 bước) → theme option-driven:** (1) mã GA → Customizer `dragon_ga_ids`; (2) logo → `dragon_logo_url()` (custom_logo→option→tên site); (3) thông tin DN + URL ảnh mặc định → trung tính (site tự nhập); (4) menu header fallback + footer "Hỗ trợ" → WP Menu (vị trí `footer`); (5) tên công ty trong 6 trang giới thiệu → `dragon_brand()` (option `company_short`→`company_name`→tên site). Nội dung bespoke (testimonial/video) trong 6 trang landing để chuyển thành page content ở Bước 2 (block patterns).
- **Kiểm soát bản quyền (license-lite)** (`inc/vinasite-license.php`): nhắc nhở mềm theo tên miền được cấp phép (option `vinasite_licensed_domains`, rỗng = không giới hạn, không chặn site). Hàm `vinasite_is_licensed()` có filter — sẵn móc nâng cấp lên server cấp key (Freemius…) khi bán ra ngoài. Kiểm soát cập nhật thật vẫn dựa vào repo Private + Git Updater.
- **Màu & font theo từng site** (`inc/dragon/design-tokens.php`): mục Customizer "VinaSite – Màu sắc & Phông chữ". Chủ site chọn Màu chính + Màu nhấn → tự suy ra tông đậm/nhạt/hover (PHP color-mix); chọn 1 trong 6 font (Be Vietnam Pro/Inter/Roboto/Montserrat/Open Sans/Lora). Chỉ ghi đè khi có tùy chỉnh → site cũ giữ nguyên.

## [1.0.1] — 2026-07 (baseline trên Git)
Bản khởi tạo đưa lên GitHub làm mốc gốc.

**Có sẵn**
- Kiến trúc theme độc lập: `header` / `footer`, `front-page` + các section trang chủ, `single` / `archive` / `page` / `search` / `404`.
- Hệ icon SVG nội tuyến (`inc/dragon/icons.php`), design system màu/typography.
- Customizer "Dragon – Thông tin & Trang chủ" (SĐT, địa chỉ, logo, ảnh, MXH…).
- Schema `LegalService` + `FAQPage`; form tư vấn AJAX có chống spam.

**Bổ sung gần đây (đã gộp vào baseline)**
- Icon mạng xã hội chuẩn ở footer (Facebook, YouTube).
- Ảnh đại diện cho khối "Bài liên quan" + tăng hiển thị 10 bài.
- Ghim (sticky) khối CTA "Luật sư tư vấn" ở sidebar khi cuộn.
- Schema thương hiệu chuyển sang Organization + sameAs mạng xã hội.

## [Chưa làm — kế hoạch]
- Dọn hardcode để theme 100% option-driven (GA, logo, URL ảnh, menu, thông tin DN).
- Tách 6 trang landing bespoke ra khỏi theme lõi.
- Gắn header Git Updater để các site tự cập nhật.
