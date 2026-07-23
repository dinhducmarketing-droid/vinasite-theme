# Changelog — VinaSite Theme

Theme WordPress độc lập của Vinasite Việt Nam, dùng chung cho nhiều website khách.
Quy ước phiên bản: sửa lỗi → tăng số cuối (1.0.1 → 1.0.2); thêm tính năng → 1.0 → 1.1; thay đổi lớn → 1.x → 2.0.

## [1.6.0] — 2026-07 (Bước 2 – phần 1: bộ dựng trang kéo-thả bằng Gutenberg)
- **`theme.json`**: bảng màu trong trình soạn thảo block trỏ về biến `--dragon-*` → khách chọn màu trong editor là **đúng màu thương hiệu từng site** (theo Customizer), tắt bảng màu mặc định WP + màu tự do để không chọn lệch nhận diện; font theo site; cỡ chữ chuẩn hoá; layout 820px/1200px; nút block mặc định theo màu chính.
- **4 Block Patterns đầu tiên** (nhóm "VinaSite" trong nút "+" của editor): Hero trang chủ, Lưới dịch vụ (6 card), FAQ accordion (block Details — không cần JS), Dải CTA. Chèn → sửa chữ/ảnh trực tiếp; nội dung lưu database nên update theme không đụng tới.
- Token màu/font của site được nạp vào canvas editor (`block_editor_settings_all`) để xem trước đúng màu; tách helper `dragon_design_tokens_css()` dùng chung frontend + editor.
- File mới: `theme.json`, `inc/vinasite-patterns.php`, `assets/dragon/css/vinasite-patterns.css` (nhẹ, nạp toàn site + editor).
- Kiểm chứng thật trên noithathaven.com: 4/4 pattern đăng ký, trang test render đủ (hero + 6 card + 4 FAQ + CTA), biến preset `--wp--preset--color--vs-primary` trỏ đúng `--dragon-primary`, trang có sẵn không ảnh hưởng, 0 lỗi. Đã dọn trang test.

## [1.5.0] — 2026-07 (theme đa năng — tách hẳn nội dung hãng luật)
- **Theme cha giờ 100% generic, cài được cho mọi lĩnh vực.** Toàn bộ nội dung chuyên biệt Công ty Luật Dragon (trang chủ dragon, 15 section `template-parts/home/*`, 6 trang landing `page-*.php`, dữ liệu lĩnh vực/hero/FAQ, schema `LegalService`, tiêu đề hãng luật) đã **tách sang child theme riêng `vanphong-dragon`** cho vanphongluatsu.com.vn.
- Cơ chế: theme cha định nghĩa `dragon_practice_areas()` / `dragon_hero_slides()` / `dragon_faq_items()` trả về `apply_filters(...)` rỗng; child bơm dữ liệu qua filter (không khai báo lại hàm → không lỗi trùng hàm). Schema/tiêu đề hãng luật chuyển sang child.
- Kiểu trang chủ theme cha còn 2: `vinasite` (mặc định) | `content`. Bỏ preset `dragon`. Nội dung theo ngành do child ghi đè `front-page.php`.
- `front-page.php`, `footer.php`, `single.php`, `ajax.php`, `schema.php`, `customizer.php`, `bootstrap.php`, `vinasite-home.php` — gỡ mọi chuỗi hãng luật hiển thị cho khách; footer/single dùng option (`side_cta_*`, `privacy_url`, `terms_url`, `footer_areas_title`, `single_cta_heading`) với mặc định trung tính; bootstrap nạp CSS trang landing qua filter `vinasite_home_css_pages` thay vì hardcode slug.
- Kiểm chứng thật: migrate vanphongluatsu.com.vn (site đang chạy) → child `vanphong-dragon` + parent 1.5.0. Trang chủ **58 section giống hệt trước/sau**, schema LegalService/FAQPage = 1 (không trùng), 6 trang landing render đủ nội dung, 0 lỗi. Parent 1.5.0 cũng chạy đúng trên child theme khác (noithathaven.com — Nội Thất AT Haven).
- Chuỗi "Dragon" còn lại trong theme cha chỉ là **codename nội bộ của design system** (prefix `dragon_`, class `dragon-*`), không phải nội dung hãng luật.

## [1.4.2] — 2026-07
- **Thay Easy Table of Contents bằng plugin tự viết "Vinasite Mục Lục"** (1.0.0, 100% thương hiệu VinaSite — viết mới hoàn toàn, không dùng code của Easy Table of Contents). Tự tạo mục lục từ tiêu đề h2–h6, gắn id neo, cuộn mượt, thu gọn được, đánh số; chèn tự động hoặc bằng shortcode `[vinasite_toc]`. CSS/JS nội tuyến, không phụ thuộc thư viện ngoài. Đóng gói `inc/bundled/vinasite-toc.zip`, thay slot easy-table-of-contents trong danh sách plugin tự cài.
- Kiểm chứng thật trên noithathaven.com: cài + kích hoạt OK; bài viết 4 tiêu đề → mục lục render đúng, link neo khớp id tự sinh (kể cả tiếng Việt có dấu).

## [1.4.1] — 2026-07
- Thêm **Vinasite Light Star Ratings** (1.0.0) vào nhóm plugin tự cài khi kích hoạt theme — plugin tự viết, thay thế nhẹ cho kk Star Ratings (giữ nguyên shortcode/AJAX/post meta cũ). Đóng gói zip trong `inc/bundled/`. Kiểm chứng cài + kích hoạt thật trên noithathaven.com.

## [1.4.0] — 2026-07
- **Cài sẵn plugin khuyến nghị khi kích hoạt theme.** Kích hoạt theme lần đầu → tự cài + bật: LiteSpeed Cache, Easy Table of Contents, Contact Form 7, Advanced Editor Tools (tải từ WordPress.org), cùng Call By Vinasite.com.vn và Vinasite Google Indexing (đóng gói kèm theme).
- Plugin WordPress.org **tải trực tiếp từ kho theo slug** (`plugins_api` + `Plugin_Upgrader`), luôn lấy bản mới nhất và WP tự cập nhật sau — KHÔNG nhồi zip vào theme (tránh đóng băng bản cũ dính lỗ hổng và phình repo). Chỉ plugin tự viết mới bundle zip.
- **WooCommerce KHÔNG tự cài** — chỉ hiện nút "Cài WooCommerce" trong thông báo admin, vì không phải site nào cũng bán hàng.
- Site đang chạy cập nhật theme sẽ KHÔNG bị tự cài thêm (hook `after_switch_theme` chỉ chạy lúc bật theme). Thay vào đó có **thông báo trong admin** liệt kê plugin còn thiếu + nút "Cài & kích hoạt tất cả" (có thể ẩn thông báo theo từng người dùng).
- Kiểm chứng thật: cơ chế tải từ WordPress.org chạy đúng trên noithathaven.com (cài Easy Table of Contents 2.0.85). Lưu ý kỹ thuật: `plugins_api` trả link ở trường `download_link` (không phải `download_url`).
- Viết lại `inc/vinasite-bundled-plugin.php` thành trình cài plugin khuyến nghị thống nhất (2 nguồn: wporg + bundled).

## [1.3.6] — 2026-07
- Plugin kèm theme **"Vinasite Google Indexing" nâng lên 1.2**: nhúng Plugin Update Checker + header `Update URI` → plugin **tự cập nhật từ GitHub** như theme. Trước đây plugin chỉ được cài lúc kích hoạt theme và không bao giờ tự cập nhật, nên các site đang lệch nhau (vanphongluatsu 1.1, vietnhatsknn 1.0, noithathaven 1.0). Mã nguồn tách ra repo riêng `vinasite-google-indexing`.
- Zip đóng gói `inc/bundled/vinasite-google-indexing.zip` dựng lại từ bản 1.2 để site cài mới có sẵn cơ chế tự cập nhật.

## [1.3.5] — 2026-07 (sửa hồi quy trên site công ty luật)
- `single.php` bản "gỡ chất luật sư" (lấy từ site di cư ở 1.3.2) làm đổi chữ trên chính vanphongluatsu.com.vn: "Cần tư vấn về vấn đề pháp lý này?" → "Cần tư vấn thêm về nội dung này?", "Luật sư Dragon tiếp nhận" → "Công ty Luật Dragon tiếp nhận", sidebar "Luật sư tư vấn" → "Tư vấn miễn phí". Chữ trung tính đúng cho site bán đá/quan trắc nhưng SAI với văn phòng luật. Nay mặc định theo preset: `dragon` giữ nguyên chữ cũ, site khác dùng chữ trung tính; site nào muốn khác thì nhập `side_cta_title`/`side_cta_text` ở Customizer.
- Phát hiện khi cập nhật thật vanphongluatsu.com.vn 1.2.4 → 1.3.4 rồi so sánh trước/sau.

## [1.3.4] — 2026-07 (sửa lỗi chặn child theme)
- **`inc/dragon/bootstrap.php` dùng `get_stylesheet_directory()` để nạp file của chính theme cha** — khi site chạy child theme thì hàm này trỏ vào thư mục child, không tìm thấy file → **fatal error, sập site**. Tức theme CHƯA TỪNG tương thích child theme. Tàn dư từ thời theme này còn là child theme của Flatsome. Đổi sang `get_template_directory()` (cả `template-parts/home/lawyers.php`).
- Nhờ vậy giathaistone.com tách được thành child theme `giathai-child` và lần đầu tiên nhận được cập nhật từ GitHub. Đã kích hoạt thật: 6 trang (trang chủ, sản phẩm, danh mục, giỏ hàng, bài viết, tìm kiếm) không lỗi, footer/CTA/Google Ads/nút mua hàng khớp 100%.
- Sửa luôn lỗi site đó đang mắc: 404, tìm kiếm và 19 bài viết hiện chữ "liên hệ luật sư" / "Cần tư vấn về vấn đề pháp lý này" trên một website bán đá (do các template đó lấy nguyên từ bản 1.0.1 chưa gỡ chất luật sư).

## [1.3.3] — 2026-07
- Shortcode `[section]` (shim Flatsome) nhận thêm `class`, `id`, `padding`, `padding__sm`. Site di cư từ Flatsome đặt class riêng lên `[section]` để CSS bám vào — thiếu thì layout trang chủ của họ vỡ. Lấy từ bản đang chạy thật ở giathaistone.com.
- Cần cho việc tách giathaistone.com thành **child theme** (repo riêng `giathai-child`): site đó vốn là bản fork 1.0.1 với 9 file riêng nhét thẳng vào thư mục theme cha, nên không thể cập nhật. Tách child xong thì theme cha tự update bình thường mà không xoá mất phần riêng của họ.

## [1.3.2] — 2026-07 (đồng bộ repo với code chạy thật — QUAN TRỌNG)
- **Đưa cơ chế "site di cư" vào repo.** Cơ chế này đã chạy thật trên vietnhatsknn.com từ trước nhưng chưa bao giờ được commit, nên repo đang CŨ HƠN site. Hậu quả nếu không sửa: site di cư bấm cập nhật theme là trang chủ biến thành các section của công ty luật Dragon (đã tái hiện được lỗi này rồi rollback).
  - `vinasite_front_mode` = `content` → trang chủ render nội dung soạn trong WordPress (Trang > Trang chủ), không dựng từ template-parts. Gộp chung vào "Kiểu trang chủ" nên giờ có 3 lựa chọn: `vinasite` | `dragon` | `content`.
  - `dragon_practice_areas_off` → ẩn cột "Lĩnh vực hành nghề" ở chân trang.
  - `cta_text` / `cta_url` → nút CTA header cấu hình theo site (mặc định giữ y như cũ).
  - `privacy_url` / `terms_url` → thay 2 link `vanphongluatsu.com.vn` hardcode ở chân trang.
  - Bỏ chữ "luật sư" / "Dragon" khỏi 404, archive, index, search, single — thay bằng option `company_short`, `side_cta_title`, `side_cta_text`.
  - File mới: `inc/vinasite-shim-extra.php` (shim shortcode Flatsome còn thiếu), `assets/dragon/css/vinasite-legacy.css`, `assets/dragon/js/vinasite-legacy.js`.
- Site kiểu `dragon` được giữ nguyên tuyệt đối: topbar không thêm địa chỉ/giờ làm, 2 link chính sách giữ nguyên (site này chưa đặt trang chính sách trong WP nên nếu chuyển sang `get_privacy_policy_url()` sẽ mất cả 2 link).
- Kiểm chứng thật: deploy 1.3.2 lên vietnhatsknn.com → trang chủ **giống hệt từng byte**, chỉ khác chuỗi `?ver=` của CSS.

## [1.3.1] — 2026-07
- Plugin kèm theme **"Vinasite Google Indexing" nâng lên 1.1**: quét index hàng ngày bằng **URL Inspection API** — mỗi ngày hỏi Google từng URL "đã index chưa?", **chỉ bài CHƯA index mới được gửi** lên Indexing API. Bài đã index kiểm lại sau 30 ngày, bài chưa index sau 3 ngày; có ngân sách thời gian 90s/lượt để không treo cron; token cache riêng theo scope. Cần cấp quyền service account trong Search Console mới chạy được.

## [1.3.0] — 2026-07
- **Trang chủ mặc định VinaSite**, chỉ dành cho **lần kích hoạt theme đầu tiên**: site mới cài xong sẽ thấy trang giới thiệu giao diện VinaSite + dịch vụ của VinaSite (Hero → Tính năng theme → Dịch vụ → Gói dịch vụ → Liên hệ + form tư vấn), thay vì nội dung Công ty Luật Dragon.
- **Site đang dùng theme sẵn thì KHÔNG bị đổi BẤT KỲ THỨ GÌ khi update** — preset `dragon` tái tạo đúng hành vi bản 1.2.4. Ba lớp bảo vệ: (1) preset chỉ gán qua hook `after_switch_theme`, hook này chỉ chạy lúc bật theme chứ không chạy khi cập nhật; (2) option `vinasite_da_chay` đánh dấu theme đã từng chạy trên site — nếu ai bật lại theme trên site đang chạy thì vẫn giữ `dragon`; (3) site đã nhập thông tin doanh nghiệp thì luôn giữ `dragon`.
- Mọi thay đổi ở header/footer (ẩn link rỗng, sửa CSS logo) đều gắn theo preset — chỉ áp dụng cho site cài mới, qua class `vinasite-moi` trên `<body>`.
- **Tùy chọn "VinaSite – Kiểu trang chủ"** trong Customizer: đổi qua lại giữa `vinasite` và `dragon` bất cứ lúc nào.
- Bỏ nội dung Dragon rò rỉ sang site khác: thẻ `<title>`/meta description trang chủ, schema `LegalService`, cột "Lĩnh vực hành nghề" và link chính sách `vanphongluatsu.com.vn` ở chân trang — nay chỉ hiện với preset `dragon`.
- Site cài mới chưa nhập điện thoại/Zalo/email: ẩn topbar, nút gọi nổi và nút Zalo thay vì render link rỗng (`tel:`, `zalo.me/`).
- Form tư vấn dùng chung handler sẵn có (nonce, bẫy bot, chống spam theo IP); email báo về hiển thị đúng tên dịch vụ VinaSite.
- **Đồng bộ màu theo logo VinaSite** (chỉ áp dụng cho preset `vinasite`, toàn site chứ không riêng trang chủ): xanh `#1e5aa8` làm màu chính, xanh logo `#4790cd` màu phụ, đỏ logo `#e51e22` màu nhấn, vàng tagline `#ffd100` cho chữ/icon trên nền xanh; nền và viền chuyển sang tông lạnh. Màu gốc đo trực tiếp từ file logo (đỏ `#ed2024`, xanh `#4790cd`) rồi chỉnh sắc độ để mọi cặp chữ/nền đạt WCAG AA 4.5:1 — dùng thẳng màu gốc thì chữ trắng trên xanh chỉ đạt 3.4:1 và trên đỏ 4.35:1. Site tự chọn màu ở Customizer vẫn được ưu tiên.
- Sửa lỗi hiển thị (chỉ site cài mới): tiêu đề H1 hero bị `.dragon-scope h1` ghi đè thành màu xanh đậm nên chìm vào nền hero (nay dùng đúng chữ trắng); khối ghi chú hero vỡ thành nhiều cột do `display:flex`; logo dạng chữ (site chưa tải logo ảnh) bị gạch chân như link thường.
- Ghi chú hướng dẫn cấu hình ở hero chỉ hiện với người quản trị, khách vào web không thấy. Nhãn nút CTA đổi theo preset ("Nhận tư vấn" / "Đặt lịch tư vấn"), `aria-label` khớp chữ trên nút.
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
