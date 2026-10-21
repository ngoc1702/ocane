<?php
/** Homepage landing configuration. Unlimited reason rows use the installed ACF Pro repeater. */
if (!defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', function () {
    register_nav_menu('oca_landing', 'OcaNew — Menu trang chủ LDP');
});

add_action('wp_enqueue_scripts', function () {
    if (!is_page_template('page-home-landing.php')) {
        return;
    }
    // This landing uses native navigation/FAQ and does not need slider libraries.
    wp_dequeue_script('caia-slick');
    // Shared theme widgets and Fluent Forms still use jQuery.
    wp_enqueue_script('jquery');
    remove_action('wp_footer', 'add_swiper_webcomponent_script');
    foreach (array('css', 'js') as $extension) {
        $relative = '/assets/' . $extension . '/landing.' . $extension;
        $version = filemtime(get_stylesheet_directory() . $relative);
        $url = get_stylesheet_directory_uri() . $relative;
        if ('css' === $extension) {
            wp_enqueue_style('oca-home-landing', $url, array(), $version);
        } else {
            wp_enqueue_script('oca-home-landing', $url, array(), $version, true);
        }
    }
}, 130);

function oca_home_field($name, $default = '') {
    $value = function_exists('get_field') ? get_field($name) : null;
    return null === $value || false === $value || '' === $value ? $default : $value;
}

// Keep form submissions on this installation when Laragon serves a domain alias.
function oca_home_form_ajax_url($vars) {
    if (is_page_template('page-home-landing.php') && !empty($_SERVER['SCRIPT_NAME']) && 'index.php' === basename($_SERVER['SCRIPT_NAME'])) {
        $directory = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        $vars['ajaxUrl'] = $directory . '/wp-admin/admin-ajax.php';
    }
    return $vars;
}
add_filter('fluentform/form_vars_for_JS', 'oca_home_form_ajax_url');
add_filter('fluentform/global_form_vars', 'oca_home_form_ajax_url');

function oca_home_text($name, $default = '') {
    $value = function_exists('get_field') ? get_field($name) : null;
    return is_string($value) ? $value : $default;
}

function oca_home_preparation_steps() {
    return array(
        array('title' => 'Cho bột vào ly', 'description' => 'Cho lượng bột OcaNew nut theo hướng dẫn trên bao bì vào ly sạch.'),
        array('title' => 'Thêm nước ấm', 'description' => 'Thêm nước theo lượng và nhiệt độ được hướng dẫn trên bao bì.'),
        array('title' => 'Khuấy đều', 'description' => 'Khuấy nhẹ cho bột tan đều hoàn toàn.'),
        array('title' => 'Thưởng thức', 'description' => 'Thưởng thức ly dinh dưỡng sau khi pha.'),
    );
}

function oca_home_faqs() {
    return array(
        array('question' => 'OcaNew nut có những thành phần nào?', 'answer' => 'Các thành phần được giới thiệu gồm hạnh nhân, óc chó, đậu Hà Lan, yến mạch và ngũ cốc. Bạn hãy xem danh sách thành phần trên bao bì sản phẩm đang sử dụng để biết công thức và thông tin chi tiết.'),
        array('question' => 'Pha OcaNew nut như thế nào cho đúng?', 'answer' => 'Chuẩn bị ly và dụng cụ sạch. Đong lượng bột, thêm nước với lượng và nhiệt độ theo hướng dẫn trên bao bì, sau đó khuấy đều. Bạn có thể tham khảo phần Quy trình pha trên trang này; định lượng cụ thể cần theo đúng nhãn sản phẩm.'),
        array('question' => 'Cần lưu ý gì khi lấy bột và pha sản phẩm?', 'answer' => 'Dùng thìa sạch, khô để lấy bột và đóng kín nắp sau mỗi lần sử dụng. Nên pha lượng vừa đủ cho mỗi lần dùng; thực hiện theo hướng dẫn sử dụng và bảo quản ghi trên bao bì.'),
        array('question' => 'Bảo quản OcaNew nut sau khi mở nắp như thế nào?', 'answer' => 'Đóng kín nắp và để sản phẩm ở nơi khô ráo, thoáng mát, tránh ánh nắng trực tiếp và nguồn nhiệt. Xem hướng dẫn bảo quản và thời gian sử dụng sau khi mở nắp trên nhãn; không dùng sản phẩm quá hạn sử dụng.'),
        array('question' => 'Làm sao nhận biết mẫu bao bì mới của OcaNew nut?', 'answer' => 'Bạn có thể đối chiếu hình ảnh mẫu cũ và mẫu mới tại phần Cải tiến trên trang này. Khi lựa chọn sản phẩm, hãy kiểm tra tên sản phẩm, thông tin đơn vị chịu trách nhiệm, thành phần, khối lượng, hạn sử dụng và tình trạng niêm phong trên bao bì.'),
        array('question' => 'Tìm thông tin chính thức về sản phẩm ở đâu?', 'answer' => 'Thông tin trên nhãn sản phẩm và các kênh chính thức của OcaNew nut là những nơi để bạn đối chiếu thành phần, cách dùng và bảo quản. Nếu cần làm rõ thông tin, hãy liên hệ kênh hỗ trợ được công bố trên bao bì hoặc website chính thức.'),
    );
}

function oca_home_ingredients() {
    return array(
        array('slug' => 'almond', 'title' => 'Hạnh nhân', 'description' => 'Hương hạnh nhân thơm dịu, vị bùi nhẹ nhàng.'),
        array('slug' => 'walnut', 'title' => 'Óc chó', 'description' => 'Hạt óc chó với hương vị béo bùi đặc trưng.'),
        array('slug' => 'pea', 'title' => 'Đậu Hà Lan', 'description' => 'Đậu Hà Lan mang hương vị thanh nhẹ từ thực vật.'),
        array('slug' => 'grain', 'title' => 'Ngũ cốc', 'description' => 'Sự kết hợp các loại ngũ cốc quen thuộc, thơm ngon.'),
        array('slug' => 'oat', 'title' => 'Yến mạch', 'description' => 'Yến mạch với vị ngọt dịu và hương thơm tự nhiên.'),
    );
}

function oca_home_reasons() {
    return array(
        array('description' => 'Chú trọng chất lượng trong từng sản phẩm.', 'path' => 'M24 4l5 3 6 1 1 6 3 5-3 5-1 6-6 1-5 3-5-3-6-1-1-6-3-5 3-5 1-6 6-1Z M24 11l3 6 7 1-5 5 1 7-6-3-6 3 1-7-5-5 7-1Z M15 32l-3 11 8-4 4 4 3-9 M30 32l6 11 1-7 6 1-7-10'),
        array('description' => 'Đồng hành cùng bạn tìm hiểu và lựa chọn dinh dưỡng phù hợp.', 'path' => 'M19 5l10 10-5 5L14 10Z M12 12l-3 3 10 10 3-3 M26 18a12 12 0 0 1 7 11c0 7-5 12-12 12S9 36 9 29 M6 29h21 M18 41v3 M8 44h28 M34 7v8 M30 11h8 M35 23h5 M38 20v6'),
        array('description' => 'Chia sẻ kiến thức để chăm sóc bản thân và gia đình mỗi ngày.', 'path' => 'M24 15c-6-4-12-5-19-3v27c7-2 13-1 19 3 6-4 12-5 19-3V12c-4-1-7-1-10 0 M24 15v27 M10 19c4-1 7 0 10 2 M10 26c4-1 7 0 10 2 M10 33c4-1 7 0 10 2 M28 28c4-2 7-3 11-2 M28 35c4-2 7-3 11-2 M32 4a6 6 0 0 0-4 10l1 4h6l1-4a6 6 0 0 0-4-10Z M29 22h6 M32 0v1 M22 5l2 1 M40 5l-2 1'),
    );
}

function oca_home_reason_items($post_id = 0) {
    $post_id = $post_id ?: get_the_ID();
    $items = function_exists('get_field') ? get_field('oca_reasons_items', $post_id) : null;
    if (is_array($items)) {
        return $items;
    }
    if (metadata_exists('post', $post_id, 'oca_reasons_items')) {
        return array();
    }
    // Preserve existing pages until their three legacy groups are migrated.
    $items = array();
    foreach (oca_home_reasons() as $index => $defaults) {
        $prefix = 'oca_reason_' . ($index + 1);
        $items[] = array(
            'icon' => absint(get_post_meta($post_id, $prefix . '_icon', true)),
            'description' => metadata_exists('post', $post_id, $prefix . '_description') ? get_post_meta($post_id, $prefix . '_description', true) : $defaults['description'],
        );
    }
    return $items;
}

function oca_home_top_items() {
    return array(
        'location' => array('label' => 'Việt Nam', 'url' => '', 'path' => 'M12 22s8-7 8-14a8 8 0 1 0-16 0c0 7 8 14 8 14Z M12 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6'),
        'email' => array('label' => 'contact@ocanew.vn', 'url' => 'mailto:contact@ocanew.vn', 'path' => 'M3 5h18v14H3Z M3 5l9 8 9-8'),
        'support' => array('label' => 'Hỗ trợ khách hàng', 'url' => '', 'path' => 'M5 14v-3a7 7 0 0 1 14 0v3 M5 11H3v7h4v-7Z M19 11h2v7h-4v-7Z M19 18v3h-7'),
        'document' => array('label' => '08:00 - 17:00', 'url' => '', 'path' => 'M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20 M12 6v6l4 3'),
    );
}

function oca_home_top_icon($key, $item, $default, $class) {
    if (!empty($item['icon'])) {
        return wp_get_attachment_image(absint($item['icon']), 'full', false, array('class' => $class, 'alt' => '', 'aria-hidden' => 'true'));
    }
    if ('document' === $key) {
        return '<img class="' . esc_attr($class) . '" src="' . esc_url(get_stylesheet_directory_uri() . '/assets/images/clock-white.png') . '" width="256" height="256" alt="" aria-hidden="true">';
    }
    return '<svg class="' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="' . esc_attr($default['path']) . '"/></svg>';
}

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }
    $fields = array(
        array('key' => 'field_oca_header_tab', 'label' => 'Header', 'type' => 'tab'),
        array('key' => 'field_oca_home_logo', 'name' => 'oca_home_logo', 'label' => 'Ảnh logo', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'thumbnail', 'library' => 'all', 'instructions' => 'Tải logo nền trong suốt. Để trống sẽ hiện chữ OcaNew nut.'),
    );
    $fields[] = array('key' => 'field_oca_header_contact_label', 'name' => 'oca_header_contact_label', 'label' => 'Chữ nút liên hệ trên header', 'type' => 'text', 'default_value' => 'Liên hệ', 'instructions' => 'Xóa chữ để ẩn nút.', 'wrapper' => array('width' => '40'));
    $fields[] = array('key' => 'field_oca_header_contact_url', 'name' => 'oca_header_contact_url', 'label' => 'Liên kết nút liên hệ', 'type' => 'text', 'default_value' => '#hoi-chuyen-gia', 'instructions' => 'Nhập #ID-section để cuộn trong trang, URL trang liên hệ hoặc tel:số-điện-thoại. Nút chỉ hiện khi có cả chữ và liên kết.', 'wrapper' => array('width' => '60'));
    foreach (oca_home_top_items() as $key => $item) {
        $prefix = 'oca_top_' . $key;
        $fields[] = array(
            'key' => 'field_' . $prefix, 'name' => $prefix, 'label' => 'document' === $key ? 'Giờ làm việc' : $item['label'], 'type' => 'group', 'layout' => 'block',
            'sub_fields' => array(
                array('key' => 'field_' . $prefix . '_icon', 'name' => 'icon', 'label' => 'Ảnh thay icon', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'thumbnail', 'library' => 'all', 'instructions' => 'Nên dùng PNG/WebP nền trong suốt, icon màu trắng. Để trống dùng icon mặc định.', 'wrapper' => array('width' => '25')),
                array('key' => 'field_' . $prefix . '_label', 'name' => 'label', 'label' => 'Nội dung', 'type' => 'text', 'default_value' => $item['label'], 'instructions' => 'Xóa nội dung để ẩn mục này.', 'wrapper' => array('width' => '35')),
                array('key' => 'field_' . $prefix . '_url', 'name' => 'url', 'label' => 'Liên kết', 'type' => 'text', 'default_value' => $item['url'], 'instructions' => 'Nhập URL, mailto: hoặc tel:. Để trống nếu chỉ hiển thị chữ.', 'wrapper' => array('width' => '40')),
            ),
        );
    }
    $fields[] = array('key' => 'field_oca_menu_help', 'label' => 'Menu điều hướng', 'type' => 'message', 'message' => 'Vào Giao diện → Menu để chỉnh menu “OcaNew — Menu các section”, gán vào “OcaNew — Menu trang chủ LDP”. Dùng liên kết dạng #ID-section để cuộn trong trang. Menu mặc định gồm 8 mục theo thứ tự section; mục đang xem đổi màu chữ.');
    $fields[] = array('key' => 'field_oca_banner_tab', 'label' => 'Banner', 'type' => 'tab');
    $fields[] = array('key' => 'field_oca_home_banner', 'name' => 'oca_home_banner', 'label' => 'Ảnh nền banner', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Dùng nền sáng, ảnh ngang khoảng 1920 × 800px. Ảnh phủ kín nền nên có thể bị cắt ở hai cạnh trên điện thoại. Để trống sẽ dùng nền bếp kem–gỗ có ánh sáng tự nhiên, được tạo riêng cho OcaNew.');
    $fields[] = array('key' => 'field_oca_hero_image', 'name' => 'oca_hero_image', 'label' => 'Ảnh bên phải (đã xóa nền)', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Tải PNG/WebP có nền trong suốt, khuyến nghị cao từ 900px. Hiển thị nguyên ảnh, không cắt. Trường này không tự xóa nền ảnh.');
    $fields[] = array('key' => 'field_oca_hero_eyebrow', 'name' => 'oca_hero_eyebrow', 'label' => 'Dòng chữ nhỏ', 'type' => 'text', 'default_value' => 'OCANEW NUT');
    $fields[] = array('key' => 'field_oca_hero_title', 'name' => 'oca_hero_title', 'label' => 'Tiêu đề chính', 'type' => 'text', 'default_value' => 'Dinh dưỡng mỗi ngày,');
    $fields[] = array('key' => 'field_oca_hero_highlight', 'name' => 'oca_hero_highlight', 'label' => 'Dòng tiêu đề màu nhấn', 'type' => 'text', 'default_value' => 'trọn vẹn yêu thương.');
    $fields[] = array('key' => 'field_oca_hero_description', 'name' => 'oca_hero_description', 'label' => 'Mô tả banner', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Cùng OcaNew nut tìm hiểu và lựa chọn sản phẩm dinh dưỡng phù hợp cho bạn và gia đình.');
    $fields[] = array('key' => 'field_oca_hero_button', 'name' => 'oca_hero_button', 'label' => 'Chữ trên nút', 'type' => 'text', 'default_value' => 'Khám phá sản phẩm', 'instructions' => 'Nút chỉ hiện khi có cả chữ và liên kết.');
    $fields[] = array('key' => 'field_oca_home_banner_link', 'name' => 'oca_home_banner_link', 'label' => 'Liên kết nút banner', 'type' => 'url');
    $fields[] = array('key' => 'field_oca_about_tab', 'label' => 'Về chúng tôi', 'type' => 'tab');
    $fields[] = array('key' => 'field_oca_about_image', 'name' => 'oca_about_image', 'label' => 'Ảnh giới thiệu bên phải', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Ưu tiên PNG/WebP nền trong suốt, từ 1000px. Ảnh hiển thị nguyên vẹn và căn phải, không có nền trang trí. Để trống dùng ảnh sản phẩm banner.');
    $fields[] = array('key' => 'field_oca_about_title', 'name' => 'oca_about_title', 'label' => 'Tiêu đề section', 'type' => 'text', 'default_value' => 'Về OcaNew nut');
    $fields[] = array('key' => 'field_oca_about_description', 'name' => 'oca_about_description', 'label' => 'Nội dung giới thiệu', 'type' => 'textarea', 'rows' => 5, 'default_value' => 'OcaNew nut đồng hành cùng bạn trong việc tìm hiểu và lựa chọn sản phẩm dinh dưỡng phù hợp cho gia đình. Khám phá câu chuyện thương hiệu, thông tin sản phẩm và những giá trị mà OcaNew nut hướng đến.');
    for ($index = 1; $index <= 3; $index++) {
        $fields[] = array('key' => 'field_oca_about_certificate_' . $index, 'name' => 'oca_about_certificate_' . $index, 'label' => 'Ảnh tiêu chuẩn/chứng nhận ' . $index, 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'thumbnail', 'library' => 'all', 'instructions' => 'Hiển thị dưới đoạn giới thiệu, lưới 3 cột. Nên dùng PNG/WebP nền trong suốt cùng tỷ lệ; điền văn bản thay thế trong Thư viện ảnh. Để trống sẽ ẩn ảnh này.', 'wrapper' => array('width' => '33'));
    }
    $fields[] = array('key' => 'field_oca_reasons_tab', 'label' => 'Lý do lựa chọn', 'type' => 'tab');
    $fields[] = array('key' => 'field_oca_reasons_image', 'name' => 'oca_reasons_image', 'label' => 'Ảnh bên trái', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Ảnh từ 800px, ưu tiên PNG/WebP nền trong suốt. Hiển thị nguyên ảnh, không cắt tròn và không thêm nền. Để trống dùng ảnh sản phẩm banner.');
    $fields[] = array('key' => 'field_oca_reasons_title', 'name' => 'oca_reasons_title', 'label' => 'Tiêu đề section', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Lý do lựa chọn OcaNew nut');
    $fields[] = array('key' => 'field_oca_reasons_description', 'name' => 'oca_reasons_description', 'label' => 'Mô tả mở đầu', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Cùng OcaNew nut tìm hiểu những giá trị mà chúng tôi hướng đến trong hành trình đồng hành cùng gia đình bạn.');
    $fields[] = array(
        'key' => 'field_oca_reasons_items', 'name' => 'oca_reasons_items', 'label' => 'Danh sách lý do', 'type' => 'repeater',
        'layout' => 'block', 'min' => 0, 'max' => 0, 'button_label' => 'Thêm lý do', 'collapsed' => 'field_oca_reasons_item_description',
        'instructions' => 'Thêm, xóa và kéo thả sắp xếp không giới hạn số lý do. Mỗi mục gồm một ảnh icon và nội dung. Mục không có nội dung sẽ không hiện trên trang.',
        'sub_fields' => array(
            array('key' => 'field_oca_reasons_item_icon', 'name' => 'icon', 'label' => 'Ảnh icon', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'thumbnail', 'library' => 'all', 'instructions' => 'Ưu tiên PNG/WebP nền trong suốt; hiển thị nguyên ảnh, không cắt. Để trống dùng icon nét mặc định.', 'wrapper' => array('width' => '30')),
            array('key' => 'field_oca_reasons_item_description', 'name' => 'description', 'label' => 'Nội dung lý do', 'type' => 'textarea', 'rows' => 3, 'wrapper' => array('width' => '70')),
        ),
    );
    $fields[] = array('key' => 'field_oca_ingredients_tab', 'label' => 'Thành phần', 'type' => 'tab');
    $fields[] = array('key' => 'field_oca_ingredients_title', 'name' => 'oca_ingredients_title', 'label' => 'Tiêu đề section', 'type' => 'text', 'default_value' => 'Tinh túy từ những thành phần tự nhiên');
    $fields[] = array('key' => 'field_oca_ingredients_description', 'name' => 'oca_ingredients_description', 'label' => 'Mô tả section', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Khám phá 5 thành phần tạo nên hương vị đặc trưng của OcaNew nut.');
    $fields[] = array('key' => 'field_oca_ingredients_center_image', 'name' => 'oca_ingredients_center_image', 'label' => 'Logo/ảnh giữa các thành phần', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Tải logo hoặc ảnh tùy chọn, ưu tiên PNG/WebP nền trong suốt. Hiển thị nguyên ảnh, không cắt. Để trống sẽ ẩn ảnh giữa.');
    foreach (oca_home_ingredients() as $index => $ingredient) {
        $prefix = 'oca_ingredient_' . ($index + 1);
        $fields[] = array(
            'key' => 'field_' . $prefix, 'name' => $prefix, 'label' => 'Thành phần ' . ($index + 1) . ' — ' . $ingredient['title'], 'type' => 'group', 'layout' => 'block',
            'sub_fields' => array(
                array('key' => 'field_' . $prefix . '_image', 'name' => 'image', 'label' => 'Ảnh ghép thành phần', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Để trống dùng ảnh giọt sữa đã tạo sẵn. Thay bằng PNG/WebP nền trong suốt, bố cục dọc; ảnh hiển thị nguyên vẹn.', 'wrapper' => array('width' => '30')),
                array('key' => 'field_' . $prefix . '_title', 'name' => 'title', 'label' => 'Tên thành phần', 'type' => 'text', 'default_value' => $ingredient['title'], 'wrapper' => array('width' => '30')),
                array('key' => 'field_' . $prefix . '_description', 'name' => 'description', 'label' => 'Mô tả thành phần', 'type' => 'textarea', 'rows' => 3, 'default_value' => $ingredient['description'], 'wrapper' => array('width' => '40')),
            ),
        );
    }
    $fields[] = array('key' => 'field_oca_preparation_tab', 'label' => 'Quy trình pha', 'type' => 'tab');
    $fields[] = array('key' => 'field_oca_preparation_background', 'name' => 'oca_preparation_background', 'label' => 'Ảnh nền quy trình', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Ảnh ngang khoảng 1920 × 700px. Để trống dùng màu xanh chủ đạo.');
    $fields[] = array('key' => 'field_oca_preparation_overlay', 'name' => 'oca_preparation_overlay', 'label' => 'Độ phủ xanh trên ảnh nền', 'type' => 'range', 'min' => 0, 'max' => 100, 'step' => 5, 'default_value' => 75, 'append' => '%', 'instructions' => 'Tăng để chữ trắng dễ đọc trên nền nhiều chi tiết.');
    $fields[] = array('key' => 'field_oca_preparation_title', 'name' => 'oca_preparation_title', 'label' => 'Tiêu đề quy trình', 'type' => 'text', 'default_value' => '4 bước đơn giản cho ly dinh dưỡng thơm ngon');
    $fields[] = array('key' => 'field_oca_preparation_description', 'name' => 'oca_preparation_description', 'label' => 'Mô tả dưới tiêu đề', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Chuẩn bị ly và dụng cụ sạch, thực hiện lần lượt 4 bước dưới đây. Lượng bột, lượng nước và nhiệt độ pha theo hướng dẫn trên bao bì sản phẩm.');
    foreach (oca_home_preparation_steps() as $index => $step) {
        $prefix = 'oca_preparation_step_' . ($index + 1);
        $fields[] = array(
            'key' => 'field_' . $prefix, 'name' => $prefix, 'label' => 'Bước ' . ($index + 1), 'type' => 'group', 'layout' => 'block',
            'sub_fields' => array(
                array('key' => 'field_' . $prefix . '_image', 'name' => 'image', 'label' => 'Ảnh minh họa', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Ảnh ngang khoảng 800 × 450px.', 'wrapper' => array('width' => '30')),
                array('key' => 'field_' . $prefix . '_title', 'name' => 'title', 'label' => 'Tên bước', 'type' => 'text', 'default_value' => $step['title'], 'wrapper' => array('width' => '30')),
                array('key' => 'field_' . $prefix . '_description', 'name' => 'description', 'label' => 'Nội dung', 'type' => 'textarea', 'rows' => 3, 'default_value' => $step['description'], 'wrapper' => array('width' => '40')),
            ),
        );
    }
    $fields[] = array('key' => 'field_oca_improvement_tab', 'label' => 'Cải tiến', 'type' => 'tab');
    $fields[] = array('key' => 'field_oca_improvement_title', 'name' => 'oca_improvement_title', 'label' => 'Tiêu đề section', 'type' => 'text', 'default_value' => 'Cải tiến diện mạo OcaNew nut');
    $fields[] = array('key' => 'field_oca_improvement_description', 'name' => 'oca_improvement_description', 'label' => 'Mô tả section', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Khám phá sự thay đổi từ mẫu cũ đến mẫu mới của OcaNew nut.');
    foreach (array('old' => 'Mẫu cũ', 'new' => 'Mẫu mới') as $key => $label) {
        $prefix = 'oca_improvement_' . $key;
        $fields[] = array('key' => 'field_' . $prefix . '_image', 'name' => $prefix . '_image', 'label' => 'Ảnh ' . mb_strtolower($label), 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Ảnh sản phẩm PNG/WebP nền trong suốt hoặc ảnh chụp. Khuyến nghị từ 1000px, hai ảnh cùng tỷ lệ và góc chụp. Hiển thị nguyên ảnh, không cắt.', 'wrapper' => array('width' => '50'));
        $fields[] = array('key' => 'field_' . $prefix . '_label', 'name' => $prefix . '_label', 'label' => 'Nhãn ' . mb_strtolower($label), 'type' => 'text', 'default_value' => $label, 'wrapper' => array('width' => '50'));
    }
    $fields[] = array('key' => 'field_oca_faq_tab', 'label' => 'Hỏi đáp', 'type' => 'tab');
    $fields[] = array('key' => 'field_oca_faq_title', 'name' => 'oca_faq_title', 'label' => 'Tiêu đề section', 'type' => 'text', 'default_value' => 'Hỏi đáp cùng OcaNew nut');
    $fields[] = array('key' => 'field_oca_faq_description', 'name' => 'oca_faq_description', 'label' => 'Mô tả section', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Giải đáp những câu hỏi thường gặp về thành phần, cách pha, bảo quản và bao bì sản phẩm OcaNew nut.');
    $fields[] = array('key' => 'field_oca_faq_image', 'name' => 'oca_faq_image', 'label' => 'Ảnh minh họa bên trái', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Ảnh ngang khoảng 1000 × 800px về sản phẩm hoặc pha sữa. Để trống dùng ảnh sản phẩm banner.');
    foreach (oca_home_faqs() as $index => $faq) {
        $prefix = 'oca_faq_' . ($index + 1);
        $fields[] = array(
            'key' => 'field_' . $prefix, 'name' => $prefix, 'label' => 'Hỏi đáp ' . ($index + 1), 'type' => 'group', 'layout' => 'block',
            'sub_fields' => array(
                array('key' => 'field_' . $prefix . '_question', 'name' => 'question', 'label' => 'Câu hỏi', 'type' => 'text', 'default_value' => $faq['question'], 'instructions' => 'Xóa câu hỏi để ẩn mục này.', 'wrapper' => array('width' => '40')),
                array('key' => 'field_' . $prefix . '_answer', 'name' => 'answer', 'label' => 'Câu trả lời', 'type' => 'textarea', 'rows' => 5, 'default_value' => $faq['answer'], 'wrapper' => array('width' => '60')),
            ),
        );
    }
    $fields[] = array('key' => 'field_oca_expert_tab', 'label' => 'Hỏi chuyên gia', 'type' => 'tab');
    $fields[] = array('key' => 'field_oca_expert_title', 'name' => 'oca_expert_title', 'label' => 'Tiêu đề section', 'type' => 'text', 'default_value' => 'Hỏi chuyên gia');
    $fields[] = array('key' => 'field_oca_expert_description', 'name' => 'oca_expert_description', 'label' => 'Mô tả section', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Để lại câu hỏi và thông tin liên hệ để OcaNew nut hỗ trợ bạn.');
    $fields[] = array('key' => 'field_oca_expert_image', 'name' => 'oca_expert_image', 'label' => 'Ảnh chuyên gia bên trái', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Ảnh ngang từ 1000px, hiển thị nguyên ảnh, không cắt tròn và không thêm nền màu. Có thể dùng PNG/WebP với nền xanh hoặc viền mờ có sẵn. Để trống dùng ảnh sản phẩm banner.');
    $fields[] = array('key' => 'field_oca_expert_background', 'name' => 'oca_expert_background', 'label' => 'Ảnh nền section', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Ảnh ngang khoảng 1920 × 800px. Thay độc lập với ảnh tròn; để trống dùng nền xám sáng.');
    $fields[] = array('key' => 'field_oca_expert_form_id', 'name' => 'oca_expert_form_id', 'label' => 'ID biểu mẫu Fluent Forms', 'type' => 'number', 'min' => 1, 'step' => 1, 'default_value' => absint(get_option('oca_expert_form_id')), 'instructions' => 'Mặc định dùng form Hỏi chuyên gia đã tạo sẵn. Trong Fluent Forms, chọn form để sửa tên trường, nút gửi và thông báo thành công; xem câu hỏi tại Entries. Có thể nhập ID một form khác.');
    $fields[] = array('key' => 'field_oca_footer_tab', 'label' => 'Chân trang', 'type' => 'tab');
    $fields[] = array('key' => 'field_oca_footer_background', 'name' => 'oca_footer_background', 'label' => 'Ảnh nền footer', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Ảnh ngang khoảng 1920 × 800px; để trống dùng màu chủ đạo website.');
    $fields[] = array('key' => 'field_oca_footer_overlay', 'name' => 'oca_footer_overlay', 'label' => 'Lớp phủ màu chủ đạo trên ảnh nền', 'type' => 'range', 'min' => 0, 'max' => 100, 'step' => 5, 'default_value' => 80, 'append' => '%');
    $fields[] = array('key' => 'field_oca_footer_show_accent', 'name' => 'oca_footer_show_accent', 'label' => 'Hiện ảnh điểm nhấn chồng mép trên', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1);
    $fields[] = array('key' => 'field_oca_footer_accent', 'name' => 'oca_footer_accent', 'label' => 'Ảnh điểm nhấn bên phải', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'PNG/WebP nền trong suốt, từ 600px. Hiển thị nhỏ, nghiêng nhẹ và chồng mép trên footer. Để trống dùng ảnh sản phẩm banner.', 'wrapper' => array('width' => '50'));
    $fields[] = array('key' => 'field_oca_footer_accent_left', 'name' => 'oca_footer_accent_left', 'label' => 'Ảnh điểm nhấn bên trái', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'PNG/WebP nền trong suốt. Nằm cố định bên trái, nghiêng ngược ảnh bên phải. Để trống dùng ảnh mẫu mới trong tab Cải tiến.', 'wrapper' => array('width' => '50'));
    $fields[] = array('key' => 'field_oca_footer_logo', 'name' => 'oca_footer_logo', 'label' => 'Logo chân trang', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Để trống dùng logo ở tab Header. Ưu tiên PNG/WebP nền trong suốt.');
    $fields[] = array('key' => 'field_oca_footer_company', 'name' => 'oca_footer_company', 'label' => 'Cột 1 — Tên công ty/thương hiệu', 'type' => 'text', 'default_value' => 'OcaNew nut');
    $fields[] = array('key' => 'field_oca_footer_company_info', 'name' => 'oca_footer_company_info', 'label' => 'Thông tin công ty', 'type' => 'textarea', 'rows' => 5, 'default_value' => 'OcaNew nut đồng hành cùng bạn trong hành trình lựa chọn dinh dưỡng cho gia đình.', 'instructions' => 'Nhập giới thiệu, thông tin pháp lý, số giấy đăng ký, ngày cấp, nơi cấp; mỗi dòng một mục. Chỉ điền thông tin thực tế của đơn vị.');
    $fields[] = array('key' => 'field_oca_footer_address', 'name' => 'oca_footer_address', 'label' => 'Địa chỉ', 'type' => 'textarea', 'rows' => 2);
    $fields[] = array('key' => 'field_oca_footer_contact_help', 'label' => 'Thông tin liên hệ đồng bộ Header', 'type' => 'message', 'message' => 'Số điện thoại, email, giờ làm việc và ảnh biểu tượng được dùng chung từ tab Header. Chỉnh nội dung, đường dẫn hoặc ảnh ở Header để cập nhật cả hai nơi. Xóa nội dung ở Header để ẩn mục tương ứng.');
    $fields[] = array('key' => 'field_oca_footer_links_title', 'name' => 'oca_footer_links_title', 'label' => 'Cột 2 — Tiêu đề liên kết', 'type' => 'text', 'default_value' => 'Liên kết nhanh');
    $fields[] = array('key' => 'field_oca_footer_menu_help', 'label' => 'Quản lý liên kết nhanh', 'type' => 'message', 'message' => 'Dùng chung menu với Header. Vào Giao diện → Menu, chỉnh menu gán vào “OcaNew — Menu trang chủ LDP” để cập nhật cả hai nơi. Khi chưa gán, dùng các liên kết tới section trên trang chủ.');
    $fields[] = array('key' => 'field_oca_footer_connect_title', 'name' => 'oca_footer_connect_title', 'label' => 'Cột 3 — Tiêu đề kết nối', 'type' => 'text', 'default_value' => 'Kết nối cùng OcaNew');
    $fields[] = array(
        'key' => 'field_oca_footer_social_items', 'name' => 'oca_footer_social_items', 'label' => 'Cột 3 — Danh sách liên kết', 'type' => 'repeater',
        'layout' => 'table', 'button_label' => 'Thêm liên kết', 'min' => 0,
        'instructions' => 'Mỗi mục gồm ảnh biểu tượng và đường dẫn tùy chọn. Có thể thêm, xóa hoặc kéo thả để đổi thứ tự. Xóa hết các mục để ẩn danh sách.',
        'sub_fields' => array(
            array('key' => 'field_oca_footer_social_image', 'name' => 'image', 'label' => 'Ảnh biểu tượng', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'thumbnail', 'library' => 'all', 'required' => 1, 'instructions' => 'Tải ảnh PNG/WebP nền trong suốt, ưu tiên ảnh vuông.', 'wrapper' => array('width' => '30')),
            array('key' => 'field_oca_footer_social_label', 'name' => 'label', 'label' => 'Tên liên kết', 'type' => 'text', 'instructions' => 'Ví dụ: Facebook, Zalo. Dùng để mô tả ảnh.', 'wrapper' => array('width' => '25')),
            array('key' => 'field_oca_footer_social_url', 'name' => 'url', 'label' => 'Đường dẫn', 'type' => 'url', 'instructions' => 'Để trống nếu chỉ hiển thị ảnh.', 'wrapper' => array('width' => '45')),
        ),
    );
    $fields[] = array('key' => 'field_oca_footer_badge', 'name' => 'oca_footer_badge', 'label' => 'Cột 3 — Logo Bộ Công Thương', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Tải lên hoặc chọn logo Bộ Công Thương từ thư viện. Logo hiển thị bên dưới các biểu tượng mạng xã hội; để trống sẽ ẩn. Ưu tiên PNG/WebP nền trong suốt.');
    $fields[] = array('key' => 'field_oca_footer_badge_link', 'name' => 'oca_footer_badge_link', 'label' => 'Liên kết Bộ Công Thương', 'type' => 'url', 'instructions' => 'Nhập URL hồ sơ website trên Bộ Công Thương để mở khi bấm logo. Để trống nếu chỉ hiển thị ảnh.');
    $fields[] = array('key' => 'field_oca_footer_copyright', 'name' => 'oca_footer_copyright', 'label' => 'Dòng bản quyền', 'type' => 'text', 'default_value' => 'OcaNew nut. All rights reserved.', 'instructions' => 'Năm hiện tại được hiển thị tự động phía trước.');
    acf_add_local_field_group(array(
        'key' => 'group_oca_home_landing', 'title' => 'OcaNew — Cấu hình trang chủ LDP', 'fields' => $fields,
        'location' => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-home-landing.php'))),
        'position' => 'normal', 'style' => 'default', 'active' => true,
    ));
});

function oca_home_default_menu($args = array()) {
    echo '<ul class="' . esc_attr($args['menu_class'] ?? 'oca-menu') . '">';
    foreach (oca_home_menu_sections() as $id => $label) {
        echo '<li><a href="#' . esc_attr($id) . '">' . esc_html($label) . '</a></li>';
    }
    echo '</ul>';
}

function oca_home_menu_sections() {
    return array(
        'trang-chu' => 'Trang chủ',
        've-chung-toi' => 'Về OcaNew',
        'ly-do-lua-chon' => 'Lý do lựa chọn',
        'thanh-phan' => 'Thành phần',
        'cach-pha' => 'Quy trình pha',
        'cai-tien' => 'Cải tiến',
        'cau-hoi-thuong-gap' => 'Hỏi đáp',
        'hoi-chuyen-gia' => 'Hỏi chuyên gia',
    );
}
