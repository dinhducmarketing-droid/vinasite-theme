<?php
/**
 * Dragon – shared content data (FAQ). Kept in one place so both the rendered
 * accordion and the FAQPage schema use an identical source.
 *
 * @package ntgsite-dragon
 */
if (!defined('ABSPATH')) {
    exit;
}

function dragon_faq_items()
{
    return array(
        array(
            'icon' => 'help',
            'q' => 'Khi nào tôi nên liên hệ luật sư?',
            'a' => 'Bạn nên liên hệ luật sư ngay khi phát sinh tranh chấp, nhận được thông báo, quyết định của cơ quan nhà nước, hoặc trước khi ký kết hợp đồng quan trọng. Tư vấn sớm giúp bảo vệ quyền lợi và hạn chế rủi ro pháp lý.',
        ),
        array(
            'icon' => 'briefcase',
            'q' => 'Chi phí thuê luật sư được xác định như thế nào?',
            'a' => 'Phí dịch vụ được xác định dựa trên tính chất, mức độ phức tạp và khối lượng công việc của từng vụ việc. Luật sư sẽ trao đổi và báo phí minh bạch trước khi ký hợp đồng dịch vụ pháp lý.',
        ),
        array(
            'icon' => 'shield',
            'q' => 'Công ty có bảo mật hồ sơ khách hàng không?',
            'a' => 'Có. Bảo mật thông tin khách hàng là nguyên tắc nghề nghiệp bắt buộc. Mọi hồ sơ, tài liệu và thông tin bạn cung cấp đều được bảo mật và chỉ sử dụng cho việc tiếp nhận, giải quyết vụ việc.',
        ),
        array(
            'icon' => 'chat',
            'q' => 'Có thể tư vấn qua điện thoại hoặc trực tuyến không?',
            'a' => 'Được. Chúng tôi tiếp nhận tư vấn qua điện thoại, Zalo và trực tuyến, bên cạnh hình thức làm việc trực tiếp tại văn phòng. Bạn có thể chọn hình thức thuận tiện nhất.',
        ),
        array(
            'icon' => 'folder',
            'q' => 'Cần chuẩn bị giấy tờ gì trước khi gặp luật sư?',
            'a' => 'Bạn nên chuẩn bị các giấy tờ liên quan đến vụ việc như hợp đồng, quyết định, thông báo, giấy tờ tùy thân và tài liệu chứng cứ (nếu có). Luật sư sẽ hướng dẫn bổ sung sau khi đánh giá sơ bộ.',
        ),
        array(
            'icon' => 'stamp',
            'q' => 'Luật sư có thể đại diện làm việc với cơ quan nhà nước không?',
            'a' => 'Có. Theo ủy quyền hợp pháp, luật sư có thể đại diện khách hàng làm việc, nộp hồ sơ và tham gia tố tụng tại các cơ quan nhà nước và cơ quan tiến hành tố tụng.',
        ),
        array(
            'icon' => 'clock',
            'q' => 'Thời gian xử lý một vụ việc kéo dài bao lâu?',
            'a' => 'Thời gian phụ thuộc vào loại vụ việc và quy định tố tụng. Với dịch vụ tư vấn có thể xử lý nhanh, còn vụ việc tranh tụng sẽ theo trình tự tố tụng. Luật sư sẽ ước lượng thời gian cụ thể sau khi xem hồ sơ.',
        ),
        array(
            'icon' => 'map-pin',
            'q' => 'Công ty có tiếp nhận khách hàng ngoài Hà Nội không?',
            'a' => 'Có. Dragon tiếp nhận khách hàng trên toàn quốc thông qua tư vấn trực tuyến và các văn phòng đại diện, đồng thời cử luật sư tham gia vụ việc tại các địa phương khi cần thiết.',
        ),
    );
}
