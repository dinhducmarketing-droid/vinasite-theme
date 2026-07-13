# Changelog — VinaSite Theme

Theme WordPress độc lập của Vinasite Việt Nam, dùng chung cho nhiều website khách.
Quy ước phiên bản: sửa lỗi → tăng số cuối (1.0.1 → 1.0.2); thêm tính năng → 1.0 → 1.1; thay đổi lớn → 1.x → 2.0.

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
