# Changelog — VinaSite Theme

Theme WordPress độc lập của Vinasite Việt Nam, dùng chung cho nhiều website khách.
Quy ước phiên bản: sửa lỗi → tăng số cuối (1.0.1 → 1.0.2); thêm tính năng → 1.0 → 1.1; thay đổi lớn → 1.x → 2.0.

## [1.3.0] — 2026-07
- **Trang chủ mặc định VinaSite**: site mới cài giờ hiển thị trang giới thiệu giao diện VinaSite + dịch vụ của VinaSite (Hero → Tính năng theme → Dịch vụ → Gói dịch vụ → Liên hệ + form tư vấn), thay vì nội dung Công ty Luật Dragon.
- **Tùy chọn "VinaSite – Kiểu trang chủ"** trong Customizer: chọn `vinasite` (mặc định) hoặc `dragon` (trang chủ bespoke công ty luật). Site CŨ được tự động gán `dragon` một lần khi update (nhận diện qua theme_mods đã cấu hình) nên **không đổi giao diện, không cần làm gì**.
- Bỏ nội dung Dragon rò rỉ sang site khác: thẻ `<title>`/meta description trang chủ, schema `LegalService`, cột "Lĩnh vực hành nghề" và link chính sách `vanphongluatsu.com.vn` ở chân trang — nay chỉ hiện với preset `dragon`.
- Site chưa nhập điện thoại/Zalo/email: ẩn topbar, nút gọi nổi và nút Zalo thay vì render link rỗng (`tel:`, `zalo.me/`).
- Form tư vấn dùng chung handler sẵn có (nonce, bẫy bot, chống spam theo IP); email báo về hiển thị đúng tên dịch vụ VinaSite.
- **Đồng bộ màu theo logo VinaSite** (chỉ áp dụng cho preset `vinasite`, toàn site chứ không riêng trang chủ): xanh `#1e5aa8` làm màu chính, xanh logo `#4790cd` màu phụ, đỏ logo `#e51e22` màu nhấn, vàng tagline `#ffd100` cho chữ/icon trên nền xanh; nền và viền chuyển sang tông lạnh. Màu gốc đo trực tiếp từ file logo (đỏ `#ed2024`, xanh `#4790cd`) rồi chỉnh sắc độ để mọi cặp chữ/nền đạt WCAG AA 4.5:1 — dùng thẳng màu gốc thì chữ trắng trên xanh chỉ đạt 3.4:1 và trên đỏ 4.35:1. Site tự chọn màu ở Customizer vẫn được ưu tiên.
- File mới: `inc/vinasite-home.php`, `template-parts/vinasite/*.php`, `assets/dragon/css/vinasite-home.css`.

## [1.2.4] — 2026-07
- Làm mới Bảng điều khiển: hero gradient + logo, thanh tiến độ thiết lập (%), thẻ card icon tròn + hover, khu Liên kết nhanh.

## [1.2.3] — 2026-07
- Icon menu VinaSite dùng ẢNH LOGO thật (chữ V swoosh xanh + đỏ).

## [1.2.2] — 2026-07
- Icon menu VinaSite dùng chữ "V" hai màu (xanh + đỏ) theo logo, thay vì V xám.

## [1.2.1] — 2026-07 (sửa lỗi)
- Gộp menu admin: bỏ menu "VinaSite" trùng (do file branding cũ tạo). Trang "Giới thiệu Vinasite" thành sub-mục của Bảng điều khiển. Chỉ còn 1 menu VinaSite.

## [1.2.0] — 2026-07
- **Bảng điều khiển VinaSite** (menu admin riêng, kiểu Flatsome): Bảng điều khiển (welcome + checklist thiết lập), Tùy chọn giao diện (mở Customizer), Bắt đầu nhanh (hướng dẫn dựng site), Nhật ký cập nhật. Giúp theme giống sản phẩm premium, dễ cấu hình.

## [1.1.1] — 2026-07 (bản test cơ chế tự-update)
- Chỉ tăng version để kiểm thử luồng cập nhật + xác nhận update KHÔNG làm mất cấu hình (theme_mods/menu/option giữ nguyên). Không đổi giao diện.

## [Đang phát triển — Bước 1: nền tảng đa-site]
- **Theme tự cập nhật từ GitHub** (Bước 3): nhúng thư viện Plugin Update Checker (`inc/plugin-update-checker/`) + `inc/vinasite-theme-updater.php` — KHÔNG cần plugin ngoài (bỏ Git Updater). Repo Public nên không cần token. Đọc version từ nhánh `main`. Bump theme lên 1.1.0.
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
